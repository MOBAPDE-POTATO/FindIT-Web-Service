<?php

	#CHANGE THESE TO WHAT YOU SET ON YOUR MACHINE
	$dbhost = "localhost:3306";
	$dbuser = "root";
	$dbpass = "p@ssword";
	
	$dbname = "findit";

	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

	if($conn->connect_error) {
		die("Could not connect: ".$conn->connect_error);
	}
?>