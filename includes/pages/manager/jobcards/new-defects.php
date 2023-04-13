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

			$get_defect_reports = dbq("select * from ws_defect_reports where status='F'");

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

			$get_defect_reports = dbq("select * from ws_defect_reports where status='F' order by date DESC limit {$start},$lines");

			if ($get_defect_reports) {
				if (dbr($get_defect_reports) > 0) {
					while ($report = dbf($get_defect_reports)) {
						/* Get Stuff */
						$plant_ = get_plant($report['plant_id']);
						$operator_ = ($report['operator_id'] != 0) ? get_user($report['operator_id']) : ['name' => 'None', 'last_name' => ''];
						echo "<tr class='pointer'>
								<td onclick='$(`#link_{$report['id']}`).click()'>
									{$report['date']}
									<a id='link_{$report['id']}' class='mb-1 mt-1 mr-1 modal-sizes' href='#ModalViewReport_{$report['id']}'></a>
									
									<div id='ModalViewReport_{$report['id']}' class='modal-block modal-block-lg mfp-hide'>
										<section class='card'>
											<header class='card-header'>
												<div class='row'>
													<div class='col-md-6'>
														<h2 class='card-title'>View Job Card</h2>
													</div>
													<div class='col-md-6'>
														<button onclick='window.open(`print.php?type=defect-report&id={$report['id']}`,`_blank`);' class='btn btn-warning float-right'>Print Report</button>
													</div>
												</div>
											</header>
											<div class='card-body'>
												<div class='modal-wrapper'>
													<div class='modal-text'>
														<form method='post'>"
							. inp('report_id', '', 'hidden', $report['id'])
							. inp('comment', 'Comment', 'textarea')
							. "<p>What action do you want to take?</p>"
							. inp('reviewed', '', 'inline-submit', 'Reviewed', 'btn btn-info')
							. inp('create_jobcard', '', 'inline-submit', 'Open Job Card', 'btn btn-primary')
							. "							</form>
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
								<td onclick='$(`#link_{$report['id']}`).click()'>{$plant_['plant_number']}" . (strlen($plant_['fleet_number']) > 0 ? "-" . $plant_['fleet_number'] : "") . "</td>
								<td onclick='$(`#link_{$report['id']}`).click()'>{$operator_['name']}" . (strlen($operator_['last_name']) > 0 ? " " . $operator_['last_name'] : "") . "</td>
								<td onclick='$(`#link_{$report['id']}`).click()'>{$report['site']}</td>
								<td class='pointer' onclick='window.open(`print.php?type=defect-report&id={$report['id']}`,`_blank`)'>
									<i class='fa fa-print'></i>
								</td>
							</tr>";
					}
				} else {
					echo "<tr><td colspan='7'>Nothing to list</td></tr>";
				}
			}
			?>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination" id="pageination">
				<li class="page-item"><a class="page-link" href="dashboard.php?page=new-defects&pg=1"><?= "<<" ?></a>
				</li>
				<li class="page-item"><a class="page-link" href="dashboard.php?page=new-defects&pg=<?php echo $start_page - 1 ?>">Previous</a></li>
				<?php

				for ($a = $start_page; $a <= $end_page; $a++) {
					echo "<li class='page-item'><a class='page-link' href='dashboard.php?page=new-defects&pg={$a}'>";
					if ($_GET['page'] == $a) {
						echo "<b>{$a}</b>";
					} else {
						echo $a;
					}
					echo "</a></li>";
				}
				?>
				<li class="page-item"><a class="page-link" href="dashboard.php?page=new-defects&pg=<?php echo $pagination * $pagination_pages + 1 ?>">Next</a></li>
				<li class="page-item"><a class="page-link" href="dashboard.php?page=new-defects&pg=<?php echo $pages ?>">>></a></li>
			</ul>
		</nav>
	</div>
</div>