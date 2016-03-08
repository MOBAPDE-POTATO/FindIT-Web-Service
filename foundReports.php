<?php

	header('Content-Type: application/json');

	require __DIR__."/finditConnect.php";
	require __DIR__."/report.php";
	require __DIR__."/feature.php";

	// $sql = "SELECT * FROM ".$report_table." JOIN ".$feature_table." ON ".$report_id;
	$sql = "SELECT * FROM $report_table WHERE $report_type = 2";

	$report_result = $conn->query($sql);
	$xmlData = "<?xml version = '1.0' encoding = 'UTF-8'?>
	<Content>";

	if($result->num_rows > 0) {
		foreach ($result as $row) {
			$xmlData = "$xmlData
			<$report_table>
			<$r_report_id>$row[$r_report_id]</$r_report_id>
			<$report_type>$row[$report_type]</$report_type>
			<$item_name>$row[$item_name]</$item_name>
			<$item_type>$row[$item_type]</$item_type>
			<$log_date>$row[$log_date]</$log_date>
			<$report_place>$row[$report_place]</$report_place>
			<$report_date>$row[$report_date]</$report_date>
			<$claimed>$row[$claimed]</$claimed>";

			$sql = "SELECT * FROM $feature_table WHERE $f_report_id = $row[$r_report_id]";  
		
			$feat_result = $conn->query($sql);
			if($feat_result->num_rows > 0) {
				foreach ($feat_result as $f_row) {
					$xmlData = "$xmlData
					<$feature_table>
					<$f_feat_id>$f_row[$f_feat_id]</$f_feat_id>
					<$feature>$f_row[$feature]</$feature>
					</$feature_table>";
				}
			} else {
				echo $conn->error;
			}
			
			$xmlData = $xmlData."</$report_table>";
		}
	}

	$xmlData = "$xmlData
	</Content>";
	$xml = new SimpleXMLElement($xmlData) or die("Cannot Create Object");

	echo json_encode($xml);

	$conn->close();
?>