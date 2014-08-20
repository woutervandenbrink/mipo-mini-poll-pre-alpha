<?php
//header('Content-type: text/plain');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');
header("Content-type: application/json; charset=utf-8");
ini_set('display_errors',0);
//ini_set('display_errors',1);
error_reporting(0);
if(isset($_POST['answervalue'])&&$_POST['answervalue']!=""){
	if(!(isset($_POST['answertext'])) || $_POST['answertext']==''){$_POST['answertext']='';}
	
	//make connection to database, utf-8
	$mysqliconn = new mysqli('localhost', 'minipoll', 'minipoll', 'minipoll', '3306'); 
	$mysqliconn->query("SET NAMES 'utf8'");

	//somehow newlines are given with some post parameters
	$answertext= mb_ereg_replace('\n','',$_POST['answertext']);
	$answervalue= mb_ereg_replace('\n','',$_POST['answervalue']);
	
	/* check format of $answervalue */
	if(mb_ereg('\Aans\d+_ques\d+_mipo\d+\Z',$answervalue)){
		;
		
		//remove evil html
		$answertext = strip_tags($answertext);
		$answervalue = strip_tags($answervalue);
		
		//get ids from $answervalue; checking of format should garantee that match variables are filled
		preg_match_all('/ans(\d+)/',$answervalue,$matches);
		$anserwer_id=(int)$matches[1][0];
		
		preg_match_all('/ques(\d+)/',$answervalue,$matches);
		$ques_id=(int)$matches[1][0];
		
		preg_match_all('/mipo(\d+)/',$answervalue,$matches);
		$mipo_id=(int)$matches[1][0];
		
		//check mipo_minipolls table to determine activity of poll
		$checkmipoquery = "
		SELECT * \n
		FROM `mipo_minipolls` \n
		WHERE `id`= $mipo_id 
		;";
		$checkarray = array();
		 if($checkmipoqueryresult = $mysqliconn->query($checkmipoquery)){
			 if($checkmipoqueryresult->num_rows>0){
				 while($checkmipoqueryresultrow=$checkmipoqueryresult->fetch_assoc()){
					 $checkarray[]=$checkmipoqueryresultrow;
				 };
			}else{
				//no minipol with id found;
				echo '{"status":"error","error_no":"1","error":"no minipoll with id = $mipo_id found"}';
				exit();
			};
		}else {
			//some database error;
			echo '{"status":"error","error_no":"2","error":"no minipoll with id = $mipo_id found: some database error"}';
			exit();
		}
		
		
		//print_r($checkarray);
		
		$timestampstart = strtotime($checkarray[0]['minipoll_starttime']);
		$timestampend = strtotime($checkarray[0]['minipoll_endtime']);
		if($timestampstart>time()){
			//poll not active yet;
			$pollactivated = 'no';
			echo '{"status":"error","error_no":"3","error":"minipoll with id = '. $mipo_id . ' not active yet"}';
			exit(); 
		}else{
			//poll started
			$pollactivated = 'yes';
		}
		if($timestampend<time()){
			//poll not active anymore: only show results;
			$pollexpired  = 'yes';
			echo '{"status":"error","error_no":"4","error":"minipoll with id = '. $mipo_id . ' expired"}';
			exit();
		}else{
			//poll not expired yet
			$pollexpired  = 'no';
		}
		
		if($pollactivated=="yes"&&$pollexpired=="no"){
		
			
			 $answertext = $mysqliconn->real_escape_string($answertext);echo "\n";
			 $answervalue = $mysqliconn->real_escape_string($answervalue);
		
			 $updatedvotesquery = "INSERT INTO `minipoll`.`mipo_votes` (
			`id` ,
			`minpoll_id` ,
			`minpoll_ques_id` ,
			`minpoll_answ_id` ,
			`answ_value` ,
			`minipoll_text` ,
			`user_id` ,
			`timstamp`
			)
			VALUES (
			NULL , '$mipo_id', '$ques_id', '$anserwer_id', '$answervalue', '$answertext', NULL ,
			CURRENT_TIMESTAMP
			);";
			
			if($updatedvotesqueryresult = $mysqliconn->query($updatedvotesquery)){
				//echo $mysqliconn->insert_id;
				if($mysqliconn->insert_id>0){
					echo '{"status":"voted","data":{"mipo_id":"'. $mipo_id. '", "ques_id":"'. $ques_id . '","answer_id":"'. $anserwer_id . '","answervalue":"'. $answervalue . '","answertext":"'. $answertext . '"}}';
					exit();
				}
				;
				
			}
		}
		
	}else{
		echo '{"status":"error","error_no":"0","error":"data wrong format for value"}';
		exit();
	};
	
}else{echo '{}';exit();}
 ?>