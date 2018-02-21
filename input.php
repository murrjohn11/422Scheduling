<?php
	include 'class/sql.php';

	$SQL = new SQL;

	if(isset($_POST['fcfs-add'])){
		if($_POST['fcfs-add']>=4){
			$SQL->addProcessFCFS($_POST['fcfs-add']+1,$SQL->getMicrotime());
		}
		$results = $SQL->getFCFS();
		echo json_encode($results);
	}else if(isset($_POST['fcfs-reset'])){
		$SQL->initFCFS();
		$results = $SQL->getFCFS();
		echo json_encode($results);
	}else if(isset($_POST['fcfs-update'])){
		$SQL->updateFCFS($SQL->getMicrotime());
		$results = $SQL->getFCFS();
		echo json_encode($results);	
	}else if(isset($_POST['sjn-add'])){
		$SQL->addProcessSJN($_POST['sjn-add']+1,$SQL->getMicrotime());
		$results = $SQL->getSJN();
		echo json_encode($results);
	}else if(isset($_POST['sjn-reset'])){
		$SQL->initSJN();
		$results = $SQL->getSJN();
		echo json_encode($results);
	}else if(isset($_POST['sjn-update'])){
		$SQL->updateSJN($SQL->getMicrotime());
		$results = $SQL->getSJN();
		echo json_encode($results);
	}else if(isset($_POST['ps-add'])){
		if($_POST['ps-add']>=4){
			$SQL->addProcessPS($_POST['ps-add']+1,$_POST['prio'],$SQL->getMicrotime());
		}$results = $SQL->getPS();
		echo json_encode($results);
	}else if(isset($_POST['ps-reset'])){
		$SQL->initPS();
		$results = $SQL->getPS();
		echo json_encode($results);
	}else if(isset($_POST['ps-update'])){
		$SQL->updatePS($SQL->getMicrotime());
		$results = $SQL->getPS();
		echo json_encode($results);
	}else if(isset($_POST['srt-add'])){
		if($_POST['srt-add']>=4)
			$SQL->addProcessSRT($_POST['srt-add']+1,$SQL->getMicrotime());
		$results = $SQL->getSRT();
		echo json_encode($results);
	}else if(isset($_POST['srt-reset'])){
		$SQL->initSRT();
		$results = $SQL->getSRT();
		echo json_encode($results);
	}else if(isset($_POST['srt-update'])){
		if(isset($_SESSION['current'])){
			$row = $SQL->checkSRT();
			if($row&&($row['arrivaltime']!=$_SESSION['current']||$row['processorder']!=$_SESSION['order'])){
				$SQL->updateCurrentServiceSRT($_SESSION['current'],$_SESSION['order'],$SQL->getMicrotime());
			}
		}
		$SQL->updateSRT($SQL->getMicrotime());
		$results = $SQL->getSRT();
		echo json_encode($results);
	}else if(isset($_POST['rr-add'])){
		if($_POST['rr-add']>=4)
			$SQL->addProcessRR($_POST['rr-add']+1,$SQL->getMicrotime());
		$results = $SQL->getRR();
		echo json_encode($results);
	}else if(isset($_POST['rr-reset'])){
		$SQL->initRR();
		$results = $SQL->getRR();
		echo json_encode($results);
	}else if(isset($_POST['rr-update'])){
		$SQL->refreshRROrder();
		if(isset($_SESSION['current'])){
			$row = $SQL->checkRR();
			if($row&&($row['arrivaltime']!=$_SESSION['current']||$row['processorder']!=$_SESSION['order'])){
				$SQL->updateCurrentServiceRR($_SESSION['current'],$_SESSION['order'],$SQL->getMicrotime());
			}
		}
		$SQL->updateRR($SQL->getMicrotime());
		$results = $SQL->getRR();
		echo json_encode($results);
	}else if(isset($_POST['mlq-add'])){
		if($_POST['mlq-add']>=4)
			$SQL->addProcessMLQ($_POST['mlq-add']+1,$_POST['mlq-type'],$SQL->getMicrotime());
		$results = $SQL->getMLQ();
		echo json_encode($results);
	}else if(isset($_POST['mlq-reset'])){
		$SQL->initMLQ();
		$results = $SQL->getMLQ();
		echo json_encode($results);
	}else if(isset($_POST['mlq-update'])){
		$SQL->refreshMLQOrder();
		$SQL->updateMLQ($SQL->getMicrotime());
		$results = $SQL->getMLQ();
		echo json_encode($results);	
	}else if(isset($_POST['fcfs-ave'])){
		echo $SQL->getAveFCFS();
	}else if(isset($_POST['sjn-ave'])){
		echo $SQL->getAveSJN();	
	}else if(isset($_POST['ps-ave'])){
		echo $SQL->getAvePS();
	}else if(isset($_POST['srt-ave'])){
		echo $SQL->getAveSRT();
	}else if(isset($_POST['rr-ave'])){
		echo $SQL->getAveRR();
	}
