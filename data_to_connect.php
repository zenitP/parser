<?php
$host = "localhost"; // адрес сервера
$database = "pricelist"; // имя базы данных
$user = "root"; // имя пользователя
$password = "bypass";

// Create connection
        $conn = new mysqli($host, $user, $password, $database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

?>
