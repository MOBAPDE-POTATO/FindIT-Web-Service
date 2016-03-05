<?php

	require __DIR__."/finditConnect.php";
	require __DIR__."/report.php";
	require __DIR__."/feature.php";

	$rep_id = $_GET[$r_report_id];

	$sql = "SELECT $r_report_id, $report_date, $report_place, $item_name, $item_type FROM $report_table WHERE $report_type = 1 AND $r_report_id = $rep_id";
	$result = $conn->query($sql);

	if($result->num_rows > 0) {
		foreach ($result as $row) {
			$sel_name = $row[$item_name];
			$sel_date = $row[$report_date];
			$sel_place = $row[$report_place];
			$sel_type = $row[$item_type];
		}
	}

	$sql = "SELECT * FROM $report_table
			WHERE $report_type = 2
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
			$sql = "SELECT $feature FROM $feature_table WHERE $f_report_id = $row[$r_report_id]";
			
			$feat_result = $conn->query($sql);

			$xmlData = "$xmlData
			<Match id = '$row[$r_report_id]'>
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
			$xmlData = $xmlData."</Match>";
		}
	}

	$xmlData = $xmlData."</Matches>";
	$xml = new SimpleXMLElement($xmlData) or die("Cannot Create Object");
	$json = json_encode($xml);

	echo $json;

	$conn->close();
?>