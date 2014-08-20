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
	exit();//simple solution for now; stop the script
}

//check for css file specific for this poll id in css directory
if(file_exists('css/'. $minipollidasked . '/minipoll.css')){//css/1/mini
    echo "$('head').append('  <link rel=\"stylesheet\" href=\"css/$minipollidasked/minipoll.css\">\\n');\n";
	//echo "alert(\"bestaat\");\n";
}else{
	echo "$('head').append('  <link rel=\"stylesheet\" href=\"css/minipolldefault.css\">\\n');\n";
	echo "alert(\"bestaat niet\");\n";;
}
?>
    function getradioshtml(loadedjson) {
		//console.log(loadedjson);
		console.log(loadedjson.minipolldata[0].answers[1]);
		answershtml = "";
		$.each(loadedjson.minipolldata[0].answers, function( index, value ) {
			console.log( index);console.log( value );
			answerreplacerobject={"{{{mipoanswerid}}}":value['id'],
			                      "{{{ans_text}}}":value['ans_text']+"",
								  "{{{mipoquestionid}}}":value['ques_id'],
								  "{{{mipoid}}}":value['minipoll_id']
								  
								  };
			answershtml += minipollanswer_html_template.replaceObject(answerreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.j
			;
		});
		//alert(answershtml);
		minipollreplacerobject={"{{{minipollid}}}":""+ loadedjson.minipolldata[0].id + "",
		                        "{{{mipoheadtext}}}": loadedjson.minipolldata[0].minipoll_headtext,
								"{{{answershtml}}}": answershtml
								};
		returnhtml = minipoll_html_template.replaceObject(minipollreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.js
		//answerreplacerobject={"{{{mipoanswerid}}}":""+ loadedjson.minipolldata[0].id + ""};
		//returnhtml += minipollanswer_html_template.replaceObject(answerreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.js
		return returnhtml;
	}
	function getresultshtml(loadedjson) {
		answerresultshtml = "";
		
		$.each(loadedjson.minipolldata[0].answers, function( index, value ) {
			console.log( index);console.log( value );
			answerresultreplacerobject={"{{{mipoanswerid}}}":value['id'],
			                      "{{{ans_text}}}":value['ans_text']+"",
								  "{{{mipoquestionid}}}":value['ques_id'],
								  "{{{mipoid}}}":value['minipoll_id'],
								  "{{{partvoted}}}":(100*value['answervotedpart']).toFixed(0)
								  
								  };
			answerresultshtml += minipollanswerresult_html_template.replaceObject(answerresultreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.j
			console.log(value['answervotedpart']);
		});
		minipollresultsreplacerobject={"{{{minipollid}}}":""+ loadedjson.minipolldata[0].id + "",
		                        "{{{mipoheadtext}}}": loadedjson.minipolldata[0].minipoll_headtext,
								"{{{answersresultshtml}}}": answerresultshtml
								};
		returnhtml = minipollresults_html_template.replaceObject(minipollresultsreplacerobject);//minipollanswer_html_template is from templates/minipollanswertemplate.inc.js
		//returnhtml= "<div>resultshtml</div>";
		//returnhtml= answerresultshtml
		return returnhtml;
	}
	
	
	function minipollinputsetonchange(minipolldataobject) {
		//alert('dezehier dan');
		/* this is inside function so that binding can occur in callback at the right moment*/
		$('.mipoanswerinput').on('change',function(){
			//alert('iets');
			//alert($(this).val());
			//alert($(this).parent().html());
			ajaxvoteaction($(this));
		
		});
	}
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
	
	function ajaxgetpollarrayaction() {
		alert("ploef");;
		 $.ajax({
			//context: this,
			type: "GET",
			url: "getpollarray.php?minipoll_id="+minipollid,
			dataType: "json",
			//data: { "minipollformid": minipollformid,"dataradioid": dataradioid, "questionvalue": questionvalue, "minipollcookiecontent":minipollcookiecontent }
		}).done(function( msg ) {
			//alert(msg);
			var loadedjson= msg;
			console.log(loadedjson);
			console.log(loadedjson.minipolldata[0].pollactivated);
			console.log(loadedjson.minipolldata[0].pollexpired);
			if(loadedjson.minipolldata[0].pollactivated=="no"){
				//deactivate poll : give text/ show dactivated form radio buttons;
				console.log("poll not active yet: show deactivated radios");
			}else if(loadedjson.minipolldata[0].pollexpired=="yes"){
				console.log('poll expired: show results');;
			}else{
				console.log('check if already voted');
				if(typeof $.cookie('mipo_set_status') === 'undefined'){//not voted
					console.log('not voted yet: show radios');
					radiohtml = getradioshtml(loadedjson);
					
					$('div#content').html(radiohtml);
					minipollinputsetonchange(loadedjson);//bind on - change event to minipoll form
					//$('.mipoanswerinput').on('change',function(){
						//alert('iets');
						//alert($(this).val());
					
					//});
					
					
					
				}else{
					console.log('already voted: show results');
					resultshtml=getresultshtml(loadedjson);
					$('div#content').html(resultshtml);
				}
			}
		});
	}
	
	
   if(minipollid!=="empty"){
	   console.log('doing something');
	   //make this to function ajaxgetpollarrayaction();
	   ajaxgetpollarrayaction();
	  
		}else{
			document.write('no minipoll_id no action');;
		}

});
 </script>

</body>
</html>