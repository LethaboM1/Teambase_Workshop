<div class="row">
	<div class="col-xl-12">
		<table class="table table-responsive-md table-bordered mb-0 dark">
			<thead>
				<tr>
					<th>Date</th>
					<th>Plant</th>
					<th>Operator</th>
					<th>Site</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<?php

			$get_defect_reports = dbq("select * from ws_defect_reports where inspector_id={$_SESSION['user']['user_id']}");

			if ($get_defect_reports) {
				if (dbr($get_defect_reports) > 0) {
					while ($report = dbf($get_defect_reports)) {
						/* Get Stuff */
						$plant_ = get_plant($report['plant_id']);
						$operator_ = ($report['operator_id'] != 0) ? get_user($report['operator_id']) : ['name' => 'None', 'last_name' => ''];
						echo "<tr onclick='window.open(`print.php?type=defect-report&id={$report['id']}`,`_blank`)'>
								<td>{$report['date']}</td>
								<td>{$plant_['plant_number']}" . (strlen($plant_['fleet_number']) > 0 ? "-" . $plant_['fleet_number'] : "") . "</td>
								<td>{$operator_['name']}" . (strlen($operator_['last_name']) > 0 ? " " . $operator_['last_name'] : "") . "</td>
								<td>{$report['site']}</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>";
					}
				} else {
					echo "<tr><td colspan='7'>Nothing to list</td></tr>";
				}
			}
			?>
		</table>
	</div>
</div>