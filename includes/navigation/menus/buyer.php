<?php
$query = "select * from jobcard_requisitions where buyer_id={$_SESSION['user']['user_id']} and (status!='denied' and status!='canceled' and status!='completed')";

$get_job_requests = dbq($query);

$count_new_requests = dbr($get_job_requests);

$total_notifications = $count_new_requests;
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