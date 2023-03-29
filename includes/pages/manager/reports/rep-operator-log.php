<div class="row">
    <div class="header-right col-lg-4 col-md-4">
        <h3>Report Details</h3>
        <form target="_blank" action="print.php" method="get">
            <?php
            $get_plants = dbq("select concat(plant_number,' - ',vehicle_type,' ',make,' ',model) as name, plant_id as value from plants_tbl where active=1 order by plant_number");
            if ($get_plants) {
                if (dbr($get_plants) > 0) {
                    while ($plant = dbf($get_plants)) {
                        $plant_select_[] = $plant;
                    }
                }
            }
            echo inp('id', 'Plant Number', 'datalist', $_POST['id'], '', 0, $plant_select_);
            $jscript .= "
										$('#plant_id').change(function () {
											console.log('Changed!');
											$.ajax({
												method:'post',
												url:'includes/ajax.php',
												data: {
													cmd:'get_plant_details',
													plant_id: $(this).val()
												},
												success: function (result) {
													let data = JSON.parse(result);
													if (data.status == 'ok') {
														$('#datalist_id_input').val(data . result . plant_number+` - ` + data.result.vehicle_type + ` ` +  data.result.make + ` ` + data.result.model);
													} else {
														console.log(data.message);
													}
												}
											});
										});
										";

            ?>
            <?= inp('start', 'From', 'date', date('Y-m-01')) ?>
            <?= inp('end', 'From', 'date', date('Y-m-d')) ?>
            <button class="btn btn-primary mt-2" name='type' value='operator-log' type="submit">Print</button>
        </form>
    </div>
</div>