	<?php

	$cookie_name = 'url';
	if(!isset($_COOKIE[$cookie_name])) {
	 //   echo "Cookie named '" . $cookie_name . "' is not set!";
	} else {
	 //   echo "Cookie '" . $cookie_name . "' is set!<br>";
	  //  echo "Value is: " . $_COOKIE[$cookie_name];
	}

	$permission = false;
	if(isset($_GET['perm'])) {
		if (htmlspecialchars($_GET['perm'])==admin){
			$permission = true;
		}
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
	

	$booleanViewMapStep = false;
	if(isset($_GET['viewMap'])) {
		if (htmlspecialchars($_GET['viewMap'])==true){
			$booleanViewMapStep = true;
		}
	}

	$booleanViewMapMenu = false;
	if(isset($_GET['viewMapMenu'])) {
		if (htmlspecialchars($_GET['viewMapMenu'])==true){
			$booleanViewMapMenu = true;
		}
	}

	include ("function_php.php");
	?>


	<?php 
	include("connectDB.php");
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
		$former_step_order = $_POST['former_step_order'];
		$form_name = $_POST['form_name'];
		$title = $_POST['title'];
		$step_color = $_POST['step_color'];
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

			$order_previous_step = $_POST['previous_step'];

			//echo var_dump($_POST);

			// if(!checkInt($step_order)){
			// 	$step_order_err_typed =$step_order;
			// 	$step_order_err = "Please check you entered a valid integer";
			// 	$booleanEntryError = true;
			// }
			if(IsNullOrEmptyString($form_name)){
				$form_name_err = "Please enter a map name";
				$booleanEntryError = true;
			} 
			if(IsNullOrEmptyString($title)){
				$title_err = "Please enter a title for this step";	
				$booleanEntryError = true;
			} 
			if(IsNullOrEmptyString($step_color)){
				$step_color_err = "Please enter a title for this step";	
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

		    			// echo "step_id ".$step_id;
		    			// echo "_POST['previous_step']".$_POST['previous_step'];
		    			// echo "step_order ".$step_order;
		    			// echo "former_step_order ".$former_step_order;
		    			
			       	    //update mode, modifying existing step

		    			$sql = "SELECT COUNT(distinct(form.step_id)) FROM form WHERE form.form_id=$form_id ";
		    			$userdata = $bdd->query($sql);
		    			$list_form = $userdata->fetch();
		    			$numberStep = $list_form[0];
		    			if($numberStep>9){
		    				$btn_font_size = "75";
		    			}


		    			$sql = "UPDATE step SET "
		    			. "title=".$bdd->quote($title)
		    			. ",text=".$bdd->quote($text)
		    			. ",recording=".$bdd->quote($changeRecording)
		    			. ",step_color=".$bdd->quote($step_color)
		    			. " WHERE step_id = ".$bdd->quote($step_id);
			          //  echo $sql;
		    			$userdata = $bdd->query($sql);

			        // REinit changeRecording
		    			$changeRecording = "";

		    			//CHANGING ORDER OF STEP

		    			//echo "Previous step ".$order_previous_step;
		    			//echo "Former step ".$former_step_order;
		    			
		    			if($order_previous_step<$former_step_order){

		    				$step_order = $order_previous_step +1;

		    				//If Put before actual position

			    			$sql = "SELECT * FROM form WHERE form_id = ".$bdd->quote($form_id)." AND step_order >=".$bdd->quote($step_order)." AND step_order <".$bdd->quote($former_step_order)." ORDER BY step_order"	;
			    			$userdata = $bdd->query($sql);
			    			//echo "SQL ".$sql;
			    			if(!empty($userdata)){
								while ($list_relation = $userdata->fetch()){
				    				$newActualStepOrder = $list_relation['step_order'] +1;
					    				$sql = "UPDATE form SET "
					    			. "step_order=".$bdd->quote($newActualStepOrder)
					    			. " WHERE relation_id = ".$bdd->quote($list_relation['relation_id']);
						            //echo $sql;
					    			$bdd->query($sql);
				    			}

			    			}		    				
		    			} else {

		    					$step_order = $order_previous_step;

			    				$sql = "SELECT * FROM form WHERE form_id = ".$bdd->quote($form_id)." AND step_order <=".$bdd->quote($step_order)." AND step_order >".$bdd->quote($former_step_order)." ORDER BY step_order"	;
			    				//echo "SQL ".$sql;
				    			$userdata = $bdd->query($sql);
				    			if(!empty($userdata)){
									while ($list_relation = $userdata->fetch()){
					    				$newActualStepOrder = $list_relation['step_order'] -1;
						    				$sql = "UPDATE form SET "
						    			. "step_order=".$bdd->quote($newActualStepOrder)
						    			. " WHERE relation_id = ".$bdd->quote($list_relation['relation_id']);
							            //echo $sql;
						    			$bdd->query($sql);
					    			}
			    			}
			    		}


			    			
			    			// echo "changing step order from ".$former_step_order." to ".$step_order;
			    			$sql = "UPDATE form SET "
			    			. "step_order=".$bdd->quote($step_order)
			    			. " WHERE step_id = ".$bdd->quote($step_id);
				         //   echo $sql;
			    			$userdata = $bdd->query($sql);

			    			$sql = "UPDATE  form_id SET "
			    			. "form_name=".$bdd->quote($form_name)
			    			. ",btn_font_size=".$bdd->quote($btn_font_size)
			    			. " WHERE form_id = ".$bdd->quote($form_id);
			    			$userdata = $bdd->query($sql);
		    			
		    		} 
		    		else {


				        // insert mode, there is a form id, but it is to create a new step

		    			$title = "Step without name";
		    			$step_color = "#f0ad4e";
		    			$sql = "INSERT INTO step("
		    			. "title, text, recording,step_color"
		    			. " ) VALUES ("
		    			. $bdd->quote($title).","
		    			. $bdd->quote($text).","

		    			. $bdd->quote($changeRecording).","
		    			. $bdd->quote($step_color).")";
		    			$userdata = $bdd->query($sql);

		    			$stepIdData = $bdd->query("SELECT LAST_INSERT_ID();");
		    			$step_idArray = $stepIdData->fetch();
		    			$step_id = $step_idArray[0];
				     //   echo $step_id;

		    			$sql = "SELECT MAX(step_order) FROM form WHERE form.form_id=$form_id";
		    			$stepOrderData = $bdd->query($sql);
		    			$stepOrderArray = $stepIdData->fetch();
		    			$stepOrderMaxPlusOne= $stepOrderArray[0] +1;

		    			$sql = "UPDATE form SET "
		    			. "step_order=".$bdd->quote($stepOrderMaxPlusOne)
		    			. " WHERE step_id = ".$bdd->quote($step_id);
		    			$userdata = $bdd->query($sql);
				     // echo "ADDED STEP ORDER";

		    			/* Link form step */
		    			$sql = "INSERT INTO form("
		    			. "form_id,step_id,step_order"
		    			. " ) VALUES ("
		    			. $bdd->quote($form_id).","
		    			. $bdd->quote($step_id).","
		    			. $bdd->quote($stepOrderMaxPlusOne).")";
		    			$userdata = $bdd->query($sql);

		    			$sql = "UPDATE  form_id SET "
		    			. "form_name=".$bdd->quote($form_name)
		    			. " WHERE form_id = ".$bdd->quote($form_id);
		    			$userdata = $bdd->query($sql);
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
					Please confirm you want to delete the following map : <a href="map_costumized4.php?perm=admin&ConfirmedDeleteMap=true&form_id=<?php echo $form_id ?>" class="btn btn-default">Delete this map</a><br/>
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
			$resultquery = $bdd->query($sql);

			while ($list_step = $resultquery->fetch()){

				$thisStepId = $list_step['step_id'];

				$sql = "DELETE FROM step WHERE step.step_id=$thisStepId";
				$userdata = $bdd->query($sql);

			}

			// Delete the relation between from and step
			$sql = "DELETE FROM form WHERE form.form_id=$form_id";
			$userdata = $bdd->query($sql);

			/*DELETE THE FORM */
			$sql = "DELETE FROM form_id WHERE form_id.form_id=$form_id";
			$userdata = $bdd->query($sql);


			

		}
		elseif($booleanDeleteStep){

			/* Delet step information*/
			$form_id = $_GET['form_id'];
			$step_id = $_GET['step_id'];
			$newStepId="0";

			$sql = "SELECT step_order FROM form WHERE form_id=$form_id AND step_id=$step_id";
			$userdata = $bdd->query($sql);
			$stepOrderArray = $userdata->fetch();
			$current_step_order = $stepOrderArray['step_order'];	

			$sql = "SELECT step_order,step_id FROM form WHERE form_id=$form_id";
			$userdata = $bdd->query($sql);
			while($stepOrderArray = $userdata->fetch()){
				if($stepOrderArray['step_order']<$current_step_order){
					$newStepId=$stepOrderArray['step_id'];
				}
			}			


			$sql = "DELETE FROM step WHERE step_id=$step_id";
			$userdata = $bdd->query($sql);

			// Delete the relation between from and step
			$sql = "DELETE FROM form WHERE form.step_id=$step_id";
			$userdata = $bdd->query($sql);

			$step_id=$newStepId;

			include("editStep.php");


		}

		elseif($booleanViewMapStep){


		}
		elseif($booleanViewMapMenu){


		}


		?>


		<!doctype html>
		<html lang="en">
		<head>
			<meta charset="utf-8">

			<title>The HTML5 Herald</title>
			<meta name="description" content="The HTML5 Herald">
			<meta name="Wuil" content="SitePoint">

<!-- Style import

-->

<LINK href="css/map_costumized7.css" rel="stylesheet" type="text/css">

				
<!-- SCRIPTS LISTS

-->

<script src="js/map_costumized4.js"></script>
<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="js/scriptAudio.js"></script>
<script src="voice/dist/recorder.js"></script>
<script src="voice/upload.js"></script>
<script src="js/scriptList4.js"></script>

<!-- SCRIPTS LISTS

-->

	<!-- NEED IT FOR THE SELECT LIST
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
-->





</head>

<body>



	<?

	if (!isset($_POST['submit'])&&$permission&&!isset($_GET['nextStep'])&&!isset($_POST['leftMenu'])) {

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
							<div class="divTableCell">Map to modify : 

								<?php
				// $resultquery = $bdd->query('SELECT distinct(form.form_id),form_name FROM form RIGHT JOIN form_id ON form.form_id = form_id.form_id');
								$resultquery = $bdd->query('SELECT form_id,form_name FROM form_id');
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
							<div class="divTableCell"></div>
						</div>
						<div class="divTableRow cascade" id="subRow">
							
							<div class="divTableCell"  name="cellA"><br>
								Step number to modify :
							</div>
							<div class="divTableCell" name="cellB">

									<?php


					//$resultquery2 = $bdd->query('SELECT * FROM form INNER JOIN step ON form.step_id=step.step_id ORDER BY form_id');
									$resultquery2 = $bdd->query('SELECT * FROM form INNER JOIN step ON form.step_id=step.step_id RIGHT JOIN (SELECT form_id as id FROM form_id) as formID ON formID.id = form.form_id ORDER BY id');

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
										</select>
									</div>

									<div class="divTableCell"  name="cellC"> OR 
										<button name="leftMenu" class="cascade" value="true">Change the Menu</button>
									</div>

								</div>
							</div>
						</div>

						<br />
						<input type="submit" name="submit"/>
					</form>


				</div>
				<?php 
			}

			if (isset($_POST['submit'])||isset($_GET['nextStep'])) {

				if(isset($_GET['nextStep'])){
					$form_id = $_GET['form_id'];
					$step_id = 0;
				}
				else{
					$form_id = $_POST['form'];
					$step_id = $_POST['step'];
				}

				


				if ($form_id !=0) {
		        //update mode, modifying existing form

					if ($step_id !=0) {
		       	    //update mode, modifying existing step


						if ($booleanModify) {

							include("editStep.php?booleanModify=true");
						}

						include("editStep.php");





					}
					else {


			          // insert mode, there is a form id, but it is to create a new step

						$title = "Step without name";
						$step_color = "#f0ad4e";
						$sql = "INSERT INTO step("
						. "title,"
						. "step_color"
						. " ) VALUES ("
						. $bdd->quote($title).","
						. $bdd->quote($step_color).")";
						$userdata = $bdd->query($sql);

						
						// $stepIdData = $bdd->query("SELECT LAST_INSERT_ID()");
						// $step_idArray = $stepIdData->fetch();
						// $step_id = $step_idArray[0];

						$step_id = $bdd->lastInsertId();
				        echo "STEP ID ".$step_id;

						$sql = "SELECT MAX(step_order) FROM form WHERE form.form_id=$form_id";
						$stepOrderData = $bdd->query($sql);
						$stepOrderArray = $stepOrderData->fetch();
			         	// echo "STEP ORDER MAX ".$stepOrderArray[0];
						$stepOrderMaxPlusOne= $stepOrderArray[0] + 1;

						$sql = "UPDATE form SET "
						. "step_order=".$bdd->quote($stepOrderMaxPlusOne)
						. " WHERE step_id = ".$bdd->quote($step_id);
						$userdata = $bdd->query($sql);
				     // echo "ADDED STEP ORDER ".$stepOrderMaxPlusOne;

						/* Link form step */

						$sql = "INSERT INTO form("
						. "form_id,step_id,step_order"
						. " ) VALUES ("
						. $bdd->quote($form_id).","
						. $bdd->quote($step_id).","
						. $bdd->quote($stepOrderMaxPlusOne).")";
						$userdata = $bdd->query($sql);

						include("editStep.php");
					}


				} 
				else{


			    	 // insert mode, new form, new step
					
					/* NEED TO CREATE THE FORM WITH FORM NAME */
					$sql = "INSERT INTO form_id() VALUES ()";
					$userdata = $bdd->query($sql);
					
					
					$formIdData = $bdd->query("SELECT LAST_INSERT_ID();");
					$form_idArray = $formIdData->fetch();
					$form_id = $form_idArray[0];
					echo "YOU CREATED THE FORM : ";
					echo $form_id;
					echo "<br>";
					$newFormName = "Map nb ".$form_id;
					$sql = "UPDATE  form_id SET "
					. "form_name=".$bdd->quote($newFormName)
					. " WHERE form_id = ".$bdd->quote($form_id);
					$userdata = $bdd->query($sql);



						$title = "Step without name";
						$step_color = "#f0ad4e";
						$sql = "INSERT INTO step("
						. "title,"
						. "step_color"
						. " ) VALUES ("
						. $bdd->quote($title).","
						. $bdd->quote($step_color).")";
						$userdata = $bdd->query($sql);

						
						// $stepIdData = $bdd->query("SELECT LAST_INSERT_ID()");
						// $step_idArray = $stepIdData->fetch();
						// $step_id = $step_idArray[0];

						$step_id = $bdd->lastInsertId();
				        echo "STEP ID ".$step_id;
					// $sql = "INSERT INTO step() VALUES ()";
					// $userdata = $bdd->query($sql);

					$stepIdData = $bdd->query("SELECT LAST_INSERT_ID();");
					$step_idArray = $stepIdData->fetch();
					$step_id = $step_idArray[0];
					echo "YOU CREATED THE STEP : ";
					echo $step_id;
					echo "<br>";

					/*Make the link between step */


					$sql = "INSERT INTO form("
					. "form_id,step_id"
					. " ) VALUES ("
					. $bdd->quote($form_id).","
					. $bdd->quote($step_id).")";
					$userdata = $bdd->query($sql);


					$sql = "SELECT MAX(step_order) FROM form WHERE form.form_id=$form_id";
					$stepOrderData = $bdd->query($sql);
					$stepOrderArray = $stepIdData->fetch();
					$stepOrderMaxPlusOne= $stepOrderArray[0] +1;

					$sql = "UPDATE form SET "
					. "step_order=".$bdd->quote($stepOrderMaxPlusOne)
					. " WHERE step_id = ".$bdd->quote($step_id);
					$userdata = $bdd->query($sql);

					include("editStep.php");

				}
			}

			elseif($booleanViewMapStep){

				$step_id = $_GET['step_id'];
				$form_id = $_GET['form_id'];

				include("connectDB.php");
				$mapReadLink = "map_read.php?form_id=".$form_id;

				?>
				<iframe src=<?php echo $mapReadLink ?> style="border: 0; width: 100%; height: 25em"></iframe>


				<?php
				include("editStep.php");

			}
						elseif($booleanViewMapMenu){

				
				$form_id = $_GET['form_id'];

				include("connectDB.php");
				$mapReadLink = "map_read.php?form_id=".$form_id;

				?>
				<iframe src=<?php echo $mapReadLink ?> style="border: 0; width: 100%; height: 25em"></iframe>


				<?php
				include("editLeftMenu.php");

			}
			elseif(isset($_POST['leftMenu'])){


				$form_id = $_POST['form'];
				include("editLeftMenu.php");
			}

			
			elseif(isset($_GET['changeLeftMenu'])){

				//echo "CHANGED";
				$changed = true;

				include("editLeftMenuScript.php");
				include("editLeftMenu.php");
			}
			
			// echo "<br/>GET <br/>";
			// echo var_dump($_GET);
			//echo "<br/>POST <br/>".var_dump($_POST);
			?>


		</body>
		</html>