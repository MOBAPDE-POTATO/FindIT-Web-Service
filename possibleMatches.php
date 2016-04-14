<?php

	header('Content-Type: application/json');

	require __DIR__."/finditConnect.php";
	require __DIR__."/report.php";
	require __DIR__."/feature.php";

	$rep_id = $_POST[$r_report_id];

	$sql = "SELECT $r_report_id, $report_date, $report_place, $report_type, $item_name, $item_type FROM $report_table WHERE $r_report_id = $rep_id";
	$result = $conn->query($sql);

	if($result->num_rows > 0) {
		foreach ($result as $row) {
			$sel_name = $row[$item_name];
			$sel_date = $row[$report_date];
			$sel_place = $row[$report_place];
			$sel_type = $row[$item_type];
			$sel_r_type = $row[$report_type];
		}
	}

	$sql = "SELECT * FROM $report_table
			WHERE $report_type <> $sel_r_type
			AND (
				$item_name LIKE '$sel_name'
				OR $report_date = $sel_date
				OR $report_place LIKE '$sel_place'
				OR $item_type = $sel_type
			)";

	$result = $conn->query($sql);
	$xmlData = "<?xml version = '1.0' encoding = 'UTF-8'?>
	<Matches>";
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

	$xmlData = $xmlData."</Matches>";
	$xml = new SimpleXMLElement($xmlData) or die("Cannot Create Object");
	$json = json_encode($xml);

	echo $json;

	$conn->close();
?>