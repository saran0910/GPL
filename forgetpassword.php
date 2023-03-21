<?php


$host="localhost";
$user="root";
$password="";
$db="demo";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$con=mysqli_connect($host,$user,$password,$db);
mysqli_select_db($con,$db);

session_start();

$errors = [];


if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];
   // $_SESSION['email'] = $email;

    $emailCheckQuery = "SELECT * FROM loginform WHERE email = '$email'";
    $emailCheckResult = mysqli_query($con, $emailCheckQuery);

    // if query run
    if ($emailCheckResult) {
        // if email matched
        if (mysqli_num_rows($emailCheckResult) > 0) {

            $code = rand(999999, 111111);
            $updateQuery = "UPDATE loginform SET code = $code WHERE email = '$email'";
            $updateResult = mysqli_query($con, $updateQuery);
            if ($updateResult) {

               $mail=new PHPMailer(true);
               
               $mail->isSMTP();
               $mail->Host='smtp.gmail.com';
               $mail->SMTPAuth=true;
               $mail->Username='sarantanuj31@gmail.com';
               $mail->Password='ecwgmongdtflsfia';
               $mail->SMTPSecure='ssl';
               $mail->Port=465;

               $mail->setFrom('sarantanuj31@gmail.com');

               $mail->addAddress($_POST["email"]);
               $mail->isHTML(true);

               
                $subject = 'Email Verification Code';
                $message = "our verification code is $code";
                
                $mail->Subject=$subject;
                $mail->Body=$message;
                
                $mail->send();

                
                header("location:verification.php");
                

            } else {
                $errors['db_errors'] = "Failed while inserting data into database!";
            }
        }else{
            $errors['invalidEmail'] = "Invalid Email Address";
        }
    }else {
        $errors['db_error'] = "Failed while checking email from database!";
    }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForgetPssword</title>
    <link rel="stylesheet"  href="forget.css">
</head>
<body>

<section>
        <div class="form-box">
            <div class="form-value">
                <form action="forgetpassword.php" method="post" autocomplete="off">
                     
                <?php
            if ($errors > 0) {
                foreach ($errors as $displayErrors) {
            ?>
                    <div id="alert"><?php echo $displayErrors; ?></div>
            <?php
                }
            }
        ?>



                    <h2>Verify Your Email</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" placeholder=" Enter email" value="">
                       
                    </div>
                   
                    <input class="btn" type="submit" name="forgot_password" value="submit">
                    
                </form>

        


      


            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>





</body>
</html>