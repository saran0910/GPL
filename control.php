<?php  

    include_once("connect.php");
    

    session_start();

    $errors=[];

    //for login


    if(isset($_POST['username'])){


        $uname=$_POST['username'];
        $password=$_POST['password'];
    
        $sql="select * from loginform where user='".$uname."'AND Pass='".$password."'
        limit 1";
    
        $result=mysqli_query($con,$sql);
    
        if(mysqli_num_rows($result)==1){
    
            echo "you have Successfully Logged In";
            header('Location:project.html');
           
            exit();
        }
        else
        {
            $_SESSION['incorrect']="Wrong Password Entered";
        }
    
    }

    //for forget
    if (isset($_POST['forgot_password'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;
    
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
    
                    $_SESSION['succ']="Successfully changed";
                    
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

    //for verification

    if(isset($_POST['verification'])){
        $_SESSION['message'] = "";
        $OTPverify = mysqli_real_escape_string($con, $_POST['OTPverify']);
        $verifyQuery = "SELECT * FROM loginform WHERE code = $OTPverify";
        $runVerifyQuery = mysqli_query($con, $verifyQuery);
        if($runVerifyQuery){
            if(mysqli_num_rows($runVerifyQuery) > 0){
                $newQuery = "UPDATE loginform SET code = 0";
                $run = mysqli_query($con,$newQuery);
                header("location: newPassword.php");
            }else{
                $errors['verification_error'] = "Invalid Verification Code";
            }
        }else{
            $errors['db_error'] = "Failed while checking Verification Code from database!";
        }
    }
    
    








?>