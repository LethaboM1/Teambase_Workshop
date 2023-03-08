<?php
$tyre_report = dbf(dbq("select * from jobcard_tyre_reports where id={$row['id']}"));
$jobcard_ = get_jobcard($tyre_report['job_id']);
$plant_ = get_plant($jobcard_['plant_id']);
$mechanic_ = ($jobcard_['mechanic_id'] > 0) ? get_user($jobcard_['mechanic_id']) : ['name' => 'none', 'last_name' => ''];
$checked_by = ($tyre_report['checked_by'] > 0) ? get_user($tyre_report['checked_by']) : ['name' => 'none', 'last_name' => ''];
?>

<tr class="pointer" onclick="window.open(`print.php?type=tyre-report&id=<?= $tyre_report['id'] ?>`,`_blank`)">
	<td><?= $tyre_report['date_time'] ?></td>
	<td><?= $jobcard_['jobcard_number'] ?></td>
	<td><?= $plant_['plant_number'] ?></td>
	<td><?= $mechanic_['name'] . ' ' . $mechanic_['last_name'] ?></td>
	<td><?= $checked_by['name'] . ' ' . $checked_by['last_name'] ?></td>
	<td><?= (strlen($tyre_report['checked_note']) > 0) ? $tyre_report['cehcked_note'] : "" ?></td>
	<td></td>
</tr>