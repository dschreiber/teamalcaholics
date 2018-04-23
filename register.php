<?php

date_default_timezone_set('America/Los_Angeles');
session_start();

include ('db_init.php');

if (isset($_REQUEST['register'])) {
    $register = $_REQUEST['register'];
    if ($register['password_1'] == $register['password_2'] 
            and (strlen($register['password_1']) >= 8)
            and (filter_var($register['email'], FILTER_VALIDATE_EMAIL))
            and (strlen($register['first_name']) >= 2)
            and (strlen($register['last_name']) >= 2)
        ) {
            // Valid registration, let's try it
            $register['password'] = md5($register['email'] . ':' . $register['password_1']);
            unset($register['password_1']);
            unset($register['password_2']);
            
            $register['email'] = strtolower($register['email']);
            $register['nickname'] = $register['first_name'];
            
            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $result = $pdo->prepare("INSERT INTO user (create_date, last_login, email, password, first_name, last_name, nickname, verified) VALUES (now(),now(),:email,:password,:first_name,:last_name,:nickname,1)")->execute($register);
                
                if ($result) {
                    $error = 'You have successfully registered. Please wait for an email from an admin who will manually verify your account.';
                    header('location: login.php');
                    exit();
                } else {
                    $error = "Nope.";
                }
                
            } catch (PDOException $e) {
                $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
                if (strpos($e->getMessage(), $existingkey) !== FALSE) {

                    // Take some action if there is a key constraint violation, i.e. duplicate name
                } else {
                    throw $e;
                }
                
                $error = "Duplicate account. Perhaps you forgot your password?";
            }
        } else {
            $error = 'There are errors on the form. Please try again.';
        }

}

?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Team ALCaholics - Register</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">

<?php
if (isset($error)) {
    echo <<<TMPL
      <h4 class="text-center mb-3 mt-3">
          $error
      </h4>
TMPL;
}
?>
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form name="register" id="register" type="POST" action="register.php">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">First name</label>
                <input name="register[first_name]" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name">
              </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">Last name</label>
                <input name="register[last_name]" class="form-control" id="exampleInputLastName" type="text" aria-describedby="nameHelp" placeholder="Enter last name">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="register[email]" class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputPassword1">Password (8+ chars)</label>
                <input name="register[password_1]" class="form-control" id="exampleInputPassword1" type="password" placeholder="Password">
              </div>
              <div class="col-md-6">
                <label for="exampleConfirmPassword">Confirm password</label>
                <input name="register[password_2]" class="form-control" id="exampleConfirmPassword" type="password" placeholder="Confirm password">
              </div>
            </div>
          </div>
          <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="$('#register').submit();return false;">Register</a>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
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
