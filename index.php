<?php

include ('db_init.php');


// Are we at the homepage? If not, redirect

// Check if logged in. If not, force login

// Check if admin

// Setup basic params


// Route

$page['page'] = $_REQUEST['page'];
$page['section'] = $_REQUEST['section'];
if ((!$page['page']) or (!$page['section'])) {
    $page['page'] = 'welcome';
    $page['section'] = 'home';
}

$page['controller'] = 'ctrl/' . $page['section'] . '/' . $page['page'] . '.php';
$page['template'] = 'tmpl/' . $page['section'] . '/' . $page['page'] . '.tmpl';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?= $page['section'] . '-' . $page['page']; ?> / Team ALCaholics - We Keep Coming Back!</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

  <!-- Start Navigation-->
<?php
  include('tmpl/navbar.html');
?>
  <!-- End Left Navigation -->

  <!-- Start Main Content Area -->  
  <div class="content-wrapper">
    <div class="container-fluid">
        
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#"><?= ucwords(str_replace('_', ' ', $page['section'])) ?></a>
        </li>
        <li class="breadcrumb-item active"><?= ucwords(str_replace('_', ' ', $page['page'])) ?></li>
      </ol>
      
      <!-- Start Page Content -->
<?php
    if (file_exists($page['controller'])) {
        include($page['controller']);
    }
    include($page['template']);
?>
      

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Team ALCaholics 2018</small>
        </div>
      </div>
    </footer>
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Going so soon?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
