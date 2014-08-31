<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Minipoll Creator Wizzard</title>
  <meta name="description" content="Minipoll, one question, cookie, time range: minipoll creation wizzard">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="../css/initiator.css"> 
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
  <script src="../js/jquery/2.1.1/jquery.min.js"></script>
  <script src="../js/jquery.cookie.js"></script>
  <script src="../templates/minipollcreateminipolltemplate.inc.js"></script>
  <script src="../templates/minipollcreateminipollstep1inputtemplate.inc.js"></script>
  <script src="../templates/minipollanswertemplate.inc.js"></script>
  <script src="../templates/minipollanswerresulttemplate.inc.js"></script>
  
</head>

<body>
<div id="wizcontent">create mipo minipoll</div>
 <!--  --><script>

 // A $( document ).ready() block.
$( document ).ready(function() {
	minipollcreatedata={};
	newminipollidincrementer=0;
	 function checkinputfield(inputfield){
		 console.log(inputfield.val());console.log(inputfield.attr('name'));console.log(inputfield.attr('data-tempid'));console.log('checkinputfield');
		 if(inputfield.attr('name')=='minipollname'){
			if(inputfield.val()!=''){ return true;}else{return false;}
			 //doe test voor minipollname;
		}else if(inputfield.attr('name')=='minipollheadtext'){
			//doe test voor minipollheadtext ;
			if(inputfield.val()!=''){ return true;}else{return false;}
		}else if(inputfield.attr('name')=='minipollstarttime'){
			//doe test voor minipollstarttime ;
			if(inputfield.val()!=''){ return true;}else{return false;}
		}else if(inputfield.attr('name')=='minipollendtime'){
			//doe test voor minipollendtime ;
			if(inputfield.val()!=''){ return true;}else{return false;}
		}else if(inputfield.attr('name')=='minipollquesname'){
			//doe test voor minipollquesname ;
			if(inputfield.val()!=''){ return true;}else{return false;}
		}
		else if(inputfield.attr('name')=='minipollquescomment'){
			//doe test voor minipollquescomment ;
			if(inputfield.val()!=''){ return true;}else{return false;}
		}else if(inputfield.attr('name')=='minipollquestags'){
			//doe test voor minipollquestags ;
			if(inputfield.val()!=''){ return true;}else{return false;}
		}else{
			if(inputfield.val()!=''){ return true;}else{return false;};
		}
		
	 }
	 function get_start_html(){
		 
		 returnhtml = minipollcreateminipoll_html_template;//from ../templates/minipollcreateminipolltemplate.inc.js
		 
		 return returnhtml;
	 };
	 function get_step1input_html(tempmipoid){
		 minipollcreatedata[tempmipoid]={"tempmipoid":tempmipoid};
		 createminipollstep1replacerobject={"{{{newmipoid}}}":tempmipoid

								  };
		 returnhtml = minipollcreateminipollstep1input_html_template.replaceObject(createminipollstep1replacerobject);//from ../templates/minipollcreateminipolltemplate.inc.js
		 return returnhtml;
	 };
	 $('#wizcontent').html(get_start_html());
	 
	 /* click on button :: */
	 $('#dynacontentroot').one('click.dynacontentroot',function(){//binding is unset at first event of click
		 newminipollidincrementer+=1;// should happen only once in this scheme
		 /* get html from filledin template */
		newminipoll_html = get_step1input_html(newminipollidincrementer);
	 	
		/** put htm of step 1 in place: only 1 input is vissible, displayed now */
		$(this,'#dynacontentroot').append(newminipoll_html);
		
		/* fill up data object minipollcreatedata using newminipoll_html to find keys and set start value ("-") */
		$(this,'#dynacontentroot').find('.minipollinput').each(function( index ) {// find creates a collection: each() iterates over this collection
			$( this ).css("color", "red");//debug action
		  console.log( index + ": " +$(this).attr('name') + " : " + $(this).val() );
		  //set the data object element
		  minipollcreatedata[newminipollidincrementer][$(this).attr('name')]={"waarde":"-","check":"wrong"};
		  
		});
		console.log(minipollcreatedata);
		//$(this).
		//$('#minipollname_'+ newminipollidincrementer).on('change.eerste',function(){
			//console.log($(this).val());
			//console.log($(this).attr('data-tempid'));
		//	console.log(minipollcreatedata[newminipollidincrementer]);
			//minipollcreatedata[$(this).attr('data-tempid')]['minipollname']=$(this).val();
			//console.log(minipollcreatedata[$(this).attr('data-tempid')]['minipollname']);
		//});
		$('.minipollinput').on('change.minipollnameinputs',function(){
			/** on change: do two things: update coresponding data object field value and show next input if not shown yet
			*/
			if(checkinputfield($(this))){//let if be a test on contents
				$(this).css("color", "green");
				$(this).attr('data-checkstatus','ok');//update data object?
				minipollcreatedata[$(this).attr('data-tempid')][$(this).attr('name')]['check']="ok";
			}else{
				$(this).css("color", "red");
				$(this).attr('data-checkstatus','wrong');//update data object?
				minipollcreatedata[$(this).attr('data-tempid')][$(this).attr('name')]['check']="wrong";
			}
			
			minipollcreatedata[$(this).attr('data-tempid')][$(this).attr('name')]['waarde']=$(this).val();
			console.log($(this).parent('span').next('span').attr('data-following'));
			if($(this).parent('span').next('span').is(":visible")==false){
				$(this).parent('span').next('span').fadeIn();
			}
			//console.log($(this).parent('span').next('span').length);// === 'undefined')
			//console.log($(this).parent('span').next('span').is(":visible"));
			console.log('r119a');console.log(minipollcreatedata);console.log('r119b');
			var deze=$(this);
			var checkarray =new Array();
			var teller=0;
			console.log(checkarray);
			$.each( minipollcreatedata[$(this).attr('data-tempid')], function( key, value ) {
			teller+=1;
			console.log('teller '+teller);
				console.log(key);
				console.log(value);
				console.log(value.check);
				if(typeof value.check !== 'undefined'){
					checkarray.push(value.check);;
				}
				
			});
			console.log(checkarray);
			if ($.inArray("wrong",checkarray) ==-1){
				alert('alles ok!!');
				//http://stackoverflow.com/questions/16285791/how-do-you-replace-an-html-tag-with-another-tag-in-jquery
				//$('aside').contents().unwrap().wrap('<div/>');
				
				$( "input.minipollinput" ).each(function( index ) {
					console.log( index + ": " + $( this ).text() );
					//console.log($(this).attr('title'));
					$(this).attr('style','background:#999');
					$(this).attr('disabled','disabled');
					
				});
			}
			
		});
		console.log(minipollcreatedata);
		
	 });
	alert(get_start_html());
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
	

    
	
	
   

});
 </script>

</body>
</html>