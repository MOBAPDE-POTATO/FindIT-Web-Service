<?php

	$sel_pass = $_POST[$password];
	$sel_email = $_POST[$email];

	if($sel_pass == '' || $sel_email == '') {
		echo "Fill all fields";
	} else {
		require __DIR__."/finditConnect.php";
		require __DIR__."/account.php";
		require __DIR__."/getAccount.php";

		$sql = "SELECT $a_acc_id FROM $account_table WHERE $email = '$sel_email' AND $password = '$sel_pass'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			foreach ($result as $row) {
				echo $row[$a_acc_id];
			}
		} else {
			echo "No Account for this email yet or invalid credentials!";
		}

		$conn()->close();
	}

?>