<?php

	require __DIR__."/report.php";
	require __DIR__."/feature.php";

	$sel_item = $_POST[$item_name];
	$sel_place = $_POST[$report_place];
	$sel_date = $_POST[$report_date];
	$sel_r_type = $_POST[$report_type];
	$sel_i_type = $_POST[$item_type];
	$sel_acc = $_POST[$r_acc_id];
	$features = array($_POST[$feature_table]);

	require __DIR__."/finditConnect.php";
	require __DIR__."/getReport.php"

	$sql = "INSERT INTO $report_table ($r_acc_id, $item_name, $item_type, $report_place, $report_date, $report_type, $log_date) 
	VALUES ($sel_acc, $sel_item, $sel_i_type, $sel_place, $sel_date, $sel_r_type, CURTIME())";

	if($conn->query($sql) == TRUE) {
		$lastid = $conn->insert_id;

		foreach ($features as $feat) {
			$sql = "INSERT INTO $feature_table ($f_report_id, $feature) VALUES ($lastid, $feat)";

			if($conn->query($sql) != TRUE) {
				echo $conn->error;
			}
		}

		echo getReport($lastid);
	} else {
		echo $conn->error;
	}

	$conn->close();
?>