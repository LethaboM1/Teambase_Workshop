<?php

/* Get Stuff */
$plant_ = get_plant($row['plant_id']);
$operator_ = ($row['operator_id'] != 0) ? get_user($row['operator_id']) : ['name' => 'None', 'last_name' => ''];
echo "<tr class='pointer'>
	<td onclick='$(`#link_{$row['id']}`).click()'>
		{$row['date']}
		<a id='link_{$row['id']}' class='mb-1 mt-1 mr-1 modal-sizes' href='#ModalViewReport_{$row['id']}'></a>
		
		<div id='ModalViewReport_{$row['id']}' class='modal-block modal-block-lg mfp-hide'>
			<section class='card'>
				<header class='card-header'>
					<div class='row'>
						<div class='col-md-6'>
							<h2 class='card-title'>Defect Report</h2>
						</div>
						<div class='col-md-6'>
							<button onclick='window.open(`print.php?type=defect-report&id={$row['id']}`,`_blank`);' class='btn btn-warning float-right'>Print Report</button>
						</div>
					</div>
				</header>
				<div class='card-body'>
					<div class='modal-wrapper'>
						<div class='modal-text'>
							<h4>Plant:&nbsp; {$plant_['plant_number']}</h4>
							<h5>Operator: {$operator_['name']}" . (strlen($operator_['last_name']) > 0 ? " " . $operator_['last_name'] : "") . "</h5>
							Date: {$row['date']}<br>
							Site: " . (strlen($row['site']) > 0 ? $row['site'] : "None") . "
						</div>
					</div>
				</div>
				<footer class='card-footer'>
					<div class='row'>
						<div class='col-md-12 text-right'>
							<button class='btn btn-default modal-dismiss'>Cancel</button>
						</div>
					</div>
				</footer>
			</section>
		</div>
		<!-- Modal view End -->	
	</td>
	<td onclick='$(`#link_{$row['id']}`).click()'>{$plant_['plant_number']}" . (strlen($plant_['fleet_number']) > 0 ? "-" . $plant_['fleet_number'] : "") . "</td>
	<td onclick='$(`#link_{$row['id']}`).click()'>{$operator_['name']}" . (strlen($operator_['last_name']) > 0 ? " " . $operator_['last_name'] : "") . "</td>
	<td onclick='$(`#link_{$row['id']}`).click()'>{$row['site']}</td>
	<td class='pointer' onclick='window.open(`print.php?type=defect-report&id={$row['id']}`,`_blank`)'>
		<i class='fa fa-print'></i>
	</td>
</tr>";
