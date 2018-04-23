<?php

date_default_timezone_set('America/Los_Angeles');
session_start();

include ('db_init.php');

exit();

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



            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $result = $pdo->prepare("INSERT INTO user (create_date, last_login, email, password, first_name, last_name, nickname) VALUES (now(),now(),:email,:password,:first_name,:last_name,:nickname)")->execute($register);
                
                if ($result) {
                    $error = 'You have successfully registered. Please wait for an email from an admin who will manually verify your account.';
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

