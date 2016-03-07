<?php
	
	require __DIR__."/report.php";

	$account_id = $_GET[$r_acc_id];

	if($account_id == '') {
		echo "ERROR: No ID was given";
	} else {
		require_once __DIR__."/finditConnect.php";

		$sql = "SELECT * FROM $report_table WHERE $r_acc_id = $account_id AND $report_type = 1";
		$result = $conn->query($sql);
		$xmlData = "<?xml version = '1.0' encoding = 'UTF-8'?>
		<$report_table>";

		if($result->num_rows > 0) {
			foreach ($result as $row) {
				$sql = "SELECT * FROM $feature_table WHERE $f_report_id = $row[$r_report_id]";
			
				$feat_result = $conn->query($sql);

				$xmlData = "$xmlData
				<Report>
				<$r_report_id>$row[$r_report_id]</$r_report_id>
				<$item_name>$row[$item_name]</$item_name>
				<$item_type>$row[$item_type]</$item_type>
				<$log_date>$row[$log_date]</$log_date>
				<$report_place>$row[$report_place]</$report_place>
				<$report_date>$row[$report_date]</$report_date>";

					if($feat_result->num_rows > 0) {
						foreach ($feat_result as $f_row) {
							$xmlData = "$xmlData
							<$feature_table>
							<$f_feat_id>$f_row[$f_feat_id]</$f_feat_id>
							<$feature>$f_row[$feature]</$feature>
							</$feature_table>";
						}
					}
				
				$xmlData = $xmlData."</Report>";
			}
		}

		$xmlData = "$xmlData
		</$report_table>";
	
		$xml = new SimpleXMLElement($xmlData) or die("Cannot Create Object");
		$json = json_encode($xml);

		echo $json;
		
		$conn->close();
	}

?>