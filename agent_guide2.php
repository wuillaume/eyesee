


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
    height: 85vh;        /* Viewport-relative units */
    width: 85vw;
}
button{
  width :85vw;
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

  <?php
    if (isset($_GET['form_id'])) {
      //  echo $_GET['form_id'];
        $form_id = $_GET['form_id'];
    }else{
    }
  ?>

<div id="container">
   
    
    <!-- #BeginEditable "content" -->
    <div id="maincontent">
    <br />
         
</div>
<button onclick="myFunction()">Change view</button>

<div id="myDIV">

        <iframe class="iframe1" src="https://eyesee.internationalcallcentre.com/crm/dgrid/campaign_selector.php?<?php echo $_SERVER['QUERY_STRING']; ?>" name="campaign_selector" >
                content if browser does not support
                </iframe>  
 
</div>
<div id="myDIV2">
 <iframe class="iframe2"  src="map_read.php?form_id=<?php echo htmlspecialchars($form_id) ?>" name="Guide">
                content if browser does not support
                </iframe>
</div>


</body>
</html>