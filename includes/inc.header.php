<!doctype html>
<html class="fixed dark">

<head>

  <!-- Basic -->
  <meta charset="UTF-8">

  <title>TeamBase | Hillary Construction | Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="img/logos/teambase_fav.png" />

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Web Fonts  -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="vendor/animate/animate.compat.css">
  <link rel="stylesheet" href="vendor/font-awesome-6/css/all.min.css" />
  <link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
  <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
  <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css" />
  <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css" />
  <link rel="stylesheet" href="vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
  <link rel="stylesheet" href="vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
  <link rel="stylesheet" href="vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
  <link rel="stylesheet" href="vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
  <link rel="stylesheet" href="vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <link rel="stylesheet" href="vendor/dropzone/basic.css" />
  <link rel="stylesheet" href="vendor/dropzone/dropzone.css" />
  <link rel="stylesheet" href="vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
  <link rel="stylesheet" href="vendor/summernote/summernote-bs4.css" />
  <link rel="stylesheet" href="vendor/codemirror/lib/codemirror.css" />
  <link rel="stylesheet" href="vendor/codemirror/theme/monokai.css" />

  <!-- Specific Page Vendor CSS -->
  <link rel="stylesheet" href="vendor/select2/css/select2.css" />
  <link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
  <link rel="stylesheet" href="vendor/pnotify/pnotify.custom.css" />

  <!-- Theme CSS -->
  <link rel="stylesheet" href="css/theme.css" />

  <!-- Skin CSS -->
  <link rel="stylesheet" href="css/skins/default.css" />

  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="css/custom.css">

  <!-- Head Libs -->
  <script src="vendor/modernizr/modernizr.js"></script>

</head>

<body>
  <?php
  if (isset($_SESSION['user'])) {
  ?>
    <section class="body">
      <!-- start: header -->
      <header class="header">
        <div class="logo-container">
          <a href="#" class="logo">
            <img src="img/logos/teambase_logo_long.png" width="202" height="45" alt="TeamBase Logo" />
          </a>
          <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
          </div>
        </div>

        <!-- start: user box -->
        <div class="header-right">

          <span class="separator"></span>
          <ul class="notifications">
            <?php
            switch ($_SESSION['user']['role']) {
              case "manager":
                require "./includes/navigation/menus/manager.php";
                break;

              case "buyer":
                require "./includes/navigation/menus/buyer.php";
                break;

              case "clerk":
                require "./includes/navigation/menus/manager.php";
                break;

              case "system":
                require "./includes/navigation/menus/manager.php";
                break;
            }
            ?>
          </ul>
          <span class="separator"></span>
          <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">
              <figure class="profile-picture">

                <?php
                if (file_exists("images/users/{$_SESSION['user']['user_id']}.jpg")) {
                  echo "<img src='images/users/{$_SESSION['user']['user_id']}.jpg' alt='{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}' class='rounded-circle' data-lock-picture='images/users/{$_SESSION['user']['user_id']}.jpg' />";
                }
                ?>
              </figure>
              <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                <span class="name"><?= $_SESSION['user']['name'] . " " . $_SESSION['user']['last_name'] ?></span>
                <span class="role"><?= strtoupper($_SESSION['user']['role']) ?></span>
              </div>

              <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
              <ul class="list-unstyled mb-2">
                <li class="divider"></li>
                <li>
                  <a role="menuitem" tabindex="-1" href="dashboard.php?page=profile"><i class="bx bx-user-circle"></i> My Profile</a>
                </li>
                <li>
                  <?php
                  if ($_SESSION['user']['outofoffice'] == 1) {
                  ?><a role="menuitem" tabindex="-1" href="dashboard.php?outofoffice=false"><i class="bx bx-lock"></i>Back at Office</a><?php
                                                                                                                                      } else {
                                                                                                                                        ?>
                    <a role="menuitem" tabindex="-1" href="dashboard.php?outofoffice=true"><i class="bx bx-lock"></i>Out of Office</a>
                  <?php

                                                                                                                                      }
                  ?>

                </li>
                <li>
                  <a role="menuitem" tabindex="-1" href="logout.php"><i class="bx bx-power-off"></i> Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- end: search & user box -->
      </header>
      <!-- end: header -->
    <?php
    require_once "includes/inc.navbar.php";
  }
