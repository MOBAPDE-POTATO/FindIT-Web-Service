<?php

	header('Content-Type: application/json');
	
	require __DIR__."/account.php";

	$sel_gcm = $_POST[$gcm_id];
	$sel_fname = $_POST[$f_name];
	$sel_lname = $_POST[$l_name];
	$sel_pass = $_POST[$password];
	$sel_email = $_POST[$email];

	if($sel_fname == '' || $sel_lname == '' || $sel_pass == '' || $sel_email == '') {
		echo "ERROR: Fill all fields";
	} else {
		require __DIR__."/finditConnect.php";
		require __DIR__."/getAccount.php";

		$sql = "SELECT $a_acc_id FROM $account_table WHERE $email = '$sel_email'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			echo "ERROR: Email already being used!";
		} else {
			$sql = "INSERT INTO $account_table ($gcm_id, $f_name, $l_name, $password, $email) 
			VALUES ('$sel_gcm', '$sel_fname', '$sel_lname', '$sel_pass', '$sel_email')";

			if($conn->query($sql) == TRUE) {
				$last_id = $conn->insert_id;
				
				echo getAccount($last_id);
			} else {
				echo "ERROR: Something happened on our side! Contact us instead!";
			}
		}

		$conn->close();
	}

?>