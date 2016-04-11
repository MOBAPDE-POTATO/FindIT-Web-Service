<?php
	
	header('Content-Type: application/json');
	
	require __DIR__."/account.php";

	$sel_gcm = $_POST[$gcm_id];
	$sel_pass = $_POST[$password];
	$sel_email = $_POST[$email];

	if($sel_pass == '' || $sel_email == '') {
		echo "ERROR: Fill all fields";
	} else {
		require __DIR__."/finditConnect.php";
		require __DIR__."/getAccount.php";

		$sql = "SELECT $a_acc_id FROM $account_table WHERE $email = '$sel_email' AND $password = '$sel_pass'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			foreach ($result as $row) {
				// echo $row[$a_acc_id];
				$sql = "UPDATE $account_table SET $gcm_id = '$sel_gcm' WHERE $a_acc_id = $row[$a_acc_id]";
				$update = $conn->query($sql);

				echo getAccount($row[$a_acc_id]);
			}
		} else {
			echo $conn->error;
		}

		$conn->close();
	}

?>