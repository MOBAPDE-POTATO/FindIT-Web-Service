<?php

	ini_set("display_errors", 1);

	require __DIR__."/finditConnect.php";
	require __DIR__."/report.php";
	require __DIR__."/feature.php";

	$sql = "SELECT * FROM $report_table WHERE $report_type = 1";

	$report_result = $conn->query($sql);
	$xmlData = "<?xml version = '1.0' encoding = 'UTF-8'?>
	<$report_table>";

	if($report_result->num_rows > 0) {
		foreach($report_result as $row) {
			$sql = "SELECT $feature FROM $feature_table WHERE $f_report_id = $row[$r_report_id]";
			
			$feat_result = $conn->query($sql);

			$xmlData = "$xmlData
			<Report id = '$row[$r_report_id]'>
			<$item_name> $row[$item_name] </$item_name>
			<$item_type> $row[$item_type] </$item_type>
			<$log_date> $row[$log_date] </$log_date>
			<$report_place> $row[$report_place] </$report_place>
			<$report_date> $row[$report_date] </$report_date>";

				if($feat_result->num_rows > 0) {
					$xmlData = "$xmlData
					<$feature_table>";

					foreach($feat_result as $f_row) {
						$xmlData = $xmlData."
						<$feature> $f_row[$feature] </$feature>";
					}

					$xmlData = $xmlData."</$feature_table>";
				}
			$xmlData = $xmlData."</Report>";
		}
	} else {
		echo("0 results");
	}

	$xmlData = $xmlData."</$report_table>";
	$xml = new SimpleXMLElement($xmlData) or die("Cannot Create Object");
	$json = json_encode($xml);

	echo $json;

	$conn->close();
?>