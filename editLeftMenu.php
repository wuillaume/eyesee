<?php
$namePage = basename($_SERVER['PHP_SELF']);
?>
  <script src="js/editLeftMenu4.js"></script>
<!-- THIS PAGE IS TO MODIFY THE LEFT MENU -->

<div class="form">
	<h1> Left Menu Editing</h1>
	<?php
	echo "You are modifying map id : ".$form_id;

	echo "<br/><br/><a href=$namePage?viewMapMenu=true&form_id=$form_id&step_id=$step_id> View the map<a/><br/>";
	echo "<br/><a href=$namePage?perm=admin> Select different map / step <a/><br/>";

	
		if($changed){
			echo "<br> <div style='text-align:center;'>You have successfully changed the menu of the map !</div>";
		}
	

	?>



	<form action="" method = "get" onsubmit="return readyToSubmit();">

		<?php
		$sql = "SELECT * FROM menu_left WHERE menu_left.form_id=$form_id ";
		$userdata = $bdd->query($sql);

		echo "Click on existing buttons to change them";
		
		while($list_menuEntry = $userdata->fetch()){

		?>
			<div>
    		<p  id="btn-warning" onclick="showButton(<?php echo $list_menuEntry['menu_left_id']; ?>)"><?php echo htmlspecialchars($list_menuEntry['menu_left_name']); ?></p><br>
    		</div>

    		<div id="existingEntry<?php echo $list_menuEntry['menu_left_id']; ?>" class="hidden">
    
			Name (required) : <input type="text" name="menu_left_name" value="<?php echo $list_menuEntry['menu_left_name']; ?>"></input>
			Link : <input type="text" name="menu_left_link" value="<?php echo $list_menuEntry['menu_left_link']; ?>"></input>
			Long text : <br> <textarea name="menu_left_text" ><?php echo $list_menuEntry['menu_left_text']; ?></textarea> <br/>
			<input name="delete" type="checkbox" value="<?php echo $list_menuEntry['menu_left_id']; ?>"> DELETE<br/>
			<input type="hidden" name="new" value="<?php echo $list_menuEntry['menu_left_id']; ?>"/>
			</div>
		<?php
		}
		?>

		<div id="container"></div>
		
		<button  id="addMenuEntr" onclick="addMenuEntry()">Add Menu entry</button>



		
		<input type="hidden" name="form" value="<?php echo $form_id ?>"/>
		<input type="hidden" name="step" value="<?php echo $step_id ?>"/>
		<br />
		<button type="submit" name="changeLeftMenu" value="true" onclick="submitOk()">Submit</button>
	</form>


	</div>