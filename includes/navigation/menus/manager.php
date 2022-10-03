<?php

$get_new_jobs_notify = dbq("select job_id from jobcards where status='logged'");
$get_job_requests = dbq("select * from jobcard_requisitions where status='requested'");

$count_new_jobs = dbr($get_new_jobs_notify);
$count_new_requests = dbr($get_job_requests);

$total_notifications = $count_new_jobs + $count_new_requests;
?>
<li>
    <a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
        <i class="bx bx-bell"></i>
        <span class='badge'><?= $total_notifications ?></span>
    </a>
    <div class="dropdown-menu notification-menu">
        <div class="notification-title">
            <span class="float-end badge badge-default">3</span>
            Alerts
        </div>

        <div class="content">
            <ul>
                <?php

                if ($count_new_jobs > 0) {
                ?>
                    <li>
                        <a href="dashboard.php?page=new-job" class="clearfix">
                            <div class="image">
                                <i class="fas fa-edit bg-danger text-light"></i>
                            </div>
                            <span class="title">New Job cards</span>
                            <span class="message"><?= $count_new_jobs ?> job cards logged</span>
                        </a>
                    </li>
                <?php
                }

                if ($count_new_requests > 0) {
                ?>
                    <li>
                        <a href="dashboard.php?page=job-requisitions" class="clearfix">
                            <div class="image">
                                <i class="fas fa-edit bg-danger text-light"></i>
                            </div>
                            <span class="title">New part requests</span>
                            <span class="message"><?= $count_new_requests ?> requests</span>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>

            <!-- <hr />

            <div class="text-end">
                <a href="#" class="view-more">View All</a>
            </div>
            -->
        </div>
    </div>
</li>