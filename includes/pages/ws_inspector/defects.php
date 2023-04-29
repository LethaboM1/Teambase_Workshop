<div class="row">
	<div class="col-xl-12">
		<table class="table table-hover table-responsive-md table-bordered mb-0 dark">
			<thead>
				<tr>
					<th>Date</th>
					<th>Plant</th>
					<th>Operator</th>
					<th>Site</th>
					<th></th>
				</tr>
			</thead>
			<?php
			$lines = 15;
			$pagination_pages = 15;

			if (!isset($_GET['pg']) || $_GET['pg'] < 1) {
				$_GET['pg'] = 1;
			}

			$get_defect_reports = dbq("select * from ws_defect_reports where inspector_id={$_SESSION['user']['user_id']}");

			$total_lines = dbr($get_defect_reports);

			$pages = ceil($total_lines / $lines);

			if ($_GET['pg'] > $pages) {
				$_GET['pg'] = $pages;
			}

			$pagination = ceil($_GET['pg'] / $pagination_pages);

			$start_page = $pagination * $pagination_pages - $pagination_pages + 1;

			$end_page = $start_page + $pagination_pages;
			if ($end_page > $pages) {
				$end_page = $pages;
			}



			$start = ($_GET['pg'] * $lines) - $lines;
			if ($start < 0) $start = 0;

			$get_defect_reports = dbq("select * from ws_defect_reports where inspector_id={$_SESSION['user']['user_id']} order by date DESC limit {$start},$lines");

			if ($get_defect_reports) {
				if (dbr($get_defect_reports) > 0) {
					while ($report = dbf($get_defect_reports)) {
						/* Get Stuff */
						$plant_ = get_plant($report['plant_id']);
						$operator_ = ($report['operator_id'] != 0) ? get_user($report['operator_id']) : ['name' => 'None', 'last_name' => ''];
						echo "<tr class='pointer' onclick='window.open(`print.php?type=defect-report&id={$report['id']}`,`_blank`)'>
								<td>{$report['date']}</td>
								<td>{$plant_['plant_number']}" . (strlen($plant_['fleet_number']) > 0 ? "-" . $plant_['fleet_number'] : "") . "</td>
								<td>{$operator_['name']}" . (strlen($operator_['last_name']) > 0 ? " " . $operator_['last_name'] : "") . "</td>
								<td>{$report['site']}</td>
								<td><i class='fa fa-print'></i></td>
							</tr>";
					}
				} else {
					echo "<tr><td colspan='7'>Nothing to list</td></tr>";
				}
			} else {
				echo "<tr><td colspan='7'>SQL Error: " . dbe() . "</td></tr>";
			}
			?>
		</table>
		<?php if ($total_lines > 0) { ?>
			<nav aria-label="Page navigation example">
				<ul class="pagination" id="pageination">
					<li class="page-item"><a class="page-link" href="dashboard.php?pg=1"><?= "<<" ?></a>
					</li>
					<li class="page-item"><a class="page-link" href="dashboard.php?pg=<?php echo $start_page - 1 ?>">Previous</a></li>
					<?php

					for ($a = $start_page; $a <= $end_page; $a++) {
						echo "<li class='page-item'><a class='page-link' href='dashboard.php?pg={$a}'>";
						if ($_GET['page'] == $a) {
							echo "<b>{$a}</b>";
						} else {
							echo $a;
						}
						echo "</a></li>";
					}
					?>
					<li class="page-item"><a class="page-link" href="dashboard.php?pg=<?php echo $pagination * $pagination_pages + 1 ?>">Next</a></li>
					<li class="page-item"><a class="page-link" href="dashboard.php?pg=<?php echo $pages ?>">>></a></li>
				</ul>
			</nav>
		<?php } ?>
	</div>
</div>