<?php
/*Connect to the DB */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eyesee_map";

// Create connection
try
{
	$bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
	/* $conn = new mysqli($servername, $username, $password); */
	//echo "Connected successfully";

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>