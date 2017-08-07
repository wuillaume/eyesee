<?php
$namePage = basename($_SERVER['PHP_SELF']);
?>

 <div class="form">
	        <h1> Step Editing</h1>
	        <?php
				echo "You are modifying map id : ".$form_id . " and step id".$step_id;
				echo "<br/><a href=$namePage?viewMap=true&form_id=$form_id&step_id=$step_id> View the map<a/><br/>";
				echo "<br/><a href=$namePage?deleteMap=true&form_id=$form_id> Delete the map<a/>";
				echo "<br/><a href=$namePage?deleteStep=true&step_id=$step_id&form_id=$form_id> Delete the step<a/>";

		       //	echo " / ";
		       	//echo $step_id;
	        ?>


	        <form action="map_costumized4.php?modify=true" method = "post">

				        <?php
				$resultquery = $conn->query("SELECT * FROM form_id WHERE form_id.form_id = $form_id");
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
	 			<?php
				$resultquery = $conn->query("SELECT * FROM form WHERE form.step_id = $step_id");
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
	                
	                ?>

	            <br />

	            <?php
				$resultquery = $conn->query("SELECT * FROM step WHERE step.step_id = $step_id");
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

	            <strong>Step description:​</strong><textarea id="txtArea" name="text" rows="10" cols="70" value="dwdwd" ><?php echo htmlspecialchars($stepArr['text']) ?></textarea> 


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
	            <br />
	            <input type="submit" name="submit"/>
	        </form>


	</div>