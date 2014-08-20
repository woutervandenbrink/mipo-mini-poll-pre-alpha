<?php 
//header('Content-type:text/plain'; charset=utf-8);
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');
header("Content-type: application/json; charset=utf-8");
ini_set('display_errors',0);
//ini_set('display_errors',1);
error_reporting(0);
$returnarray = array();
//error_reporting(E_ALL);
if (isset($_GET['minipoll_id']) && is_numeric($_GET['minipoll_id'])) {
	$minipollidasked= (int) $_GET['minipoll_id'];$returnarray['minipollidasked']= "$minipollidasked";
}else{
	$returnarray['errors']['error1']="no mini poll id found: please suplly minipoll id...";
	//print_r($returnarray);
	echo json_encode($returnarray);
	exit();//stop script
}

//get db connection, utf8
$mysqliconn = new mysqli('localhost', 'minipoll', 'minipoll', 'minipoll', '3306'); 
$mysqliconn->query("SET NAMES 'utf8'");


//get data for minipoll with the id
$firstquerystring ="
SELECT mipo_minipolls.id, mipo_minipolls.minipoll_name, mipo_minipolls.minipoll_headtext, mipo_minipolls.minipoll_tags, mipo_minipolls.minipoll_starttime, mipo_minipolls.minipoll_endtime, mipo_questions.id AS ques_id, mipo_questions.minipoll_id, mipo_questions.ques_name, mipo_questions.ques_comment, mipo_questions.tags AS ques_tags \n
FROM `mipo_minipolls` \n
LEFT OUTER JOIN mipo_questions ON mipo_minipolls.id = mipo_questions.minipoll_id \n
WHERE mipo_minipolls.id =$minipollidasked;
";
//echo $firstquerystring;
if($firstresult= $mysqliconn->query($firstquerystring)){
	if($firstresult->num_rows>0){
		while($rowfirstresult=$firstresult->fetch_assoc()){
				//print_r($rowfirstresult);
				$minipollsarray[]=$rowfirstresult;
			}
	}else{
		//poll with poll-id = #poll_id does not excis;
		$returnarray['errors']['error3']="minipoll_id $minipollidasked does not exist...";
		//print_r($returnarray);
	   echo  json_encode($returnarray);
		exit();//stop script
	}
}else{
	//some mysql error;
	$returnarray['errors']['error2']="some database error...";
	//print_r($returnarray);
	echo json_encode($returnarray);
	exit();//stop script
}
//print_r($minipollsarray);

//from collected data determine whether poll is active
 $timestampstart = strtotime($minipollsarray[0]['minipoll_starttime']);
 $timestampend = strtotime($minipollsarray[0]['minipoll_endtime']);
 if($timestampstart>time()){
 	//poll not active yet;
	$minipollsarray[0]['pollactivated'] = 'no';
 }else{
	//poll started
	$minipollsarray[0]['pollactivated'] = 'yes';
 }
 if($timestampend<time()){
	//poll not active anymore: only show results;
	$pollexpired =true;$minipollsarray[0]['pollexpired'] = 'yes';
 }else{
	//poll not expired yet
	$pollexpired =false;$minipollsarray[0]['pollexpired'] = 'no';
 }


//iterate over alle polls: it is only 1 ofcourse with 1 question
foreach($minipollsarray as $key1=>$value1){
	//get total votes for the question for this poll
	 $countallvotesforthisquestionquery ="SELECT COUNT(`id`) \n" .
"FROM `mipo_votes` \n" .
"WHERE `minpoll_id`= ". $value1['id'] ." \n" .
"AND `minpoll_ques_id`= " . $value1['ques_id']. "\n".
";";
    $questotalvotedcnt=$mysqliconn->query($countallvotesforthisquestionquery);
	while($rowquestotalvotedcnt=$questotalvotedcnt->fetch_assoc()){
		
		$minipollsarray[$key1]['questotalcnt']= "".$rowquestotalvotedcnt['COUNT(`id`)']. "";
	}

    //now get all answers for this question
	$querygetanswers = "SELECT mipo_answers.id, mipo_answers.ques_id, mipo_answers.minipoll_id, mipo_answers.ans_name, mipo_answers.ans_text, mipo_answers.tags, mipo_answers.order \n
FROM `mipo_answers` \n
WHERE mipo_answers.ques_id=". (int) $value1['ques_id'] .";
";
   if($querygetanswersresult= $mysqliconn->query($querygetanswers)){
	  if($querygetanswersresult->num_rows>0){
		  while($rowquerygetanswersresult=$querygetanswersresult->fetch_assoc()){
				//print_r($rowfirstresult);
				
				//get votes for this answer
				 $thisanswervotedcntquery ="SELECT COUNT(`id`) \n". 
										  "FROM `mipo_votes` \n" .
										  "WHERE `minpoll_answ_id`= " .$rowquerygetanswersresult['id'] . "\n" .
										  ";";
				$answervotedcntresult= $mysqliconn->query($thisanswervotedcntquery);
				while($answervotedcntresultrow=$answervotedcntresult->fetch_assoc()){
					//error_log(print_r($answervotedcntresultrow['COUNT(`id`)'],true));
					$rowquerygetanswersresult['answervotedcnt']="".$answervotedcntresultrow['COUNT(`id`)']. "";
					$rowquerygetanswersresult['answervotedpart'] ="". round(($answervotedcntresultrow['COUNT(`id`)']/$minipollsarray[$key1]['questotalcnt']),2) . "";
				}
				//print_r($answervotedcntresult);
				$minipollsarray[$key1]['answers'][]=$rowquerygetanswersresult;
			}
	  }else{
		  //no answers found;
		  $returnarray['errors']['error5']="no answers found for minipoll_id $minipollidasked does ...";
		  //print_r($returnarray);
	      echo json_encode($returnarray);
		  exit();//stop script
	  }
   }else{
	   //some mysqli error;
	   $returnarray['errors']['error4']="some database error...";
	   //print_r($returnarray);
	   echo json_encode($returnarray);
	   exit();//stop script
   }
}
$returnarray['minipolldata']=$minipollsarray;
//print_r($minipollsarray);
//print_r($returnarray);
echo json_encode($returnarray);
?>