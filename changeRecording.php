
<?php
$cookie_name = 'url';
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}
?>


<?php 
/*Connect to the DB */
$host = "localhost";
$username = "root";
$password = "";
$database = "eyesee_map";

$dsn = "mysql:host=$host;dbname=$database";

TRY {
$conn = new PDO( $dsn, $username, $password );
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connected successfully";
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>


<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="Wuil" content="SitePoint">

<style>
	.cascade {
    display: none;
}

</style>

<style>
section {
    height: 0;
    display: none;
    overflow: hidden;
    -o-transition: all 2s linear;
    -webkit-transition: all 2s linear;
    -ms-transition: all 2s linear;
    -moz-transition: all 2s linear;
    transition: all 2s linear;
}
section:target {
    display: block;
    height: 20em;
    -o-transition: all 2s linear;
    -webkit-transition: all 2s linear;
    -ms-transition: all 2s linear;
    -moz-transition: all 2s linear;
    transition: all 2s linear;
}
</style>


 <style type='text/css'>
    ul { list-style: none; }
    #recordingslist audio { display: block; margin-bottom: 10px; }
  </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="script1.js"></script>


  <script src="voice/dist/recorder.js"></script>

   <script src="voice/upload.js"></script>


<script>
	$(document).ready(function(){
	    var $cat = $('select[name=form]'),
	        $items = $('select[name=step]');

	    $cat.change(function(){
	        var $this = $(this).find(':selected'),
	            rel = $this.attr('rel'),
	            $set = $items.find('option.' + rel);
	        
	        if ($set.size() < 0) {
	            $items.hide();
	            return;
	        }
	        
	        $items.show().find('option').hide();
	        
	        $set.show().first().prop('selected', true);
	    });
	});

</script>
</head>

<body>

<?php
$resultquery = $conn->query('SELECT distinct(form_id) FROM form');
?>
Form number to modify : 
<select name="form">
    <option value="" disabled="disabled" selected="selected">Please select a form to modify</option>
    <option value="0" rel="newform">New Form</option>
<?php 
/* We get each form one by one */
while ($list_form = $resultquery->fetch())
{
	?>

    <option value="<?php echo $list_form['form_id']; ?>" rel="<?php echo $list_form['form_id']; ?>"><?php echo $list_form['form_id']; ?></option>
    <?php 
}
	?>
</select>

<br>
Step number to modify :

<?php
$resultquery2 = $conn->query('SELECT * FROM form');
?>
<select name="step" >
    <option value="" disabled="disabled" selected="selected">Please select a step to modify</option>
    <option value="0" class="newform">New step</option>


<?php 
$current_form_id = null;
/* We get each form one by one */
while ($list_form2 = $resultquery2->fetch())
{
	?>
	<?php 
	if ($current_form_id == $list_form2['form_id']){}
	else{
		?>
	<option value="0" class="<?php echo $list_form2['form_id']; ?>">New step</option>
	<?php 
	$current_form_id = $list_form2['form_id'];
	}
	?>
	
    <option value="<?php echo $list_form2['step_id']; ?>" class="<?php echo $list_form2['form_id']; ?>"><?php echo $list_form2['step_id']; ?></option>
    <?php 
}
	?>
</select>




<table border="1" cellpadding="10">

    <td>
        <h1> Add a step </h1>
        <form action="changeRecording.php" method = "post">

			        <?php
			$resultquery = $conn->query('SELECT distinct(form_id) FROM form');
			?>
			Form number to modify : 
			<select name="form">
			    <option value="" disabled="disabled" selected="selected">Please select a form to modify</option>
			    <option value="0" rel="newform">New Form</option>
			<?php 
			/* We get each form one by one */
			while ($list_form = $resultquery->fetch())
			{
				?>

			    <option value="<?php echo $list_form['form_id']; ?>" rel="<?php echo $list_form['form_id']; ?>"><?php echo $list_form['form_id']; ?></option>
			    <?php 
			}
				?>
			</select>

			<br>
			Step number to modify :

			<?php
			$resultquery2 = $conn->query('SELECT * FROM form ORDER BY form_id');
			?>
			<select name="step" class="cascade">
			    <option value="" disabled="disabled" selected="selected">Please select a step to modify</option>
			    <option value="0" class="newform">New step</option>


			<?php 
			$current_form_id = null;
			/* We get each form one by one */
			while ($list_form2 = $resultquery2->fetch())
			{	
				?>
				<?php 
				if ($current_form_id == $list_form2['form_id']){}
				else{
					?>
				<option value="0" class="<?php echo $list_form2['form_id']; ?>">New step</option>
				<?php 
				$current_form_id = $list_form2['form_id'];
				}
				?>
				
			    <option value="<?php echo $list_form2['step_id']; ?>" class="<?php echo $list_form2['form_id']; ?>"><?php echo $list_form2['step_id']; ?></option>
			    <?php 
			}
				?>
			</select>
 <br />
            

		
		
		    
            <br />
            <input type="submit" name="submit"/>
        </form>


    </td>
</table>

 
		  
	<?php


if (isset($_POST['changeRecording'])) {

	$changeRecording = $_POST['changeRecording'];
	echo $changeRecording;
}
	if (isset($_POST['submit'])) {
		$form_id = $_POST['form'];
		$step_id = $_POST['step'];
		

	    if ($form_id !=0) {
	        //update mode, modifying existing form
	       
	       if ($step_id !=0) {
	       	    //update mode, modifying existing step

	       	echo $form_id;
	       	echo " / ";
	      
   			 $advert = array(
        'ajax' => 'Hello world!',
        'advert' => $step_id,
     );
    echo json_encode($advert);
?>
	       ?>
	       
Recording address: <br /> <input type="text" name="recording" value="" /> <br />
		    <button href="#two">Change?</button>
			 <a href="#changeRecord">Change?1</a>


			        <section id="changeRecord">
			            <!-- THIS SECTION IS FOR RECORDING-->

			<h1>Make a recording
			</h1>

			  <p>Make sure you are using a recent version of Google Chrome.</p>
			  <p>Also before you enable microphone input either plug in headphones or turn the volume down if you want to avoid ear splitting feedback!</p>

			  <button onclick="startRecording(this);">record</button>
			  <button onclick="stopRecording(this);" disabled>stop</button>
			  
			  <h2>Recordings</h2>
			  <ul id="recordingslist"></ul>
			  
			  <h2>Log</h2>
			  <pre id="log"></pre>

		   <!-- THIS SECTION IS FOR RECORDING-->	
			        </section>

			        <?php




		}
	} 
	else {
	}
   }

?>

</body>
</html>