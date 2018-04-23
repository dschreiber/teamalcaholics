<?php

date_default_timezone_set('America/Los_Angeles');
session_start();

include ('db_init.php');

if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
    $email = $_REQUEST['email'];
    $password = md5($email . ':' . $_REQUEST['password']);
    
    // Retrieve current user
    $sql = $pdo->prepare("SELECT * FROM user WHERE email = ? and password = ?");
    $sql->execute([$email, $password]);
    $user = $sql->fetch();

    if (!$user) {
        header('location: login.php');
        exit();
    } else if (!$user['verified']) {
        echo 'Your account has not been verified by a team member or admin yet. Please try again later.';
        exit();
    } else {
        $_SESSION['user_id'] = $user['user_id'];
        header('location: index.php');
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
          <form id="login" name="login" method="POST" action="login.php">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Password">
          </div>
<!--
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
-->
          <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="$('#login').submit();return false;">Login</a>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
