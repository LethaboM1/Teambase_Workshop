<?php

?>
<div class="row">
	<div class="header-right col-lg-4 col-md-4">
		<form action="#" class="search nav-form">
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
												type: 'job-requisitions',
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
		</form>
	</div>
	<div id="job_requisitions_list" class="col-xl-12">
		<?php
		if ($_SESSION['user']['role'] == 'clerk') {
			$get_requisitions = dbq("select * from jobcard_requisitions where (status!='completed' && status!='canceled' && status!='denied') and clerk_id={$_SESSION['user']['user_id']} order by datetime");
		} else {
			$get_requisitions = dbq("select * from jobcard_requisitions where (status!='completed' && status!='canceled' && status!='denied') order by datetime");
		}

		if ($get_requisitions) {
			if (dbr($get_requisitions) > 0) {
				while ($row = dbf($get_requisitions)) {
					require "./includes/pages/manager/jobcards/list_job_requisitions.php";
				}
			} else {
				echo "<h4>No open job requisitions.</h4>";
			}
		}
		?>
	</div>
</div>