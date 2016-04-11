<?php
	// header('Content-Type: application/json');
	
	require __DIR__."/report.php";
	require __DIR__."/feature.php";

	$sel_item = $_POST[$item_name];
	$sel_place = $_POST[$report_place];
	$sel_date = $_POST[$report_date];
	$sel_r_type = $_POST[$report_type];
	$sel_i_type = $_POST[$item_type];
	$sel_acc = $_POST[$r_acc_id];

	require __DIR__."/finditConnect.php";
	require __DIR__."/getReport.php";

	$sql = "INSERT INTO $report_table ($r_acc_id, $item_name, $item_type, $report_place, $report_date, $report_type, $log_date) VALUES ($sel_acc, '$sel_item', $sel_i_type, '$sel_place', '$sel_date', $sel_r_type, CURTIME())";
	
	if($conn->query($sql) == TRUE) {
		$lastid = $conn->insert_id;

		if(!empty($_POST[$feature_table])) {

			foreach ($_POST[$feature_table] as $feat) {
				$sql = "INSERT INTO $feature_table ($f_report_id, $feature) VALUES ($lastid, '$feat')";

				if($conn->query($sql) != TRUE) {
					echo "ERROR: Feature not added!\n";
					echo $conn->error;
				}
			}
			echo getReport($lastid);
		} else {
			echo getReport($lastid);
		}

		if($sel_r_type == 2) {
			//send a notifications
			require __DIR__."/account.php";
			$sql = "SELECT DISTINCT $report_table.$r_acc_id, $gcm_id FROM $report_table, $account_table 
					WHERE $report_type <> $sel_r_type 
					AND $report_table.$r_acc_id = $account_table.$a_acc_id 
					AND $item_type = $sel_i_type
					AND (
						$item_name LIKE '$sel_item'
						OR $report_date = $sel_date
						OR $report_place LIKE '$sel_place'
					)";
			
			$results = $conn->query($sql);
			if($results->num_rows > 0) {
				$deviceID = array();

				foreach ($results as $row) {
					$deviceID[] = $row[$gcm_id];
					echo $row[$gcm_id];
				}

				require __DIR__."/GCMPushMessage.php";

				$sender = new GCMPushMessage("AIzaSyAy5PvE-LxIMQs_AgsRLwduIKGQBlXtnMM");
				$sender->setDevices($deviceID);
				$temp = $sender->send("New Possible Match to a lost item");
				echo $temp;
			}
		} 

	} else {
		echo "ERROR: Report not added!\n";
		echo $sql."\n";
		echo $conn->error;
	}

	$conn->close();
?>