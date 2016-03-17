<?php

	#CHANGE THESE TO WHAT YOU SET ON YOUR MACHINE
	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "1234";
	
	$dbname = "findit";

	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

	if($conn->connect_error) {
		die("Could not connect: ".$conn->connect_error);
	}
?>