<?php 
$form_id = $_GET['form'];

if ($form_id !=0) {

	$query  = explode('&', $_SERVER['QUERY_STRING']);
	$params = array();

	foreach( $query as $param )
		{
 		 list($name, $value) = explode('=', $param, 2);
 		 $params[urldecode($name)][] = urldecode($value);
		}
		// echo var_dump($params);

	$sizeParams = count($params['menu_left_name']);

	if(array_key_exists("delete",$params)){
		$sizedelete= count($params['delete']);
		$conditionQuery = "menu_left_id =".$params['delete'][0];
		if($sizedelete>1){
			for ($x = 1; $x < $sizedelete; $x++) {
				$conditionQuery = $conditionQuery." OR menu_left_id =".$params['delete'][$x];

			}
		}

		$sql = "DELETE FROM menu_left WHERE ".$conditionQuery;
		// echo $sql;
		$bdd->query($sql);
		
	}

	for ($x = 0; $x < $sizeParams; $x++) {
    	// echo "The number is: $x <br>";
    	// echo "name :".$params['menu_left_name'][$x];

    	
    	// echo "typeNew :".$typeNew;


    	$typeNew = $params['new'][$x];
    	$menu_left_name = $params['menu_left_name'][$x];
		$menu_left_link = $params['menu_left_link'][$x];
		$menu_left_text = $params['menu_left_text'][$x];

    	if($typeNew==="true"){
    		$sql = "INSERT INTO menu_left("
		. "menu_left_name,menu_left_link,menu_left_text,form_id"
		. " ) VALUES ("
		. $bdd->quote($menu_left_name).","
		. $bdd->quote($menu_left_link).","
		. $bdd->quote($menu_left_text).","
		. $bdd->quote($form_id).")";
		$bdd->query($sql);
		
		// echo "LEFT MENU Inserted";

    	}
    	else{
    		$menu_left_id = $params['new'][$x];

    		if(!in_array($menu_left_id , $params['delete'])){
		    			$sql = "UPDATE menu_left SET "
		    			. "menu_left_name=".$bdd->quote($menu_left_name)
		    			. ",menu_left_link=".$bdd->quote($menu_left_link)
		    			. ",menu_left_text=".$bdd->quote($menu_left_text)
		    			. " WHERE  menu_left_id = ".$bdd->quote($menu_left_id);
			         	 // echo $sql;
		    			$bdd->query($sql);
   
				// echo "LEFT MENU Updates";
			}
    	}

    	
    }
} 



?>