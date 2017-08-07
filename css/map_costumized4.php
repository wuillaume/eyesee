<?php
$cookie_name = 'url';
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}

$booleanModify = false;
if(isset($_GET['modify'])) {
	if (htmlspecialchars($_GET['modify'])==true){
		$booleanModify = true;
	}
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

<?php

if ($booleanModify) {
		$form_id = $_POST['form'];
		$step_id = $_POST['step'];
		$form_name = $_POST['form_name'];
	    $title = $_POST['title'];
	    $text = $_POST['text'];
	    $recording = $_POST['recording'];
	    $step_order = $_POST['step_order'];

	    if(!isset($_COOKIE[$cookie_name])) {
		    echo "Cookie named '" . $cookie_name . "' is not set!";
		    $changeRecording = $recording;

		} else {
		    echo "Cookie '" . $cookie_name . "' is set!<br>";
		    echo "Value is: " . $_COOKIE[$cookie_name];
		    $changeRecording = $_COOKIE[$cookie_name];
		    unset($_COOKIE[$cookie_name]);
    		setcookie($cookie_name, '', time() - 3600, '/'); // empty value and old timestamp
		   	echo "RECORDING IS ";
			echo $changeRecording;
			echo "END";
		}

	    


	    if ($form_id !=0) {
	        //update mode, modifying existing form
	       
	       if ($step_id !=0) {
	       	    //update mode, modifying existing step


	        $sql = "UPDATE step SET "
	            . "title=".$conn->quote($title)
	            . ",text=".$conn->quote($text)
	            . ",recording=".$conn->quote($changeRecording)
	            . " WHERE step_id = ".$conn->quote($step_id);
	            echo $sql;
	        $userdata = $conn->query($sql);

	        // REinit changeRecording
			$changeRecording = "";

	        $sql = "UPDATE form SET "
	            . "step_order=".$conn->quote($step_order)
	            . " WHERE step_id = ".$conn->quote($step_id);
	            echo $sql;
	        $userdata = $conn->query($sql);
		    } 
		    else {
		        // insert mode, there is a form id, but it is to create a new step
		        $sql = "INSERT INTO step("
		            . "title, text, recording"
		            . " ) VALUES ("
		            . $conn->quote($title).","
		            . $conn->quote($text).","
		            . $conn->quote($changeRecording).")";
		        $userdata = $conn->query($sql);

		        $stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$step_idArray = $stepIdData->fetch();
		        $step_id = $step_idArray[0];
		        echo $step_id;

		        /* Link form step */
		        $sql = "INSERT INTO form("
		           . "form_id,step_id,step_order"
		            . " ) VALUES ("
		            . $conn->quote($form_id).","
		            . $conn->quote($step_id).","
		            . $conn->quote($step_order).")";
		        $userdata = $conn->query($sql);
		    }
		} 
		else{
		    	 // insert mode, new form, new step

		    	$sql = "INSERT INTO step("
		            . "title, text, recording"
		            . " ) VALUES ("
		            . $conn->quote($title).","
		            . $conn->quote($text).","
		            . $conn->quote($changeRecording).")";
		        $userdata = $conn->query($sql);

				$stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$step_idArray = $stepIdData->fetch();
		        $step_id = $step_idArray[0];
		        echo $step_id;
		        /* NEED TO CREATE THE FORM WITH FORM NAME */
		       


		        $sql = "INSERT INTO form_id("
		           . "form_name"
		            . " ) VALUES ("
		            . $conn->quote($form_name).")";
		        $userdata = $conn->query($sql);
				echo $form_name;
				
				$formIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$form_idArray = $formIdData->fetch();
		        $form_id = $form_idArray[0];
		        echo $form_id;

		       /* Link form step */
		        $sql = "INSERT INTO form("
		           . "form_id,step_id,step_order"
		            . " ) VALUES ("
		            . $conn->quote($form_id).","
		            . $conn->quote($step_id).","
		            . $conn->quote($step_order).")";
		        $userdata = $conn->query($sql);
		}
	} 
	else {
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


  <LINK href="css/div.css" rel="stylesheet" type="text/css">

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


<table border="1" cellpadding="10">

    <td>
        <h1> The Ultimate Map Guide Editor </h1>

        <form action="map_costumized3.php" method = "post">
        			<?php
			if(!isset($_COOKIE[$cookie_name])) {
			    echo "Cookie named '" . $cookie_name . "' is not set!";

			} else {
			    echo "Cookie '" . $cookie_name . "' is set!<br>";

			    echo "Value is: " . $_COOKIE[$cookie_name];
			    echo "<script> function(); </script>";
			   setcookie($cookie_name,"",time()+0);
				setcookie($cookie_name, "", time() + (86400 * 30), "/");
			    echo "Value is: " . $_COOKIE[$cookie_name];
			}
			?>


			
 <br />
            

		
		
		    
            <br />
            <input type="submit" name="submit"/>
        </form>

        <div class="divTable">

<div class="divTableBody">
<div class="divTableRow">
<div class="divTableCell">Mapto modify : 
</div>
<div class="divTableCell"><select name="form">
			    <option value="" disabled="disabled" selected="selected">Please select a map  to modify</option>
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
			</select></div>
</div>
<div class="divTableRow">
<div class="divTableCell"><br>
			Step number to modify :
</div>
<div class="divTableCell">

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
			</select></div>
</div>
</div>
</div>
        

    </td>
</table>

<?php
	if (isset($_POST['submit'])) {
		$form_id = $_POST['form'];
		$step_id = $_POST['step'];
		

	    if ($form_id !=0) {
	        //update mode, modifying existing form
	       
	       if ($step_id !=0) {
	       	    //update mode, modifying existing step

	       	echo $form_id;
	       	echo " / ";
	       	echo $step_id;
	      
   			
	       ?>
	       

<table border="1" cellpadding="10">

    <td>
        <h1> Add a step </h1>
        <form action="map_costumized3.php?modify=true" method = "post">

			        <?php
			$resultquery = $conn->query("SELECT * FROM form_id WHERE form_id.form_id = $form_id");
			$formName = $resultquery->fetch();
			$formNameStr = $formName['form_name'];
			echo $formNameStr;
		//	$formNameStr = $formName['0']['form_name'];
			?>
		
 <br />

 Form name: <br /> <input type="text" name="form_name" value="<?php echo $formNameStr ?>" /><br />
            <br />
 			<?php
			$resultquery = $conn->query("SELECT * FROM form WHERE form.step_id = $step_id");
			$stepOr = $resultquery->fetch();
			$stepOrStr = $stepOr['step_order'];
			echo $stepOrStr;
		//	$formNameStr = $formName['0']['form_name'];
			?>
            Step number: <br /> <input type="text" name="step_order" value="<?php echo $stepOrStr ?>" /><br />
            <br />

            <?php
			$resultquery = $conn->query("SELECT * FROM step WHERE step.step_id = $step_id");
			$stepArr = $resultquery->fetch();
			
			?>

            Step title: <br /> <input type="text" name="title" value="<?php echo $stepArr['title'] ?>" /><br />
            <br />

            Step Text: <br /> <input type="text" name="text" value="<?php echo $stepArr['text'] ?>" /> <br />
            <br />

            Play a recording : 
<audio controls="" disabled="disabled" name="view_field15_Client" id="view_field15_Client">  <source src="Recordmp3js-master/recordings/<?php echo $stepArr['recording'] ?>" type="audio/wav">   Your browser does notsupport the audio tag.</audio>
		  
		    Recording address: <br /> <input type="text" name="recording" value="<?php echo $stepArr['recording'] ?>" /> <br />
			
			
			
			?>


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


		
			<input type="hidden" name="form" value="<?php echo $form_id ?>"/>
		    <input type="hidden" name="step" value="<?php echo $step_id ?>"/>
            <br />
            <input type="submit" name="submit"/>
        </form>


    </td>
</table>

			        <?php




		}
		    else {
		        // insert mode, there is a form id, but it is to create a new step
		        $sql = "INSERT INTO step() VALUES ()";
		        $userdata = $conn->query($sql);

		        $stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$step_idArray = $stepIdData->fetch();
		        $step_id = $step_idArray[0];
		        echo $step_id;

		        /* Link form step */
		        $sql = "INSERT INTO form("
		           . "form_id,step_id"
		            . " ) VALUES ("
		            . $conn->quote($form_id).","
		            . $conn->quote($step_id).")";
		        $userdata = $conn->query($sql);
		    }


	} 
			else{


		    	 // insert mode, new form, new step

				/* NEED TO CREATE THE FORM WITH FORM NAME */
				$sql = "INSERT INTO form_id() VALUES ()";
		        $userdata = $conn->query($sql);
				
				
				$formIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$form_idArray = $formIdData->fetch();
		        $form_id = $form_idArray[0];
		        echo "YOU CREATED THE FORM : ";
		        echo $form_id;
		        echo "<br>";


				$sql = "INSERT INTO step() VALUES ()";
		        $userdata = $conn->query($sql);

				$stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$step_idArray = $stepIdData->fetch();
		        $step_id = $step_idArray[0];
		       	echo "YOU CREATED THE STEP : ";
		        echo $step_id;
		        echo "<br>";
		        
		       



		       /* Link form step */
		        $sql = "INSERT INTO form("
		           . "form_id,step_id"
		            . " ) VALUES ("
		            . $conn->quote($form_id).","
		            . $conn->quote($step_id).")";
		        $userdata = $conn->query($sql);
		}
   }

?>



</body>
</html>