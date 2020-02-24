<?php
$host = "localhost"; 
$database = "pricelist"; 
$user = "root"; 
$password = "bypass";

// Create connection
        $conn = new mysqli($host, $user, $password, $database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

?>
