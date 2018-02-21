<?php
	date_default_timezone_set('Asia/Manila');

	session_start();

	class SQL{
		private $conn;
		public function __construct(){
			$this->conn = new mysqli("localhost","root","Codeusctc","scheduling");
		}
		public function initFCFS(){
			$sql = "DELETE FROM fcfs WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		public function initSJN(){
			$sql = "DELETE FROM sjn WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		public function initPS(){
			$sql = "DELETE FROM ps WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		public function initSRT(){
			$sql = "DELETE FROM srt WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		public function initRR(){
			$sql = "DELETE FROM rr WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		public function initMLQ(){
			$sql = "DELETE FROM mlq WHERE 1";
			$query = mysqli_query($this->conn,$sql);
		}
		public function getMicrotime(){
			$time = microtime();
			$string = explode(' ', $time);
			$time = $string[1];
			return $time;
		}
		public function addProcessFCFS($process,$time){
			if($process<4) return false;
			$sql = "SELECT * FROM fcfs WHERE 1";
			$query = mysqli_query($this->conn,$sql);
			$sql = "INSERT INTO fcfs (`arrivaltime`,`executetime`,`currenttime`,`processorder`) VALUES ('".$time."','".$process."','".$process."','".mysqli_num_rows($query)."')";
			$query = mysqli_query($this->conn,$sql);
			return $query;
		}
		public function addProcessSRT($process,$time){
			if($process<4) return false;
			$sql = "SELECT * FROM srt WHERE finishtime='0'";
			$query = mysqli_query($this->conn,$sql);
			$sql = "INSERT INTO srt (`checktime`,`arrivaltime`,`executetime`,`currenttime`,`processorder`) VALUES ('".$time."','".$time."','".$process."','".$process."','".mysqli_num_rows($query)."')";
			$query = mysqli_query($this->conn,$sql);
			if(!$query) echo mysqli_error($this->conn);
			return $query;
		}
		public function addProcessSJN($process,$time){
			if($process<4) return false;
			$sql = "SELECT * FROM sjn WHERE finishtime='0'";
			$sql_s = "SELECT * FROM sjn WHERE status='successor'";
			$query = mysqli_query($this->conn,$sql);
			$query_s = mysqli_query($this->conn,$sql_s);
			if(mysqli_num_rows($query)==0&&mysqli_num_rows($query_s)==0) 
				$status='successor';
			else $status='';
			$sql = "INSERT INTO sjn (`status`,`arrivaltime`,`executetime`,`currenttime`,`processorder`) VALUES ('".$status."','".$time."','".$process."','".$process."','".mysqli_num_rows($query)."')";
			$query = mysqli_query($this->conn,$sql);
			return $query;	
		}
		public function addProcessRR($process,$time){
			if($process<4) return false;
			$sql = "SELECT * FROM rr WHERE finishtime='0'";
			$sql_s = "SELECT * FROM rr WHERE status='successor'";
			$sql_t = "SELECT * FROM rr WHERE 1";
			$query = mysqli_query($this->conn,$sql);
			$query_s = mysqli_query($this->conn,$sql_s);
			$query_t = mysqli_query($this->conn,$sql_t);
			if(mysqli_num_rows($query_t)==0){
				session_destroy();
				session_start();
			}
			if(mysqli_num_rows($query)==0&&mysqli_num_rows($query_s)==0) 
				$status='successor';
			else $status='';
			$sql = "INSERT INTO rr (`checktime`,`status`,`arrivaltime`,`executetime`,`currenttime`,`processorder`) VALUES ('".$time."','".$status."','".$time."','".$process."','".$process."','".mysqli_num_rows($query)."')";
			$query = mysqli_query($this->conn,$sql);
			return $query;	
		}
		public function addProcessPS($process,$priority,$time){
			if($process<4) return false;
			$sql = "SELECT * FROM ps WHERE finishtime='0'";
			$sql_s = "SELECT * FROM ps WHERE status='successor'";
			$query = mysqli_query($this->conn,$sql);
			$query_s = mysqli_query($this->conn,$sql_s);
			if(mysqli_num_rows($query)==0&&mysqli_num_rows($query_s)==0) 
				$status='successor';
			else $status='';
			$sql = "INSERT INTO ps (`status`,`arrivaltime`,`executetime`,`currenttime`,`processorder`,`priority`) VALUES ('".$status."','".$time."','".$process."','".$process."','".mysqli_num_rows($query)."','".$priority."')";
			$query = mysqli_query($this->conn,$sql);
			if(!$query) echo mysqli_error($this->conn);
		}
		public function addProcessMLQ($process,$type,$time){
			if($process<4) return false;
			$sql_f = "SELECT * FROM mlq WHERE type='Background' AND finishtime='0'";
			$sql = "SELECT * FROM mlq WHERE type='".$type."'";
			if($type=='Background'){
				$query_f = mysqli_query($this->conn,$sql_f);
				$order = mysqli_num_rows($query_f);
				if($order==0) $status="successor";
				else $status="";
			}else{
				$status="";
				$query = mysqli_query($this->conn,$sql);
				$order = mysqli_num_rows($query);
			}
			$sql = "INSERT INTO mlq (`status`,`arrivaltime`,`executetime`,`currenttime`,`processorder`,`type`) VALUES ('".$status."','".$time."','".$process."','".$process."','".$order."','".$type."')";
			$query = mysqli_query($this->conn,$sql);
			if(!$query) echo mysqli_error($this->conn);
		}
		public function updateFCFS($reftime){
			$sql = "SELECT * FROM fcfs WHERE finishtime='0' ORDER BY processorder ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				if($row['finishtime']==0){
					$time = $row['currenttime']-1;
					$order = $row['processorder'];
					if($row['currenttime']==$row['executetime']&&$time==0){
						$sql = "UPDATE fcfs SET servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else if($row['currenttime']==$row['executetime'])
						$sql = "UPDATE fcfs SET servicetime	='".$reftime."' ,currenttime='".$time."' WHERE processorder='".$order."'";
					else if($time==0){
						$sql = "UPDATE fcfs SET finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else{
						$sql = "UPDATE fcfs SET currenttime='".$time."' WHERE processorder='".$order."'";
					}
					mysqli_query($this->conn,$sql);
				return true;					}
			}else return false;
		}
		public function getFCFS(){
			$sql = "SELECT * FROM fcfs WHERE 1 ORDER BY processorder ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		public function initializeMLQSuccessor(){
			$sql = "SELECT * FROM mlq WHERE type='Background' AND processorder='0'";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				$sql = "UPDATE mlq SET status='successor' WHERE type='Background' AND processorder='".$row['processorder']."'";
				mysqli_query($this->conn,$sql);
				return true;
			}else return false;
		}
		public function updateSJN($reftime){
			$sql2 = "SELECT * FROM sjn WHERE finishtime='0' ORDER BY executetime ASC";
			$sql = "SELECT * FROM sjn WHERE status='successor'";
			$query = mysqli_query($this->conn,$sql);
			$query2 = mysqli_query($this->conn,$sql2);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				$row2 = mysqli_fetch_assoc($query2);
				if($row['processorder']==$row2['processorder']&&$row['arrivaltime']==$row2['arrivaltime']){
					$row2 = mysqli_fetch_assoc($query2);
				}
				$time = $row['currenttime']-1;
				$order = $row['processorder'];
				$arrival = $row['arrivaltime'];
				if($row['currenttime']==$row['executetime']&&$time==0){
					$sql = "UPDATE sjn SET servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."' AND arrivaltime='".$arrival."'";
				}else if($row['currenttime']==$row['executetime'])
					$sql = "UPDATE sjn SET servicetime	='".$reftime."' ,currenttime='".$time."' WHERE processorder='".$order."' AND arrivaltime='".$arrival."'";
				else if($time==0){
					$sql = "UPDATE sjn SET status='successor' WHERE arrivaltime='".$row2['arrivaltime']."' AND processorder='".$row2['processorder']."'";
					mysqli_query($this->conn,$sql);
					$sql = "UPDATE sjn SET status='',processorder='-1',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."' AND arrivaltime='".$arrival."'";
				}else{
					$sql = "UPDATE sjn SET currenttime='".$time."' WHERE processorder='".$order."' AND arrivaltime='".$arrival."'";
				}
				mysqli_query($this->conn,$sql);
				return true;				
			}return false;
		}
		public function getSJN(){
			$sql = "SELECT * FROM sjn WHERE 1 ORDER BY arrivaltime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		public function updatePS($reftime){
			$sql2 = "SELECT * FROM ps WHERE finishtime='0' ORDER BY priority ASC";
			$sql = "SELECT * FROM ps WHERE status='successor'";
			$query = mysqli_query($this->conn,$sql);
			$query2 = mysqli_query($this->conn,$sql2);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				$row2 = mysqli_fetch_assoc($query2);
				if($row['processorder']==$row2['processorder']&&$row['arrivaltime']==$row2['arrivaltime']){
					$row2 = mysqli_fetch_assoc($query2);
				}
				$time = $row['currenttime']-1;
				$order = $row['processorder'];
				$arrival = $row['arrivaltime'];
				if($row['currenttime']==$row['executetime']&&$time==0){
					$sql = "UPDATE ps SET servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}else if($row['currenttime']==$row['executetime'])
					$sql = "UPDATE ps SET servicetime	='".$reftime."' ,currenttime='".$time."' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				else if($time==0){
					$sql = "UPDATE ps SET status='successor' WHERE arrivaltime='".$row2['arrivaltime']."' AND processorder='".$row2['processorder']."'";
					mysqli_query($this->conn,$sql);
					$sql = "UPDATE ps SET status='',finishtime='".$reftime."' ,currenttime='1' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}else{
					$sql = "UPDATE ps SET currenttime='".$time."' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}
				mysqli_query($this->conn,$sql);
				return true;				
			}return false;
		}
		public function getPS(){
			$sql = "SELECT * FROM ps WHERE 1 ORDER BY arrivaltime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		public function checkSRT(){
			$sql = "SELECT * FROM srt WHERE finishtime='0' ORDER BY currenttime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0) return mysqli_fetch_assoc($query);
			else return false;
		}
		public function updateCurrentServiceSRT($current,$order){
			$sql = "SELECT * FROM srt WHERE arrivaltime='".$current."' AND processorder='".$order."'";
			$query = mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_assoc($query);
			$waitingtime = $row['waitingtime']+$row['servicetime']-$row['checktime'];
			$sql = "UPDATE srt SET waitingtime='".$waitingtime."', currentservice='0', checktime='".$_SESSION['time']."' WHERE arrivaltime='".$current."' AND processorder='".$order."'";
			mysqli_query($this->conn,$sql);
		}
		public function updateSRT($reftime){
			$sql = "SELECT * FROM srt WHERE finishtime='0' ORDER BY currenttime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				$time = $row['currenttime']-1;
				$order = $row['processorder'];
				$arrival = $row['arrivaltime'];
				if($row['currentservice']==0&&$time==0){
					$sql = "UPDATE srt SET currentservice='1', servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}else if($row['currentservice']==0){
					$sql = "UPDATE srt SET currentservice='1', servicetime='".$reftime."' ,currenttime='".$time."' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}else if($time==0&&mysqli_num_rows($query)==1){
					$waitingtime = $row['waitingtime']+$row['servicetime']-$row['checktime'];
					$sql = "UPDATE srt SET waitingtime='".$waitingtime."',finishtime='".$reftime."' ,currenttime='1' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}else if($time==0){
					$sql = "UPDATE srt SET finishtime='".$reftime."' ,currenttime='1' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}else{
					$sql = "UPDATE srt SET currenttime='".$time."' WHERE arrivaltime='".$arrival."' AND processorder='".$order."'";
				}
				mysqli_query($this->conn,$sql);
				$_SESSION['current']=$row['arrivaltime'];
				$_SESSION['order']=$row['processorder'];
				$_SESSION['time']=$reftime;
				$_SESSION['turnaround']=$time;
				return true;
			}return false;
		}
		public function getSRT(){
			$sql = "SELECT * FROM srt WHERE 1 ORDER BY arrivaltime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		public function checkRR(){
			$sql = "SELECT * FROM rr WHERE status='successor'";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0) return mysqli_fetch_assoc($query);
			else return false;
		}
		public function updateCurrentServiceRR($current,$order){
			$sql = "SELECT * FROM rr WHERE arrivaltime='".$current."' AND processorder='".$order."'";
			$query = mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_assoc($query);
			$waitingtime = $row['waitingtime']+$row['servicetime']-$row['checktime'];
			$sql = "UPDATE rr SET waitingtime='".$waitingtime."', currentservice='0', checktime='".$_SESSION['time']."' WHERE arrivaltime='".$current."' AND processorder='".$order."'";
			mysqli_query($this->conn,$sql);
		}
		public function updateRR($reftime){
			$sql0 = "SELECT * FROM rr WHERE finishtime='0'";
			$query0 = mysqli_query($this->conn,$sql0);
			$sql = "SELECT * FROM rr WHERE status='successor'";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$row = mysqli_fetch_assoc($query);
				$successor = $row['processorder']+1;
				if($successor>=mysqli_num_rows($query0)){
					$successor = 0;
				}
				$time = $row['currenttime']-1;
				$order = $row['processorder'];
				$arrival = $row['arrivaltime'];
				$sql = "UPDATE rr SET status='' WHERE processorder='".$order."'";
				mysqli_query($this->conn,$sql);
				$sql = "UPDATE rr SET status='successor' WHERE processorder='".$successor."'";
				mysqli_query($this->conn,$sql);
				if($row['finishtime']==0){	
					if($row['currentservice']==0&&$time==0){
						$sql = "UPDATE rr SET currentservice='1',servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else if($row['currentservice']==0)
						$sql = "UPDATE rr SET currentservice='1',servicetime='".$reftime."' ,currenttime='".$time."' WHERE processorder='".$order."'";
					else if($time==0&&mysqli_num_rows($query0)==1){
						$waitingtime = $row['waitingtime']+$row['servicetime']-$row['checktime'];
						$sql = "UPDATE rr SET waitingtime='".$waitingtime."',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else if($time==0){
						$sql = "UPDATE rr SET status='',finishtime='".$reftime."' ,currenttime='1' WHERE processorder='".$order."'";
					}else{
						$sql = "UPDATE rr SET currenttime='".$time."' WHERE processorder='".$order."'";
					}
					mysqli_query($this->conn,$sql);
				}
				$_SESSION['current']=$row['arrivaltime'];
				$_SESSION['order']=$row['processorder'];
				$_SESSION['time']=$reftime;
				$_SESSION['turnaround']=$time;
				return true;				
			}return false;
		}
		public function refreshRROrder(){
			$sql = "SELECT * FROM rr WHERE 1";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$count = 0;
				while($row=mysqli_fetch_assoc($query)){
					if($row['finishtime']=='0'){
						$sql = "UPDATE rr SET processorder='".$count."' WHERE arrivaltime='".$row['arrivaltime']."'";
						$count++;
					}else{
						$sql = "UPDATE rr SET processorder='-1' WHERE arrivaltime='".$row['arrivaltime']."'";
					}
					mysqli_query($this->conn,$sql);
				}
				return true;
			}else return false;
		}
		public function getRR(){
			$sql = "SELECT * FROM rr WHERE 1 ORDER BY arrivaltime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		public function updateMLQ($reftime){
			$sql0 = "SELECT * FROM mlq WHERE type='Foreground' AND finishtime='0' ORDER BY arrivaltime ASC";
			$query0 = mysqli_query($this->conn,$sql0);
			$sql_f = "SELECT * FROM mlq WHERE type='Background' AND finishtime='0' ORDER BY arrivaltime ASC";
			$query_f = mysqli_query($this->conn,$sql_f);
			$sql_s = "SELECT * FROM mlq WHERE type='Background' AND status='successor'";
			$query_s = mysqli_query($this->conn,$sql_s);
			if(mysqli_num_rows($query_s)>0&&mysqli_num_rows($query_f)>0){
				$row = mysqli_fetch_assoc($query_s);
				$successor = $row['processorder']+1;
				if($successor>=mysqli_num_rows($query_f)){
					$successor = 0;
				}
				$time = $row['currenttime']-1;
				$order = $row['processorder'];
				$sql = "UPDATE mlq SET status='' WHERE type='Background' AND processorder='".$order."'";
				mysqli_query($this->conn,$sql);
				$sql = "UPDATE mlq SET status='successor' WHERE type='Background' AND processorder='".$successor."'";
				mysqli_query($this->conn,$sql);
				if($row['finishtime']==0){	
					if($row['currentservice']==0&&$time==0){
						$sql = "UPDATE mlq SET currentservice='1',servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE type='Background' AND processorder='".$order."'";
					}else if($row['currentservice']==0)
						$sql = "UPDATE mlq SET currentservice='1',servicetime='".$reftime."' ,currenttime='".$time."' WHERE type='Background' AND processorder='".$order."'";
					else if($time==0){
						$sql = "UPDATE mlq SET status='',finishtime='".$reftime."' ,currenttime='1' WHERE type='Background' AND processorder='".$order."'";
					}else{
						$sql = "UPDATE mlq SET currenttime='".$time."' WHERE type='Background' AND processorder='".$order."'";
					}
					mysqli_query($this->conn,$sql);
				}
				return true;								
			}else if(mysqli_num_rows($query0)>0){
				$row = mysqli_fetch_assoc($query0);
				$time = $row['currenttime']-1;
				$order = $row['processorder'];
				if($row['currenttime']==$row['executetime']&&$time==0){
					$sql = "UPDATE mlq SET servicetime='".$reftime."',finishtime='".$reftime."' ,currenttime='1' WHERE type='Foreground' AND processorder='".$order."'";
				}else if($row['currenttime']==$row['executetime'])
					$sql = "UPDATE mlq SET servicetime	='".$reftime."' ,currenttime='".$time."' WHERE type='Foreground' AND processorder='".$order."'";
				else if($time==0){
					$sql = "UPDATE mlq SET finishtime='".$reftime."' ,currenttime='1' WHERE type='Foreground' AND processorder='".$order."'";
				}else{
					$sql = "UPDATE mlq SET currenttime='".$time."' WHERE type='Foreground' AND processorder='".$order."'";
				}
				mysqli_query($this->conn,$sql);
				return true;
			}else return false;
		}
		public function refreshMLQOrder(){
			$sql = "SELECT * FROM mlq WHERE type='Background'";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$count = 0;
				while($row=mysqli_fetch_assoc($query)){
					if($row['finishtime']=='0'){
						$sql = "UPDATE mlq SET processorder='".$count."' WHERE type='Background' AND arrivaltime='".$row['arrivaltime']."'";
						$count++;
					}else{
						$sql = "UPDATE mlq SET processorder='-1' WHERE type='Background' AND arrivaltime='".$row['arrivaltime']."'";
					}
					$query_s = mysqli_query($this->conn,$sql);
					if(!$query_s) echo mysqli_error($this->conn);
				}
				return true;
			}else return false;
		}
		public function getMLQ(){
			$sql = "SELECT * FROM mlq WHERE 1 ORDER BY arrivaltime ASC";
			$query = mysqli_query($this->conn,$sql);
			if(mysqli_num_rows($query)>0){
				$itemArray = array();
				while($row = mysqli_fetch_assoc($query)){
					array_push($itemArray, $row);
				}
				return $itemArray;
			}else return false;
		}
		public function getAveFCFS(){
			$sql = "SELECT * FROM fcfs WHERE finishtime!='0'";
			$sum = 0;
			$query = mysqli_query($this->conn,$sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				while($row=mysqli_fetch_assoc($query)){
					$diff = $row['servicetime']-$row['arrivaltime'];
					$sum += $diff;
				}
				return $sum/$rows;
			}else return false;
		}
		public function getAveSJN(){
			$sql = "SELECT * FROM sjn WHERE finishtime!='0'";
			$sum = 0;
			$query = mysqli_query($this->conn,$sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				while($row=mysqli_fetch_assoc($query)){
					$diff = $row['servicetime']-$row['arrivaltime'];
					$sum += $diff;
				}
				return $sum/$rows;
			}else return false;
		}
		public function getAvePS(){
			$sql = "SELECT * FROM ps WHERE finishtime!='0'";
			$sum = 0;
			$query = mysqli_query($this->conn,$sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				while($row=mysqli_fetch_assoc($query)){
					$diff = $row['servicetime']-$row['arrivaltime'];
					$sum += $diff;
				}
				return $sum/$rows;
			}else return false;
		}
		public function getAveSRT(){
			$sql = "SELECT * FROM srt WHERE finishtime!='0'";
			$sum = 0;
			$query = mysqli_query($this->conn,$sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				while($row=mysqli_fetch_assoc($query)){
					$sum += $row['waitingtime'];
				}
				return $sum/$rows;
			}else return false;
		}
		public function getAveRR(){
			$sql = "SELECT * FROM rr WHERE finishtime!='0'";
			$sum = 0;
			$query = mysqli_query($this->conn,$sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				while($row=mysqli_fetch_assoc($query)){
					$sum += $row['waitingtime'];
				}
				return $sum/$rows;
			}else return false;
		}
	}
