<!doctype html>
<div class="nano">
				        <div class="nano-content">
				            <nav id="menu" class="nav-main" role="navigation">
				                <ul class="nav nav-main">
				                    <li>
				                        <a class="nav-link" href="dashboard3.php?page=mechanic_dash">
				                            <i class="bx bx-home-alt" aria-hidden="true"></i>
				                            <span>Dashboard</span>
				                        </a>                        
				                    </li>
									<li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-spreadsheet" aria-hidden="true"></i>
				                            <span>Job Cards</span>
				                        </a>
				                        <ul class="nav nav-children">
											<li><a class="nav-link" href="dashboard3.php?page=add-job">Request a New Job Card</a></li>
											<li><a class="nav-link" href="dashboard3.php?page=open-job">Open Job Cards</a></li>
											<li><a class="nav-link" href="dashboard3.php?page=daily-pre-task-mini">Daily Pre-Task Mini Risk Assessment</a></li>
											<li><a class="nav-link" href="dashboard3.php?page=plant-inspection">Plant Inspection / Job Instruction Report</a></li>
											<li><a class="nav-link" href="dashboard3.php?page=plant-schedule">Plant Service Schedule</a></li>
				                        </ul>
				                    </li>
				                </ul>
				            </nav>
				            <hr class="separator" /> 
				        </div>
				        <script>
				            // Maintain Scroll Position
				            if (typeof localStorage !== 'undefined') {
				                if (localStorage.getItem('sidebar-left-position') !== null) {
				                    var initialPosition = localStorage.getItem('sidebar-left-position'),
				                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

				                    sidebarLeft.scrollTop = initialPosition;
				                }
				            }
				        </script>
				    </div>