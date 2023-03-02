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
                                    type: 'plant-checklists',
                                    search: $('#search').val()
                                },
                                success:function (result) {
                                    $('#checklist_list').html(result);

                                    setTimeout(function() {
                                        $.getScript('js/examples/examples.modals.js');
                                    }, 300);
                                },
                                error: function (err) {}
                            });
                        });

                        ";
            ?>

        </div>
    </div>
</div>

<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Date</th>
                <th>Plant No.</th>
                <th></th>
                <th>Reading</th>
                <th>Operator</th>
                <th></th>
            </tr>
        </thead>
        <tbody id='checklist_list'>
            <?php
            //connectDb("{$_SESSION['account']['account_key']}_db");
            $lines = 15;
            $pagination_pages = 15;

            if (!isset($_GET['pg']) || $_GET['pg'] < 1) {
                $_GET['pg'] = 1;
            }

            $get_checklists = dbq("select * from checklist_results order by datetime DESC");

            $total_lines = dbr($get_checklists);

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

            $get_checklists = dbq("select * from checklist_results order by datetime DESC limit {$start},$lines");


            if (dbr($get_checklists) > 0) {
                while ($row = dbf($get_checklists)) {
                    require "./includes/pages/manager/plants/list_checklists.php";
                }
            } else {
                echo "<tr><td colspan='6'>There no plant re-checklists to view.</td></tr>";
            }

            ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination" id="pageination">
            <li class="page-item"><a class="page-link" href="dashboard.php?page=plant-checklist&pg=1"><?= "<<" ?></a>
            </li>
            <li class="page-item"><a class="page-link" href="dashboard.php?page=plant-checklist&pg=<?php echo $start_page - 1 ?>">Previous</a></li>
            <?php

            for ($a = $start_page; $a <= $end_page; $a++) {
                echo "<li class='page-item'><a class='page-link' href='dashboard.php?page=plant-checklist&pg={$a}'>";
                if ($_GET['page'] == $a) {
                    echo "<b>{$a}</b>";
                } else {
                    echo $a;
                }
                echo "</a></li>";
            }
            ?>
            <li class="page-item"><a class="page-link" href="dashboard.php?page=plant-checklist&pg=<?php echo $pagination * $pagination_pages + 1 ?>">Next</a></li>
            <li class="page-item"><a class="page-link" href="dashboard.php?page=plant-checklist&pg=<?php echo $pages ?>">>></a></li>
        </ul>
    </nav>
    <?php

    $jscript_function .= "
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
    ?>
</div>