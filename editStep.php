<?php
$namePage = basename($_SERVER['PHP_SELF']);
?>

 <div class="form">
	        <h1> Step Editing</h1>
	        <?php
				echo "You are modifying map id : ".$form_id . " and step id".$step_id;
				echo "<br/>To add it in the webform of vicidial, add the following link : <strong>http://internationalcallcentre.com/eyesee_map/agent_guide2.php?form_id=".$form_id ."&</strong> and add all the autocomplete variables from vicidial";
				?>
				<br>
				<div style="margin-left:10em;">
				<form action='<?php echo $namePage; ?>' method='get' style="float:left;">
					<input type='hidden' name="viewMap" value="true">
					<input type='hidden' name="form_id" value="<?php echo $form_id; ?>">
					<input type='hidden' name="step_id" value="<?php echo $step_id; ?>">

					<button type='submit' > View the map</button>
				</form><form action='<?php echo $namePage; ?>' method='get' style='margin-left:10em;'>
					<input type='hidden' name="perm" value="admin">

					<button type='submit' >Select a different map</button>
				</form>
				</div>
				<br/>
				<?php
				// echo "<br/><a href=$namePage?perm=admin> Select different map / step <a/><br/>";
				
				?>
				 <!-- select step -->
	            <?php
	            $resultquery = $bdd->query("SELECT * FROM form JOIN step on form.step_id=step.step_id WHERE form.form_id =$form_id ORDER BY form.step_order");

				
				?>
				Select another step :


<!-- 				<form action="map_costumized4.php?perm=admin" method="post">
					<select name="step">
						<?php

							while ($listStep = $resultquery->fetch()) {
								//echo "$stepOr['step_order'] ".$stepOr['step_order'];
							
								$stepOrdShow = $stepOr['step_order'];
								if($listStep['step_id']==$step_id){
									
									?>
									<option value="<?php echo $listStep['step_id'] ?>" selected><?php echo $listStep['title'] ?></option>
									<?php
								}
								else{

						?>

								 <option value="<?php echo $listStep['step_id'] ?>" ><?php echo $listStep['title'] ?></option>

						<?php
								}
							# code...
						}
						?>
					 
					</select>
					<input type="hidden" name="form" value="<?php echo $form_id?>">
					<button type="submit" name="submit" value="Submit">Go!</button>
				</form> -->

				<form action="map_costumized4.php?perm=admin" method="post">
					<input type="hidden" name="form" value="<?php echo $form_id?>">
					<input type="hidden" name="submit" value="Submit">
					 <?php

					$result = $bdd->query("SELECT * FROM step INNER JOIN form ON form.step_id = step.step_id WHERE form_id = $form_id ORDER By step_order");

				    /* We get each step one by one */
				    while ($data = $result->fetch())
				    {
				      $classFontsize = "btn-font-".htmlspecialchars($dataForm['btn_font_size']);
				      ?>
				      <button type="submit" name="step" class="btn btn-warning btn-arrow-right <?php echo htmlspecialchars($classFontsize) ?>" style="background-color: <?php echo htmlspecialchars($data['step_color']) ?>;" onclick="show(<?php echo htmlspecialchars($data['step_id']); ?>)" value="<?php echo htmlspecialchars($data['step_id']); ?>"><?php echo htmlspecialchars($data['title']); ?></button>

				      <?php
				    }
				    ?>
					
				</form>

				<br>
				<div style="margin-left:7em;">
				<form action='<?php echo $namePage; ?>' method='get' style="float:left; margin-right:1em;">
					<input type='hidden' name="perm" value="admin">
					<input type='hidden' name="deleteMap" value="true">
					<input type='hidden' name="form_id" value="<?php echo $form_id; ?>">

					<button type='submit' style="background-color: red;"> Delete the map</button>
				</form><form action='<?php echo $namePage; ?>' method='get' style='float:left; margin-right:1em;'>
					<input type='hidden' name="perm" value="admin">
					<input type='hidden' name="deleteStep" value="true">
					<input type='hidden' name="form_id" value="<?php echo $form_id; ?>">
					<input type='hidden' name="step_id" value="<?php echo $step_id; ?>">

					<button type='submit' style="background-color: red;">Delete the step</button>
				</form>
				<form action='<?php echo $namePage; ?>' method='get' style=''>
					<input type='hidden' name="perm" value="admin">
					<input type='hidden' name="nextStep" value="true">
					<input type='hidden' name="form_id" value="<?php echo $form_id; ?>">
					<button type='submit' style="font-weight: bold;">Create new step</button>
				</form>
				</div>
				<br/>


				<?

				// echo "<br/><a href=$namePage?perm=admin&deleteMap=true&form_id=$form_id> Delete the map<a/>";
				// echo "<br/><a href=$namePage?perm=admin&deleteStep=true&step_id=$step_id&form_id=$form_id> Delete the step<a/>";
				// echo "<br/><br/><a style='font-size: 150%;' href=$namePage?perm=admin&nextStep=true&form=$form_id> Create next step<a/>";

				if(isset($_GET['booleanModify'])){
					$edited = true;
				}
				else{
				$edited = false;
				}

				if($edited) {

					echo "<p style='font-size: 150%; text-align: center;'><em>The step $step_id has been edited !</em></p>";
				}

		       //	echo " / ";
		       	//echo $step_id;
	        ?>
  <form action="map_costumized4.php?modify=true" method = "post">

				        <?php
				$resultquery = $bdd->query("SELECT * FROM form_id WHERE form_id.form_id = $form_id");
				$formName = $resultquery->fetch();
				$formNameStr = $formName['form_name'];
				//echo $formNameStr;
			//	$formNameStr = $formName['0']['form_name'];
				?>
			
	 <br />

	<script>
	// ABLE TO EDIT a normal text field
	$(document.documentElement)
	    .on("click", "span.item-display", function(event) {
	        $(event.currentTarget)
	            .hide()
	            .next("span.item-field")
	            .show()
	            .find(":input:first")
	            .focus()
	            .select();
	    })
	    .on("keypress", "span.item-field", function(event) {
	        if (event.keyCode != 13)
	            return;
	        
	        event.preventDefault();
	        
	        var $field = $(event.currentTarget),
	            $display = $field.prev("span.item-display");
	        
	        $display.html($field.find(":input:first").val());
	        $display.show();
	        $field.hide();
	    });
	</script>

	 <strong>Name of the Map: </strong>
	 <?php
	 if(is_null($formNameStr)){
	 	$formNameStr = "Enter a map name here";
	 }
	 ?>
					<span class="item-display" alt="Click to edit"><?php echo htmlspecialchars($formNameStr) ?></span>
	                <span class="item-field">
	                    <input type="text" name="form_name" value="<?php echo htmlspecialchars($formNameStr) ?>" />
	                </span>
	                  <?php
	                echo "<em>".htmlspecialchars($form_name_err)."</em>";
	                ?>
	  <br />
	            <br />

	            <!-- relatively order the step -->
	            <?php
	            $resultquery = $bdd->query("SELECT * FROM form JOIN step on form.step_id=step.step_id WHERE form.step_id != $step_id AND form.form_id =$form_id ORDER BY form.step_order");

	            $resultquery2 = $bdd->query("SELECT * FROM form WHERE form.step_id = $step_id");
				$stepOrAct = $resultquery2->fetch();
				$stepOrActStr = $stepOrAct['step_order']-1;

				// echo "stepOrAct";
				// echo $stepOrAct['step_order'];
				
				?>
				Put this step after :
				<select name="previous_step">
					<option value="0">As first step</option>
					<?php

						while ($stepOr = $resultquery->fetch()) {
							//echo "$stepOr['step_order'] ".$stepOr['step_order'];
						
							$stepOrdShow = $stepOr['step_order'];
							if($stepOr['step_order']==$stepOrActStr){
								
								?>
								<option value="<?php echo $stepOr['step_order'] ?>" selected>Step <?php echo $stepOrdShow." - ".$stepOr['title'] ?></option>
								<?php
							}
							else{

					?>

							 <option value="<?php echo $stepOr['step_order'] ?>">Step <?php echo $stepOrdShow." - ".$stepOr['title'] ?></option>

					<?php
							}
						# code...
					}
					?>
				 
				</select>
				<?php
				$stepOrStr = $stepOr['step_order'];
				//echo $stepOrStr;
			//	$formNameStr = $formName['0']['form_name'];
				?>
				<!-- 
	 			<?php
				$resultquery = $bdd->query("SELECT * FROM form WHERE form.step_id = $step_id");
				$stepOr = $resultquery->fetch();
				$stepOrStr = $stepOr['step_order'];
				//echo $stepOrStr;
			//	$formNameStr = $formName['0']['form_name'];
				?>

				<?php
	 				if(is_null($stepOrStr)){
	 				$stepOrStr = "Enter the position of the step here";
				 }
				 ?>
	            <strong>Position of the step (Enter only integer !):</strong> 
				<span class="item-display" alt="Click to edit"><?php echo htmlspecialchars($stepOrStr) ?></span>
	            <span class="item-field">
	                    <input type="text" name="step_order" value="<?php echo htmlspecialchars($stepOrStr) ?>" />
	                </span>
	                <?php
	                if (!IsNullOrEmptyString($step_order_err)){
	                	echo "<em>".htmlspecialchars($step_order_err).", you have typed : ".htmlspecialchars($step_order_err_typed)."</em>";
	                }
	                
	                ?> -->

	            <br />

	            <?php
				$resultquery = $bdd->query("SELECT * FROM step WHERE step.step_id = $step_id");
				$stepArr = $resultquery->fetch();
				
				?>
				<br /> 
				<strong>Step title:</strong>
				<?php
				if (!IsNullOrEmptyString($stepArr['title'])){
					?>
				<span class="item-display" alt="Click to edit"><?php echo htmlspecialchars($stepArr['title']) ?></span>
	            <span class="item-field">
	                    <input type="text" name="title" value="<?php echo htmlspecialchars($stepArr['title']) ?>" />
	                </span>
	             <?php
	             }
	             else{
	             	?>
	             		             <br /> <input type="text" name="title" value="Enter a title here" /><br />
	              <?php
	             	if (!IsNullOrEmptyString($title_err)){
	                echo "<em>".htmlspecialchars($title_err)."</em>";
	           		}	
	                ?>
	             	<?php
	             }   
				?>
				<br />
	            <br />
	            <div style=" float:left;">
	             Chose the color of the step : 
	            </div>
	            <input type="color" name="step_color" value="<?php echo htmlspecialchars($stepArr['step_color']) ?>" style="width:5%; float:left;"> 
	             <br />
	             <br/>

	            <strong>Step description:​</strong><textarea id="txtArea" name="text" rows="10" cols="70" value="dwdwd" ><?php echo htmlspecialchars($stepArr['text']) ?></textarea> 
	            <script>

 			CKEDITOR.replace( 'txtArea' );
				</script>
	            <br /> 


	            <strong>Recording :</strong>
	            <br />
	<audio controls="" disabled="disabled" name="view_field15_Client" id="view_field15_Client">  <source src="Recordmp3js-master/recordings/<?php echo htmlspecialchars($stepArr['recording']) ?>" type="audio/wav">   Your browser does notsupport the audio tag.</audio>
			  
			  <!--
			  <br />
			    Recording address:  <input type="text" name="recording" value="<?php echo $stepArr['recording'] ?>" /> <br />
				-->
				
				
			


				 <strong><a href="#changeRecord">Change the recording</a></strong>
				 <br/>	



				        <section id="changeRecord">
				            <!-- THIS SECTION IS FOR RECORDING-->

				<h1>Make a recording
				</h1>

				  <p>Make sure you are using a recent version of Google Chrome.</p>
				  <p>Also before you enable microphone input either plug in headphones or turn the volume down if you want to avoid ear splitting feedback!</p>

				  <button onclick="startRecording(this);">record</button>
				  <button onclick="stopRecording(this);" disabled>stop</button>
				  
				  <h2>List of recordings made</h2>
				  Listen to the new recordings, save on the server the good ones, select the recording you want to use for this step if you want to change it.
				  <ul id="recordingslist"></ul>
				  
				  <h2>Log</h2>
				  <pre id="log"></pre>

			   <!-- THIS SECTION IS FOR RECORDING-->	
				        </section>


			
				<input type="hidden" name="form" value="<?php echo $form_id ?>"/>
			    <input type="hidden" name="step" value="<?php echo $step_id ?>"/>
				<input type="hidden" name="former_step_order" value="<?php echo $stepOrAct['step_order']; ?>"/>
	            <br />
	            <input type="submit" name="submit"/>
	        </form>


	</div>