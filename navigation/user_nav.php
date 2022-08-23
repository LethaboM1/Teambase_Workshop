<!doctype html>
<div class="nano">
				        <div class="nano-content">
				            <nav id="menu" class="nav-main" role="navigation">
				                <ul class="nav nav-main">
				                    <li>
				                        <a class="nav-link" href="dashboard2.php">
				                            <i class="bx bx-home-alt" aria-hidden="true"></i>
				                            <span>Dashboard</span>
				                        </a>                        
				                    </li>
									<li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bx-spreadsheet" aria-hidden="true"></i>
				                            <span>Daily Tasks</span>
				                        </a>
				                        <ul class="nav nav-children">
											<li><a class="nav-link" href="dashboard2.php?page=checklist">Checklist Report</a></li>
											<li><a class="nav-link" href="dashboard2.php?page=log-sheet">Driver / Operator Log</a></li>
				                           	<li><a class="nav-link" href="dashboard2.php?page=add-job">Request Job Cards</a></li>
				                        </ul>
				                    </li>
									<li class="nav-parent">
				                        <a class="nav-link" href="#">
				                            <i class="bx bxs-report" aria-hidden="true"></i>
				                            <span>Reports</span>
				                        </a>
				                        <ul class="nav nav-children">
											<li><a class="nav-link" href="">Fuel Report</a></li>
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