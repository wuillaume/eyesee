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
/*echo "Connected successfully";*/

		if (isset($_POST['changeRecording'])) {
			$changeRecording = $_POST['changeRecording'];
			if (isset($_POST['stepId'])) {
				$step_id = $_POST['step'];
				 $sql = "UPDATE step SET "
			            . "recording=".$conn->quote($changeRecording)
			            . " WHERE step_id = ".$conn->quote($step_id);
			            echo $sql;
			        $userdata = $conn->query($sql);
			}

		}
   

} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>