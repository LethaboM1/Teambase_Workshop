<div class="row">
	<div class="header-right col-lg-4 col-md-4">
		<form action="#" class="search nav-form">
			<div class="input-group">
				<input type="text" class="form-control" name="search" id="search" placeholder="Search Plant...">
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
												type: 'user-plants',
												user_id: {$_SESSION['user']['user_id']},
												search: $('#search').val()
											},
											success:function (result) {
												$('#user_plants_list').html(result);
											},
											error: function (err) {}
										});
									});

									";
				?>

			</div>
		</form>
	</div>
	<div id="user_plants_list" class="col-xl-12">
		<?php
		$get_plants = dbq("select * from plants_tbl where operator_id={$_SESSION['user']['user_id']}");
		if (dbr($get_plants) == 0) {
			$get_plants = dbq("select * from plants_tbl where plant_id in (select plant_id from plant_user_tbl where user_id={$_SESSION['user']['user_id']}) and status='Ready'");
		}

		if ($get_plants) {
			if (dbr($get_plants) > 0) {
				while ($row = dbf($get_plants)) {
					require "./includes/pages/user/list_plants.php";
				}
			} else {
				echo "<h2>No open plants allocated to you ...</h2>";
			}
		} else {
			echo "<h2>SQL error: " . dbe() . "</h2>";
		}
		?>
	</div>
</div>