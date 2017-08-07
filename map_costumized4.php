	<?php

	$cookie_name = 'url';
	if(!isset($_COOKIE[$cookie_name])) {
	 //   echo "Cookie named '" . $cookie_name . "' is not set!";
	} else {
	 //   echo "Cookie '" . $cookie_name . "' is set!<br>";
	  //  echo "Value is: " . $_COOKIE[$cookie_name];
	}

	$booleanModify = false;
	if(isset($_GET['modify'])) {
		if (htmlspecialchars($_GET['modify'])==true){
			$booleanModify = true;
		}
	}

	$booleanDeleteMap = false;
	$booleanDeleteStep = false;
	if(isset($_GET['deleteMap'])) {
		if (htmlspecialchars($_GET['deleteMap'])==true){
			$booleanDeleteMap = true;
		}
	}
	if(isset($_GET['deleteStep'])) {
		if (htmlspecialchars($_GET['deleteStep'])==true){
			$booleanDeleteStep = true;
		}
	}

	$ConfirmedDeleteMap = false;
	if(isset($_GET['ConfirmedDeleteMap'])) {
		if (htmlspecialchars($_GET['ConfirmedDeleteMap'])==true){
			$ConfirmedDeleteMap = true;
		}
	}
	

	$booleanViewMap = false;
	if(isset($_GET['viewMap'])) {
		if (htmlspecialchars($_GET['viewMap'])==true){
			$booleanViewMap = true;
		}
	}
		
	include ("function_php.php");
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
	// echo "Connected successfully";
	} catch (PDOException $e) {
	    exit("Connection failed: " . $e->getMessage());
	}
	?>

	<?php
	$step_order_err ="";
	$step_order_err_typed ="";

	$form_name_err ="";
	$title_err ="";
	$booleanEntryError = false;

	if ($booleanModify) {
			$form_id = $_POST['form'];
			$step_id = $_POST['step'];
			$form_name = $_POST['form_name'];
		    $title = $_POST['title'];
		    $text = $_POST['text'];
		    $btn_font_size = "100";
		    if(!isset($_POST['recording'])) {
		    	$recording = null;
		    }
		    else{
		    	$recording = $_POST['recording'];
		    }

		    /*Check all the parameters : 

			step order is an integer correct
			there is a form name
			there is a step name

			*/
		    
		    $step_order = $_POST['step_order'];


		    if(!checkInt($step_order)){
		    	$step_order_err_typed =$step_order;
		    	$step_order_err = "Please check you entered a valid integer";
		    	$booleanEntryError = true;
		    }
		    if(IsNullOrEmptyString($form_name)){
		    	$form_name_err = "Please enter a map name";
		    	$booleanEntryError = true;
		    } 
		    if(IsNullOrEmptyString($title)){
		    	$title_err = "Please enter a title for this step";	
		    	$booleanEntryError = true;
		    } 

		    if(!$booleanEntryError){



			    if(!isset($_COOKIE[$cookie_name])) {
				  //  echo "Cookie named '" . $cookie_name . "' is not set!";
				    $changeRecording = $recording;

				} else {
				    //echo "Cookie '" . $cookie_name . "' is set!<br>";
				   // echo "Value is: " . $_COOKIE[$cookie_name];
				    $changeRecording = $_COOKIE[$cookie_name];
				    unset($_COOKIE[$cookie_name]);
		    		setcookie($cookie_name, '', time() - 3600, '/'); // empty value and old timestamp
				   	//echo "RECORDING IS ";
					//echo $changeRecording;
					//echo "END";
				}

			    


			    if ($form_id !=0) {
			        //update mode, modifying existing form
			       
			       if ($step_id !=0) {
			       	    //update mode, modifying existing step

			       	$sql = "SELECT COUNT(distinct(form.step_id)) FROM form WHERE form.form_id=$form_id ";
					$userdata = $conn->query($sql);
					$list_form = $userdata->fetch();
					$numberStep = $list_form[0];
			    	if($numberStep>9){
	 					$btn_font_size = "75";
			    	}


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

			         $sql = "UPDATE  form_id SET "
				           . "form_name=".$conn->quote($form_name)
				           . ",btn_font_size=".$conn->quote($btn_font_size)
				            . " WHERE form_id = ".$conn->quote($form_id);
				     $userdata = $conn->query($sql);
				    } 
				    else {


				        // insert mode, there is a form id, but it is to create a new step

				        $title = "Step without name";
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

				         $sql = "SELECT MAX(step_order) FROM form WHERE form.form_id=$form_id";
				     	$stepOrderData = $conn->query($sql);
			         	$stepOrderArray = $stepIdData->fetch();
			        	 $stepOrderMaxPlusOne= $stepOrderArray[0] +1;

			         $sql = "UPDATE form SET "
				           . "step_order=".$conn->quote($stepOrderMaxPlusOne)
				            . " WHERE step_id = ".$conn->quote($step_id);
				     $userdata = $conn->query($sql);
				     echo "ADDED STEP ORDER";

				        /* Link form step */
				        $sql = "INSERT INTO form("
				           . "form_id,step_id,step_order"
				            . " ) VALUES ("
				            . $conn->quote($form_id).","
				            . $conn->quote($step_id).","
				            . $conn->quote($stepOrderMaxPlusOne).")";
				        $userdata = $conn->query($sql);

				        $sql = "UPDATE  form_id SET "
				           . "form_name=".$conn->quote($form_name)
				            . " WHERE form_id = ".$conn->quote($form_id);
				     $userdata = $conn->query($sql);
				    }
				} 
				else{
				    	
				}
			} 
		}
		elseif($booleanDeleteMap) {
			$form_id = $_GET['form_id'];
			?>

			<div class="form">
			<p>
			Please confirm you want to delete the following map : <a href="map_costumized4.php?ConfirmedDeleteMap=true&form_id=<?php echo $form_id ?>" class="btn btn-default">Delete this map</a><br/>
			</p>	
			</div>

			<div class="form">
			<?php
			include("map_read.php");
?>
			</div>
			<?php
		}
		elseif($ConfirmedDeleteMap) {

			$form_id = $_GET['form_id'];

			/* First, deleting all the steps related to the id */
			/* Getting the lists of step related to the form */

			$sql = "SELECT * FROM form WHERE form.form_id=$form_id ";
			$resultquery = $conn->query($sql);

			while ($list_step = $resultquery->fetch()){

			$thisStepId = $list_step['step_id'];

			 $sql = "DELETE FROM step WHERE step.step_id=$thisStepId";
			 $userdata = $conn->query($sql);

			}
	        
			// Delete the relation between from and step
	        $sql = "DELETE FROM form WHERE form.form_id=$form_id";
	        $userdata = $conn->query($sql);

			/*DELETE THE FORM */
	        $sql = "DELETE FROM form_id WHERE form_id.form_id=$form_id";
	        $userdata = $conn->query($sql);

	       
			

		}
		elseif($booleanDeleteStep){

			/* Delet step information*/
			$form_id = $_GET['form_id'];
			$step_id = $_GET['step_id'];

			$sql = "DELETE FROM step WHERE step_id=$step_id";
			$userdata = $conn->query($sql);
	        
			// Delete the relation between from and step
	        $sql = "DELETE FROM form WHERE form.step_id=$step_id";
	        $userdata = $conn->query($sql);


		}

		elseif($booleanViewMap){

?>
			<div class="form">
			<?php
			include("map_read.php");
?>
			</div>
			<?php

			$step_id = $_GET['step_id'];
			?>
			<?php
			include("editStep.php");


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


	  <LINK href="css/div.css" rel="stylesheet" type="text/css">

	    <LINK href="css/design.css" rel="stylesheet" type="text/css">


	<style>
	section {
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

	<?php include 'script_import.php';
	?>


	<style>
	.item-display {
	    cursor: pointer;
	}
	.item-field {
	    display: none;
	}
	</style>

	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>




	<!-- NEED IT FOR THE SELECT LIST
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	-->


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>



	<script src="script2.js"></script>

	  <script src="voice/dist/recorder.js"></script>

	   <script src="voice/upload.js"></script>


	</script>
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
		if (!isset($_POST['submit'])) {

	?>
	<div class="form">

	        <h1> The Ultimate Map Guide Editor </h1>

	        <form action="map_costumized4.php" method = "post">
	        			<?php
				if(!isset($_COOKIE[$cookie_name])) {
				//    echo "Cookie named '" . $cookie_name . "' is not set!";

				} else {
				//    echo "Cookie '" . $cookie_name . "' is set!<br>";

				 //   echo "Value is: " . $_COOKIE[$cookie_name];
				 //   echo "<script> function(); </script>";
				   setcookie($cookie_name,"",time()+0);
					setcookie($cookie_name, "", time() + (86400 * 30), "/");
				//    echo "Value is: " . $_COOKIE[$cookie_name];
				}
				?>



			
			

	 
	        <div class="divTable">

	<div class="divTableBody">
	<div class="divTableRow">
	<div class="divTableCell">Mapto modify : 

	 <?php
				// $resultquery = $conn->query('SELECT distinct(form.form_id),form_name FROM form RIGHT JOIN form_id ON form.form_id = form_id.form_id');
				 $resultquery = $conn->query('SELECT form_id,form_name FROM form_id');
				?>


	</div>
	<div class="divTableCell"><select name="form">
				    <option value="" disabled="disabled" selected="selected">Please select a map  to modify</option>
				    <option value="0" rel="newform">New Form</option>
				<?php 
				/* We get each form one by one */
				while ($list_form = $resultquery->fetch())
				{
					?>

				    <option value="<?php echo htmlspecialchars( $list_form['form_id']); ?>" rel="<?php echo htmlspecialchars( $list_form['form_id']); ?>"><?php echo htmlspecialchars( $list_form['form_name']); ?></option>
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


				//$resultquery2 = $conn->query('SELECT * FROM form INNER JOIN step ON form.step_id=step.step_id ORDER BY form_id');
				$resultquery2 = $conn->query('SELECT * FROM form INNER JOIN step ON form.step_id=step.step_id RIGHT JOIN (SELECT form_id as id FROM form_id) as formID ON formID.id = form.form_id ORDER BY id');

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
					if ($current_form_id == $list_form2['id']){}
					else{
						?>
					<option value="0" class="<?php echo htmlspecialchars($list_form2['id']); ?>">New step</option>
					<?php 
					$current_form_id = $list_form2['id'];
					}
					?>
					
				    <option value="<?php echo htmlspecialchars($list_form2['step_id']); ?>" class="<?php echo htmlspecialchars($list_form2['form_id']); ?>">Step <?php echo htmlspecialchars($list_form2['step_order']); ?> : <?php echo htmlspecialchars($list_form2['title']); ?></option>
				    <?php 
				}
					?>
				</select></div>
	</div>
	</div>
	</div>
	        
	           <br />
	            <input type="submit" name="submit"/>
	        </form>

	   
	</div>
	<?php 
	}
	?>

	<?php
		if (isset($_POST['submit'])) {
			$form_id = $_POST['form'];
			$step_id = $_POST['step'];
			

		    if ($form_id !=0) {
		        //update mode, modifying existing form
		       
		       if ($step_id !=0) {
		       	    //update mode, modifying existing step

		       	
			        include("editStep.php");
	   		




			}
			    else {


			          // insert mode, there is a form id, but it is to create a new step

				        $title = "Step without name";
				        $sql = "INSERT INTO step("
				            . "title"
				            . " ) VALUES ("
				            . $conn->quote($title).")";
				        $userdata = $conn->query($sql);

				        $stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
				       	$step_idArray = $stepIdData->fetch();
				        $step_id = $step_idArray[0];
				        echo $step_id;

				         $sql = "SELECT MAX(step_order) FROM form WHERE form.form_id=$form_id";
				     	$stepOrderData = $conn->query($sql);
			         	$stepOrderArray = $stepOrderData->fetch();
			         	 echo "STEP ORDER MAX ".$stepOrderArray[0];
			        	 $stepOrderMaxPlusOne= $stepOrderArray[0] + 1;

			         $sql = "UPDATE form SET "
				           . "step_order=".$conn->quote($stepOrderMaxPlusOne)
				            . " WHERE step_id = ".$conn->quote($step_id);
				     $userdata = $conn->query($sql);
				     echo "ADDED STEP ORDER ".$stepOrderMaxPlusOne;

				        /* Link form step */
				      
				        $sql = "INSERT INTO form("
				           . "form_id,step_id,step_order"
				            . " ) VALUES ("
				            . $conn->quote($form_id).","
				            . $conn->quote($step_id).","
				            . $conn->quote($stepOrderMaxPlusOne).")";
				        $userdata = $conn->query($sql);

			    	include("editStep.php");
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
					$newFormName = "Map nb ".$form_id;
			        $sql = "UPDATE  form_id SET "
				           . "form_name=".$conn->quote($newFormName)
				            . " WHERE form_id = ".$conn->quote($form_id);
				     $userdata = $conn->query($sql);



					$sql = "INSERT INTO step() VALUES ()";
			        $userdata = $conn->query($sql);

					$stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
			       	$step_idArray = $stepIdData->fetch();
			        $step_id = $step_idArray[0];
			       	echo "YOU CREATED THE STEP : ";
			        echo $step_id;
			        echo "<br>";

			        /*Make the link between step */

			       
			        $sql = "INSERT INTO form("
			           . "form_id,step_id"
			            . " ) VALUES ("
			            . $conn->quote($form_id).","
			            . $conn->quote($step_id).")";
			        $userdata = $conn->query($sql);

			        
			         $sql = "SELECT MAX(step_order) FROM form WHERE form.form_id=$form_id";
				     $stepOrderData = $conn->query($sql);
			         $stepOrderArray = $stepIdData->fetch();
			         $stepOrderMaxPlusOne= $stepOrderArray[0] +1;

			         $sql = "UPDATE form SET "
				           . "step_order=".$conn->quote($stepOrderMaxPlusOne)
				            . " WHERE step_id = ".$conn->quote($step_id);
				     $userdata = $conn->query($sql);
			       
			        include("editStep.php");
			        
			}
	   }

	?>


	</body>
	</html>