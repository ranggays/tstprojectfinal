<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek otorisasi admin (untuk admin_panel.php)
if ($_SESSION['usertype'] != 'admin') {
    header("Location: ../dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
  <head>
    <?php
      include('admin.css.php')
    ?>
    
  </head>
  <body>
      <?php
        include('admin.header.php')
      ?>

      <?php
        include('admin.sidebar.php')
      ?>
    
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <?php
              include('admin.body.php')
            ?>
          </div>
        </div>
      </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>
