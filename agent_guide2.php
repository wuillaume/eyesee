
<?php echo $_SERVER['QUERY_STRING']?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/styles.css?v=1.0">


<style>


iframe {
    display: block;       /* iframes are inline by default */
    background: #000;
    border: none;         /* Reset default border */
    height: 100vh;        /* Viewport-relative units */
    width: 100vw;
}


#myDIV2{
    display: none;   
}
</style>
    <script>

function myFunction() {
    var x = document.getElementById('myDIV');
    var y = document.getElementById('myDIV2');
    if (x.style.display === 'none') {
        x.style.display = 'block';
        y.style.display = 'none';
    } else {
        x.style.display = 'none';
        y.style.display = 'block';
    }
}



</script>
</head>

<body>
  <script src="js/scripts.js"></script>

<div id="container">
   
    
    <!-- #BeginEditable "content" -->
    <div id="maincontent">
    <br />
         
</div>
<button onclick="myFunction()">Click Me</button>

<div id="myDIV">

        <iframe class="iframe1" src="http://eyesee.internationalcallcentre.com/crm/dgrid/campaign_selector.php?" . $_SERVER['QUERY_STRING'] name="Match Centre"
               >
                content if browser does not support
                </iframe>
</div>
<div id="myDIV2">
 <iframe class="iframe2"  src="//jsfiddle.net/wuil/9fddopr5/6/embedded/result/" name="Guide"
                width="95%" height="95%">
                content if browser does not support
                </iframe>
</div>


</body>
</html>