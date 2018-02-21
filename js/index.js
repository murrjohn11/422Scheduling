$(document).ready(function(){

	var fcfs = true, fcfstoggle=false;
	var sjn = false, sjntoggle=false;
	var srt = false, srttoggle=false;
	var ps = false, pstoggle=false;
	var rr = false, rrtoggle=false;
	var mlq = false, mlqtoggle=false;

	$('#srt').hide();
	$('#sjn').hide();
	$('#ps').hide();
	$('#prio-th').hide();
	$('#rr').hide();
	$('#tab2').hide();
	$('#mlq').hide();

	function setMode(mode){
		switch(mode){
			case "fcfs": fcfs = true; sjn = false; ps = false; srt=false; rr=false; mlq=false;
						 $('#fcfs').show(); $('#sjn').hide(); $('#ps').hide(); $('#srt').hide(); $('#rr').hide(); $('#mlq').hide();  $('#tab2').hide();
						 $('#type-th-1').html("");
						 $('#type-th-2').html("");
						 break;
			case "sjn": fcfs = false; sjn = true; ps = false; srt=false; rr=false; mlq=false;
						 $('#fcfs').hide(); $('#sjn').show(); $('#ps').hide(); $('#srt').hide(); $('#rr').hide(); $('#mlq').hide(); $('#tab2').hide();
						 $('#type-th-1').html("");
						 $('#type-th-2').html("");
						 break;
			case "ps":  fcfs = false; sjn = false; ps = true; srt=false; rr=false; mlq=false;
						 $('#fcfs').hide(); $('#sjn').hide(); $('#ps').show(); $('#srt').hide(); $('#rr').hide(); $('#mlq').hide(); $('#tab2').hide();
						 $('#type-th-1').html("");
						 $('#type-th-2').html("");
						 break;
			case "srt": fcfs = false; sjn = false; ps = false; srt=true; rr=false; mlq=false;
 						 $('#fcfs').hide(); $('#sjn').hide(); $('#ps').hide(); $('#srt').show(); $('#rr').hide(); $('#mlq').hide(); $('#tab2').hide(); 
						 $('#type-th-1').html("");
						 $('#type-th-2').html("");
						 break;
			case "rr": 	fcfs = false; sjn = false; ps = false; srt=false; rr=true; mlq=false;
						 $('#fcfs').hide(); $('#sjn').hide(); $('#ps').hide(); $('#srt').hide(); $('#rr').show(); $('#mlq').hide(); $('#tab2').hide();	
						 $('#type-th-1').html("");
						 $('#type-th-2').html("");
						 break;		
			case "mlq":  fcfs = false; sjn = false; ps = false; srt=false; rr=false; mlq=true;
						 $('#fcfs').hide(); $('#sjn').hide(); $('#ps').hide(); $('#srt').hide(); $('#rr').hide(); $('#mlq').show(); $('#tab2').show();
						 $('#type-th-1').html("Foreground");
						 $('#type-th-2').html("Background"); 
						 break; 		 
		}
	}

	$('#fcfs-set').click(function(){
		setMode("fcfs");
		if(!fcfstoggle){
			$('#sjn-set').hide();
			$('#ps-set').hide();
			$('#srt-set').hide();
			$('#rr-set').hide();;
			$('#mlq-set').hide();
			fcfstoggle = true;
		}else{
			$('#sjn-set').show();
			$('#ps-set').show();
			$('#srt-set').show();
			$('#rr-set').show();
			$('#mlq-set').show();
			fcfstoggle = false;
		}
		$('#prio-th').hide();
	});

	$('#sjn-set').click(function(){
		setMode("sjn");
		if(!sjntoggle){
			$('#fcfs-set').hide();
			$('#ps-set').hide();
			$('#srt-set').hide();
			$('#rr-set').hide();;
			$('#mlq-set').hide();
			sjntoggle = true;
		}else{
			$('#fcfs-set').show();
			$('#ps-set').show();
			$('#srt-set').show();
			$('#rr-set').show();
			$('#mlq-set').show();
			sjntoggle = false;
		}
		$('#tbody-1').html("");
		$('#prio-th').hide();
	});

	$('#ps-set').click(function(){
		setMode("ps");
		if(!pstoggle){
			$('#sjn-set').hide();
			$('#fcfs-set').hide();
			$('#srt-set').hide();
			$('#rr-set').hide();;
			$('#mlq-set').hide();
			pstoggle = true;
		}else{
			$('#sjn-set').show();
			$('#fcfs-set').show();
			$('#srt-set').show();
			$('#rr-set').show();
			$('#mlq-set').show();
			pstoggle = false;
		}
		$('#prio-th').show();
	});

	$('#srt-set').click(function(){
		setMode("srt");
		if(!srttoggle){
			$('#sjn-set').hide();
			$('#ps-set').hide();
			$('#fcfs-set').hide();
			$('#rr-set').hide();
			$('#mlq-set').hide();
			srttoggle = true;
		}else{
			$('#sjn-set').show();
			$('#ps-set').show();
			$('#fcfs-set').show();
			$('#rr-set').show();
			$('#mlq-set').show();
			srttoggle = false;
		}
		$('#prio-th').show();
		$('#prio-th').html("Waiting Time");
	});

	$('#rr-set').click(function(){
		setMode("rr");
		if(!rrtoggle){
			$('#sjn-set').hide();
			$('#ps-set').hide();
			$('#fcfs-set').hide();
			$('#srt-set').hide();
			$('#mlq-set').hide();
			rrtoggle = true;
		}else{
			$('#sjn-set').show();
			$('#ps-set').show();
			$('#fcfs-set').show();
			$('#srt-set').show();
			$('#mlq-set').show();
			rrtoggle = false;
		}
		$('#tbody-1').html("");
		$('#prio-th').show();
		$('#prio-th').html("Waiting Time");
	});

	$('#mlq-set').click(function(){
		setMode("mlq");
		if(!mlqtoggle){
			$('#sjn-set').hide();
			$('#ps-set').hide();
			$('#fcfs-set').hide();
			$('#srt-set').hide();
			$('#rr-set').hide();
			mlqtoggle = true;
		}else{
			$('#sjn-set').show();
			$('#ps-set').show();
			$('#fcfs-set').show();
			$('#srt-set').show();
			$('#rr-set').show();
			mlqtoggle = false;
		}
		$('#tbody-1').html("");
		$('#prio-th').hide();
	});

	$('#fcfs-add').click(function(){
		if(fcfs){
			var input = $('#fcfs-input').val();
			$.post('/422B/input.php','fcfs-add='+input,function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
		}
	});

	$('#sjn-add').click(function(){
		if(sjn){
			var input = $('#sjn-input').val();
			$.post('/422B/input.php','sjn-add='+input,function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
		}
	});

	$('#ps-add').click(function(){
		if(ps){
			var input = $('#ps-input').val(),
				prio = $('#ps-input-priority').val();
			$.post('/422B/input.php','ps-add='+input+'&prio='+prio,function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td><td>"+element.priority+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
		}
	});

	$('#srt-add').click(function(){
		if(srt){
			var input = $('#srt-input').val();
			$.post('/422B/input.php','srt-add='+input,function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td><td>"+element.waitingtime+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
		}
	});

	$('#rr-add').click(function(){
		if(rr){
			var input = $('#rr-input').val();
			$.post('/422B/input.php','rr-add='+input,function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td><td>"+element.waitingtime+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
		}
	});

	$('#mlq-add').click(function(){
		if(mlq){
			var input = $('#mlq-input').val();
			var type = $('#mlq-type').val();
			$.post('/422B/input.php','mlq-add='+input+'&mlq-type='+type,function(response){
				var html = "", html2 = "",count=0;
				$.each(response,function(index,element){
					bursttime = element.executetime-1;
					remain = element.currenttime-1;
					if(element.type=="Foreground")
						html += "<tr><td>"+element.processorder+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					else{
						html2 += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime	+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
						count++;
					}
				});
				$('#tbody-1').html(html);
				$('#tbody-2').html(html2);
			},'json');
		}
	});

	$('#fcfs-reset').click(function(){
		$.post('/422B/input.php','fcfs-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	$('#sjn-reset').click(function(){
		$.post('/422B/input.php','sjn-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	$('#ps-reset').click(function(){
		$.post('/422B/input.php','ps-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	$('#srt-reset').click(function(){
		$.post('/422B/input.php','srt-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	$('#rr-reset').click(function(){
		$.post('/422B/input.php','rr-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	$('#mlq-reset').click(function(){
		$.post('/422B/input.php','mlq-reset=1',function(response){
			$('#tbody-1').html("");
		});
	});

	setInterval(function(){
		if(sjn){
			$.post('/422B/input.php','sjn-update=1',function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
			$.post('/422B/input.php','sjn-ave=1',function(response){
				$('#sjn-input-waiting').attr("value",response+" seconds");
			});
		}
		if(fcfs){
			$.post('/422B/input.php','fcfs-update=1',function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
			$.post('/422B/input.php','fcfs-ave=1',function(response){
				$('#fcfs-input-waiting').attr("value",response+" seconds");
			});
		}
		if(ps){
			$.post('/422B/input.php','ps-update=1',function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td><td>"+element.priority+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
			$.post('/422B/input.php','ps-ave=1',function(response){
				$('#ps-input-waiting').attr("value",response+" seconds");
			});
		}
		if(srt){
			$.post('/422B/input.php','srt-update=1',function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td><td>"+element.waitingtime+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
			$.post('/422B/input.php','srt-ave=1',function(response){
				$('#srt-input-waiting').attr("value",response+" seconds");
			});
		}
		if(rr){
			$.post('/422B/input.php','rr-update=1',function(response){
				var html = "", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					html += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td><td>"+element.waitingtime+"</td></tr>";
					count++;
				});
				$('#tbody-1').html(html);
			},'json');
			$.post('/422B/input.php','rr-ave=1',function(response){
				$('#rr-input-waiting').attr("value",response+" seconds");
			});
		}
		if(mlq){
			$.post('/422B/input.php','mlq-update=1',function(response){
				var html = "", html2="", count = 0;
				$.each(response,function(index,element){
					bursttime = element.executetime - 1;
					remain = element.currenttime - 1;
					if(element.type=="Foreground")
						html += "<tr><td>"+element.processorder+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
					else{ 
						html2 += "<tr><td>"+count+"</td><td>"+element.arrivaltime+"</td><td>"+bursttime+"</td><td>"+element.servicetime+"</td><td>"+element.finishtime+"</td><td>"+remain+"</td></tr>";
						count++;
					}
				});
				$('#tbody-1').html(html);
				$('#tbody-2').html(html2);			
			},'json');
		}
	},1000);

});