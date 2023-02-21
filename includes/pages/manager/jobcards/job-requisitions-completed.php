<?php

?>
<div class="row">
	<div class="header-right col-lg-4 col-md-4">
		<div class="input-group">
			<input type="text" class="form-control" name="search" id="search" placeholder="Search Job...">
			<button class="btn btn-default" id='searchBtn' type="button"><i class="bx bx-search"></i></button>
			<?php
			$jscript .= "
									
									$('#search').keyup(function (e) {
										if (e.key=='Enter') {
											$('#searchBtn').click();
										}
						
						
										if (e.key=='Backspace') {
											if ($('#search').val().length==0) {
												$('#resetOpenBtn').click();
											}
										}
									});
						
									$('#searchBtn').click(function () {
										$.ajax({
											method:'post',
											url:'includes/ajax.php',
											data: {
												cmd:'search',
												type: 'job-requisitions-completed',
												search: $('#search').val()
											},
											success:function (result) {
												$('#job_requisitions_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
			?>

		</div>
	</div>
	<div class="col-xl-12">
		<table class="table table-hover">
			<thead>
				<tr>
					<td>#</td>
					<td>Plant No.</td>
					<td>Mechanic</td>
					<td>Status</td>
					<td></td>
				</tr>
			</thead>
			<tbody id="job_requisitions_list">
				<?php
				//connectDb("{$_SESSION['account']['account_key']}_db");
				$lines = 15;
				$pagination_pages = 15;

				if (!isset($_GET['pg']) || $_GET['pg'] < 1) {
					$_GET['pg'] = 1;
				}

				if ($_SESSION['user']['role'] == 'clerk') {
					$get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected') and clerk_id={$_SESSION['user']['user_id']} order by datetime");
				} else if ($_SESSION['user']['role'] == 'buyer') {
					$get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected') and buyer_id={$_SESSION['user']['user_id']} order by datetime");
				} else {
					$get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected') order by datetime");
				}

				$total_lines = dbr($get_requisitions);

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


				if ($_SESSION['user']['role'] == 'clerk') {
					$get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected') and clerk_id={$_SESSION['user']['user_id']} order by datetime limit {$start},$lines");
				} else if ($_SESSION['user']['role'] == 'buyer') {
					$get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected') and buyer_id={$_SESSION['user']['user_id']} order by datetime limit {$start},$lines");
				} else {
					$get_requisitions = dbq("select * from jobcard_requisitions where (status='completed' || status='canceled' || status='rejected') order by datetime limit {$start},$lines");
				}

				if ($get_requisitions) {
					if (dbr($get_requisitions) > 0) {
						while ($row = dbf($get_requisitions)) {
							require "./includes/pages/manager/jobcards/list_job_requisitions_completed.php";
						}
					} else {
						echo "<h4>No open job requisitions.</h4>";
					}
				}
				?>
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination" id="pageination">
				<li class="page-item"><a class="page-link" href="dashboard.php?page=job-requisitions-completed&pg=1"><?= "<<" ?></a>
				</li>
				<li class="page-item"><a class="page-link" href="dashboard.php?page=job-requisitions-completed&pg=<?php echo $start_page - 1 ?>">Previous</a></li>
				<?php

				for ($a = $start_page; $a <= $end_page; $a++) {
					echo "<li class='page-item'><a class='page-link' href='dashboard.php?page=job-requisitions-completed&pg={$a}'>";
					if ($_GET['page'] == $a) {
						echo "<b>{$a}</b>";
					} else {
						echo $a;
					}
					echo "</a></li>";
				}
				?>
				<li class="page-item"><a class="page-link" href="dashboard.php?page=job-requisitions-completed&pg=<?php echo $pagination * $pagination_pages + 1 ?>">Next</a></li>
				<li class="page-item"><a class="page-link" href="dashboard.php?page=job-requisitions-completed&pg=<?php echo $pages ?>">>></a></li>
			</ul>
		</nav>


		<?php
		$jscript .= "
				$('#searchBtn').click(function() {
					setTimeout(function() {
						$.getScript('js/examples/examples.modals.js');
					}, 300);

				});
				";

		$jscript_function = "
						function print_request (request_id) {
							$.ajax({
								method:'get',
								url:'includes/ajax.php',
								data: {
									cmd:'print_request',
									id: request_id
								},
								success: function (result) {
									let data = JSON.parse(result);
									if (data.status=='ok') {
										window.open(data.path,`_blank`);
									} else if (data.status=='error') {
										console.log(`Error: `. data.message);
									} else {																						
										console.log(`Error: API error`);
									}
								}	
							});
						}
						";
