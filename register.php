<?php

	require __DIR__."/finditConnect.php";
	require __DIR__."/account.php";
	require __DIR__."/getAccount.php";

	$sql = "INSERT INTO $account_table ($f_name, $l_name, $password, $email, $acc_type) 
		VALUES ($_POST[$f_name], $_POST[$l_name], $_POST[$password], $_POST[$email], $_POST[$acc_type])";

	if($conn->query($sql) == TRUE) {
		$last_id = $conn->insert_id;

		echo getAccount($last_id);
	} else {
		echo "Error: ".$sql."<br>".$conn->error;
	}

	$conn()->close();

?>