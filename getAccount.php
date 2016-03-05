<?php

	require __DIR__."/account.php";
	require __DIR__."/finditConnect.php";

	function getAccount($id) {
		$sql = "SELECT * FROM $account_table WHERE $a_acc_id = $id";

		$result = $conn->query($sql);
		$xmlData = "<?xml version = '1.0' encoding = 'UTF-8'?>
		<$account_table>";

		if($result->num_rows > 0) {
			foreach ($result as $row) {
				$xmlData = "$xmlData
				<$a_acc_id> $row[$a_acc_id] </$a_acc_id>
				<$f_name> $row[$f_name] </$f_name>
				<$l_name> $row[$l_name] </$l_name>
				<$password> $row[$password] </$password>
				<$email> $row[$email] </$email>
				<$acc_type> $row[$acc_type] </$acc_type>"
			}
		}

		$xmlData = "$xmlData.</$account_table>";

		$xml = simplexml_load_string($xmlData)
		$json = json_encode($xml)

		return $json;
	}

?>