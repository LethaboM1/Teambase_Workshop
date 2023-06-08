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
                                                    type: 'defect-reports',
                                                    search: $('#search').val()
                                                },
                                                success:function (result) {
                                                    $('#defect_reports').html(result);
                                                },
                                                error: function (err) {}
                                            });
                                        });

                                        ";
            ?>

        </div>
    </div>
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
            <tbody id='defect_reports'>
                <?php
                $lines = 15;
                $pagination_pages = 15;

                if (!isset($_GET['pg']) || $_GET['pg'] < 1) {
                    $_GET['pg'] = 1;
                }

                $get_defect_reports = dbq("select * from ws_defect_reports where status!='F'");

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

                $get_defect_reports = dbq("select * from ws_defect_reports where status!='F' order by date DESC limit {$start},$lines");

                if ($get_defect_reports) {
                    if (dbr($get_defect_reports) > 0) {
                        while ($row = dbf($get_defect_reports)) {
                            //echo "<tr><td colspan='7'>" . print_r($row, 1) . "</td></tr>";
                            require "list_job_defect_reports.php";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nothing to list</td></tr>";
                    }
                }
                ?>
            </tbody>
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