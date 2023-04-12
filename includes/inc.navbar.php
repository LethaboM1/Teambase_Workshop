<div class="inner-wrapper">
  <!-- start: sidebar -->
  <aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
      <div class="sidebar-title">
        Navigation
      </div>
      <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
        <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
      </div>
    </div>
    <!-- Navigation Start -->
    <?php
    switch ($dashboard) {
      case "admin":
        if ($_SESSION['user']['role'] == 'clerk') {
          include('includes/navigation/clerk_nav.php');
        } else {
          include('includes/navigation/manager_nav.php');
        }
        break;

      case "buyer":
        include('includes/navigation/buyer_nav.php');
        break;

      case "user":
        include('includes/navigation/user_nav.php');
        break;

      case "mechanic":
        include('includes/navigation/mech_nav.php');
        break;

      case 'ws_inspector':
        include('includes/navigation/ws_inspector_nav.php');
        break;
    }

    ?>

    <!-- Navigation end -->
  </aside>
  <!-- end: sidebar -->