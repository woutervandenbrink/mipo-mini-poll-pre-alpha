<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Minipoll</title>
  <meta name="description" content="Minipoll, one question, cookie, time range, inframe">
  <meta name="author" content="SitePoint">

 
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
  <script src="js/jquery/2.1.1/jquery.min.js"></script>

     <script src="js/jquery.browser.js"></script>
  <script src="js/jquery.iframe-auto-height/jquery.iframe-auto-height.plugin.1.9.5.min.js"></script>
 
  
  <script>
  function autoResize(id){//http://stackoverflow.com/questions/819416/adjust-width-height-of-iframe-to-fit-with-content-in-it  : adjust height iframe according contents
    var newheight;
   // var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
       // newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    //document.getElementById(id).width= (newwidth) + "px";
}
</script>
 
  
</head>

<body>
<div id="content">


<IFRAME SRC="initiator.php?minipoll_id=1" style ="margin:0px;padding:0px" allowtransparency="allowtransparency" width="203px" scrolling="no" id="iframe1" marginheight="0" frameborder="0" ></iframe><?php /*see http://stackoverflow.com/questions/819416/adjust-width-height-of-iframe-to-fit-with-content-in-it*/;?>



</div>
 <!--  --><script>
 // A $( document ).ready() block.
$( document ).ready(function() {
   console.log( "ready!" );
 jQuery('iframe').iframeAutoHeight(); 
  

});
 </script>

</body>
</html>