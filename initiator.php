<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Minipoll</title>
  <meta name="description" content="Minipoll, one question, cookie, time range">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/initiator.css"> 
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
  <script src="js/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="templates/minipolltemplate.inc.js"></script>
  <script src="templates/minipollresultstemplate.inc.js"></script>
  <script src="templates/minipollanswertemplate.inc.js"></script>
  <script src="templates/minipollanswerresulttemplate.inc.js"></script>
  
</head>

<body>
<div id="content"></div>
 <!--  --><script>
 // A $( document ).ready() block.
$( document ).ready(function() {
   //console.log( "ready!" );
   $.cookie.json = true;//Turn on automatic storage of JSON objects passed as the cookie value. Assumes JSON.stringify and JSON.parse:
   
   /* extend  standard javascript String object with method replaceObject (should be named replavePlaceholderInStringWithValuesOfProbertiesOfReplacerobject ;-)) */
   String.prototype.replaceObject = function(findreplaceobject) {
		 var replaceString = this;
		 //alert('eerste: ' + replaceString);
		keysarray=Object.getOwnPropertyNames(findreplaceobject);
		keysarray.map(function(item){
			 regex = new RegExp(item, "g");
			//alert(regex);
			 replaceString = replaceString.replace(regex, findreplaceobject[item]);
			 //alert(replaceString);
		});
		//alert(keysarray);
		return replaceString;
	};
	//now make a replacerobject that contains placeholder-value  pairs
	//now make a template with placeholders
	//using template.replaceObject(replacerobject) now will give a (html) string with placeholder replaced with the values
<?php ; 
if (isset($_GET['minipoll_id']) && is_numeric($_GET['minipoll_id'])) {
	$minipollidasked= (int) $_GET['minipoll_id'];$returnarray['minipollidasked']=$minipollidasked;
	echo "   minipollid =$minipollidasked ;\n";
}else{
	echo "   minipollid =\"empty\" ;\n";
	//$('#content').append('no minipoll_id no actionnn');\n
	//exit();//simple solution for now; stop the script: so use this only in iframe
}

//check for css file specific for this poll id in css directory
if(file_exists('css/'. $minipollidasked . '/minipoll.css')){//css/1/mini
    echo "$('head').append('  <link rel=\"stylesheet\" href=\"css/$minipollidasked/minipoll.css\">\\n');\n";
	//echo "alert(\"bestaat\");\n";
}else{
	echo "$('head').append('  <link rel=\"stylesheet\" href=\"css/minipolldefault.css\">\\n');\n";
	//echo "alert(\"bestaat niet\");\n";;
}
?>
    
	
	/**
	* create poll form html from data and templates.
	*
	* Function to generate the polling form: when not yet voted or poll not yet active
	*
	* @param object loadedjson Object containing minipoll data got from database
	* $param string disabled If == 'disabled' create diabled form
	* @return string returnhtml The complete html for the poll form
	*/
	function getradioshtml(loadedjson,disabled) {
		//console.log(loadedjson);
		if(disabled=='disabled'){//this is for when minipol is not yet active: show the poll, but disabled
		  disabledattr=" disabled=\"disabled\""	;
		}else{disabledattr="";}
		console.log(loadedjson.minipolldata[0].answers[1]);
		answershtml = "";
		//first get the answers...
		$.each(loadedjson.minipolldata[0].answers, function( index, value ) {
			//console.log( index);console.log( value );
			//object with placeholder replacers
			answerreplacerobject={"{{{mipoanswerid}}}":value['id'],
			                      "{{{ans_text}}}":value['ans_text']+"",
								  "{{{mipoquestionid}}}":value['ques_id'],
								  "{{{mipoid}}}":value['minipoll_id'],
								  "{{{disabledattr}}}":disabledattr
								  
								  };
			answershtml += minipollanswer_html_template.replaceObject(answerreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.j
			;
		});
		//alert(answershtml);
		//now create the containing html and insert answers therein
		minipollreplacerobject={"{{{minipollid}}}":""+ loadedjson.minipolldata[0].id + "",
		                        "{{{mipoheadtext}}}": loadedjson.minipolldata[0].minipoll_headtext,
								"{{{mipoquestion}}}":loadedjson.minipolldata[0].ques_name,
								"{{{answershtml}}}": answershtml
								};
		returnhtml = minipoll_html_template.replaceObject(minipollreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.js
		//answerreplacerobject={"{{{mipoanswerid}}}":""+ loadedjson.minipolldata[0].id + ""};
		//returnhtml += minipollanswer_html_template.replaceObject(answerreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.js
		return returnhtml;
	}
	
	/**
	* create poll results html from data and templates.
	*
	* Function to generate the polling results: when  already voted or poll not active anymore
	*
	* @param object loadedjson Object containing minipoll data got from database
	* $param string votedvalue String containing data identifying the question voted on by user
	* @return string returnhtml The complete html for the poll results
	*/
	function getresultshtml(loadedjson,votedvalue) {
		
		answerresultshtml = "";
		//console.log(loadedjson.minipolldata[0]);
		$.each(loadedjson.minipolldata[0].answers, function( index, value ) {
			//console.log( index);console.log( value );
			if(votedvalue == "ans"+value['id']+"_ques"+value['ques_id']+"_mipo" +value['minipoll_id']){votedthispart = " data-votedthis=\"votedthis\" ";votedthisclass=" votedthis "}else{votedthisclass="";votedthispart = " ";}
			answerresultreplacerobject={"{{{mipoanswerid}}}":value['id'],
			                      "{{{ans_text}}}":value['ans_text']+"",
								  "{{{mipoquestionid}}}":value['ques_id'],
								  "{{{mipoid}}}":value['minipoll_id'],
								  "{{{partvoted}}}":(100*value['answervotedpart']).toFixed(0),
								  "{{{votedthispart}}}":votedthispart,
								  "{{{votedthisclass}}}":votedthisclass
								  
								  
								  };
			answerresultshtml += minipollanswerresult_html_template.replaceObject(answerresultreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.j
			//console.log(value['answervotedpart']);
		});
		minipollresultsreplacerobject={"{{{minipollid}}}":""+ loadedjson.minipolldata[0].id + "",
		                        "{{{mipoheadtext}}}": loadedjson.minipolldata[0].minipoll_headtext,
								"{{{mipoquestion}}}": loadedjson.minipolldata[0].ques_name,
								"{{{answersresultshtml}}}": answerresultshtml
								};
		returnhtml = minipollresults_html_template.replaceObject(minipollresultsreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.js
		//returnhtml= "<div>resultshtml</div>";
		//returnhtml= answerresultshtml
		return returnhtml;
	}
	
	/**
	* function to bind event when inside callback. 
	*
	* bind on change event on dynamically created inputs
	*
	* @param object minipolldataobject Object containing minipoll data
	* @return void 
	* @sideeffect On change event listener on .minipoanswerinput with as effect calling ajaxvoteaction() 
	*/
	
	function minipollinputsetonchange(minipolldataobject) {
		
		/* this is inside function so that binding can occur in callback at the right moment*/
		$('.mipoanswerinput').on('change',function(){
			
			ajaxvoteaction($(this));
		
		});
	}
	
	
	/**
	* Perform ajax interaction with dovote.php delivering data concerning voting action
	*
	* @param dezehier object jQuery selector object indication input from poll form containing data
	*
	* @return void
	*
	* @sideeffect Ajax voting action, on succes, update cookies and call of ajaxgetpollarrayaction refreshing poll data, 
	*/
	function ajaxvoteaction(dezehier) {
		//alert(dezehier.parent().text());
		//console.log(minipolldataobject);
		$.ajax({
			//context: this,
			type: "POST",
			url: "dovote.php",
			dataType: "json",
			//data: { "minipollformid": minipolldataobject[0].id,"dataradioid": dataradioid, "questionvalue": questionvalue, "minipollcookiecontent":minipollcookiecontent }
			data: {"answertext": dezehier.parent().text(), "answervalue": dezehier.val() }
			//data: {"answertext": "adf", "answervalue": "adfasdf" }
		}).done(function( msg ) {
			
			//var minipolldataobject;
			console.log(msg.status);
			if(msg.status=="voted"){
				console.log('voted: set cookie, get new data and show results');
				$.cookie('mipo_set_status', 'mipo_poll_voted', { expires: 5*365 });
				$.cookie('mipo_set_data', msg.data.answervalue, { expires: 5*365 });
				console.log($.cookie('mipo_set_data'));
				console.log(minipollid);
				ajaxgetpollarrayaction();
			}
		});
		
	}
	
	/**
	* Get poll data, check cookies, decide what to show, show poll form or show poll results
	*
	* @return void
	*
	* @sideeffect Perform ajax interaction with getpollarray.php with GET parameter minipoll_id: 
	*             with returned data object and set cookies decide what to show: poll form of poll results etc
	*/
	function ajaxgetpollarrayaction() {
		
		 $.ajax({
			//context: this,
			type: "GET",
			url: "getpollarray.php?minipoll_id="+minipollid,
			dataType: "json",
			//data: { "minipollformid": minipollformid,"dataradioid": dataradioid, "questionvalue": questionvalue, "minipollcookiecontent":minipollcookiecontent }
		}).done(function( msg ) {
			//alert(msg);
			var loadedjson= msg;
			//console.log(loadedjson);
			//console.log(loadedjson.minipolldata[0].pollactivated);
			//console.log(loadedjson.minipolldata[0].pollexpired);
			if(loadedjson.minipolldata[0].pollactivated=="no"){
				//deactivate poll : give text/ show dactivated form radio buttons;
				//console.log("poll not active yet: show deactivated radios");
				radiohtml = getradioshtml(loadedjson,'disabled');
				$('div#content').html(radiohtml);
				$('.mipoanswerinput').addClass('disab');
			}else if(loadedjson.minipolldata[0].pollexpired=="yes"){
				//console.log('poll expired: show results');
				if(typeof($.cookie('mipo_set_data'))!== 'undefined'){
					votedfor = $.cookie('mipo_set_data');
				}else{votedfor ='error';}
				 //console.log($.cookie('mipo_set_data'));
				 resultshtml=getresultshtml(loadedjson,votedfor);
				$('div#content').html(resultshtml);
			}else{
				//console.log('check if already voted');
				if(typeof $.cookie('mipo_set_status') === 'undefined'){//not voted
					//console.log('not voted yet: show radios');
					radiohtml = getradioshtml(loadedjson);
					
					$('div#content').html(radiohtml);
					minipollinputsetonchange(loadedjson);//bind on - change event to minipoll form
	
				}else{
					
					//console.log('already voted: show results');
				   // alert($.cookie('mipo_set_data'));
					
					if(typeof($.cookie('mipo_set_data'))!== 'undefined'){
						votedfor = $.cookie('mipo_set_data');
					}else{votedfor ='error';}
					resultshtml=getresultshtml(loadedjson,votedfor);
					$('div#content').html(resultshtml);
				}
			}
		});
	}
	
	//depending on GET parameter minipoll_id javascript variable minipollid is filled...
	
   if(minipollid!=="empty"){
	   //console.log('doing something');
	   //ok , go on, get the data
	   ajaxgetpollarrayaction();
	  
		}else{//not ok : give message
			$('#content').html('no minipoll_id no action');
		}

});
 </script>

</body>
</html>