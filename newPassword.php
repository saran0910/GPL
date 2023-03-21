<?php

session_start();

$host="localhost";
$user="root";
$password="";
$db="demo";


$con=mysqli_connect($host,$user,$password,$db);
mysqli_select_db($con,$db);



$errors = [];

if(isset($_POST['changePassword'])){
    $password = $_POST['password'];
    $confirmPassword =$_POST['confirmPassword'];
    
    if (strlen($_POST['password']) < 8) {
        $errors['password_error'] = 'Use 8 or more characters with a mix of letters, numbers & symbols';
    } else {
        // if password not matched so
        if ($_POST['password'] != $_POST['confirmPassword']) {
            $errors['password_error'] = 'Password not matched';
        } else {
            $email = $_SESSION['user'];
            $updatePassword = "UPDATE loginform SET Pass = '$password' WHERE email = '$email'";
            $updatePass = mysqli_query($con, $updatePassword) or die("Query Failed");
            $_SESSION['status']="Successfully changed ,Please go to Login";
           session_destroy();
           session_unset();
            //header('location: login.php');
        }
    }
}





?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>changePassword</title>
    <link rel="stylesheet"  href="changePassword.css">
</head>
<body>
<div id="container">
        <h2>Change Your Password<br><br>Almost Done!</h2>
        <form action="newPassword.php" method="POST" autocomplete="off">
           

     <!-- <div class="tbox">
                <input type="email" name="email" placeholder="Email" value="">
        </div> -->

        <div class="tbox">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="tbox">
                <input type="password" name="confirmPassword"  placeholder="Confirm Password" required>
            </div>


            <input class="btn" type="submit" name="changePassword" value="Save">


            <?php
            if ($errors > 0) {
                foreach ($errors as $displayErrors) {
            ?>
                    <div id="alert"><?php echo $displayErrors; ?></div>
            <?php
                }
            }
            ?>
            <div id="change">
            <?php
                    if(isset($_SESSION['status']))
                    {
                        echo $_SESSION['status'];
                        unset($_SESSION['status']);
                    }
            ?>
            </div>
        </form>
    </div>

</body>
</html>