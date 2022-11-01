<?php
if ($_SESSION['user']['role'] == 'clerk') {
  $get_new_jobs_notify = dbq("select job_id from jobcards where status='logged' and clerk_id={$_SESSION['user']['user_id']}");
  $get_job_requests = dbq("select * from jobcard_requisitions where status='requested' and clerk_id={$_SESSION['user']['user_id']}");
  $get_completed_jobs = dbq("select * from jobcards where status='completed' and clerk_id={$_SESSION['user']['user_id']} order by complete_datetime");
} else {
  $get_new_jobs_notify = dbq("select job_id from jobcards where status='logged'");
  $get_job_requests = dbq("select * from jobcard_requisitions where status='requested'");
  $get_completed_jobs = dbq("select * from jobcards where status='completed' order by complete_datetime");
}
$count_new_jobs = dbr($get_new_jobs_notify);
$count_completed_jobs = dbr($get_completed_jobs);
$count_new_requests = dbr($get_job_requests);

$total_notifications = $count_new_jobs + $count_new_requests + $count_completed_jobs;
?>
<li>
  <a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
    <i class="bx bx-bell"></i>
    <span class='badge'><?= $total_notifications ?></span>
  </a>
  <div class="dropdown-menu notification-menu">
    <div class="notification-title">
      <span class="float-end badge badge-default"><?= $total_notifications ?></span>
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

        if ($count_completed_jobs > 0) {
        ?>
          <li>
            <a href="dashboard.php?page=completed-job" class="clearfix">
              <div class="image">
                <i class="fas fa-edit bg-danger text-light"></i>
              </div>
              <span class="title">Completed Job Cards</span>
              <span class="message"><?= $count_completed_jobs ?> Completed Job cards</span>
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

<?php

/* 
 
            <li>
              <a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                <i class="bx bx-list-ol"></i>
                <span class="badge">3</span>
              </a>

              <div class="dropdown-menu notification-menu large">
                <div class="notification-title">
                  <span class="float-end badge badge-default">3</span>
                  Tasks
                </div>

                <div class="content">
                  <ul>
                    <li>
                      <p class="clearfix mb-1">
                        <span class="message float-start">Generating Sales Report</span>
                        <span class="message float-end text-dark">60%</span>
                      </p>
                      <div class="progress progress-xs light">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                      </div>
                    </li>

                    <li>
                      <p class="clearfix mb-1">
                        <span class="message float-start">Importing Contacts</span>
                        <span class="message float-end text-dark">98%</span>
                      </p>
                      <div class="progress progress-xs light">
                        <div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
                      </div>
                    </li>

                    <li>
                      <p class="clearfix mb-1">
                        <span class="message float-start">Uploading something big</span>
                        <span class="message float-end text-dark">33%</span>
                      </p>
                      <div class="progress progress-xs light mb-1">
                        <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </li>

*/