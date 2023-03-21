
<?php

$host="localhost";
$user="root";
$password="";
$db="demo";


$con=mysqli_connect($host,$user,$password,$db);
mysqli_select_db($con,$db);

session_start();


$errors = [];






if(isset($_POST['verification'])){

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="stylesheet"  href="verification.css">
</head>
<body>
    <div id="container">
        <h2>Verify<br><br>It's Easy</h2>
        <form action="verification.php" method="POST" autocomplete="off">
            

            <?php
            if($errors > 0){
                foreach($errors AS $displayErrors){
                ?>
                <div id="alert"><?php echo $displayErrors; ?></div>
                <?php
                }
            }
            ?>  
            
            <div class="tbox">
        <input type="number" name="OTPverify" placeholder="Verification Code" value="">
            </div>

    


        <input class="btn" type="submit" name="verification" value="Verify" placeholder="Enter">

            
        </form>

</body>
</html>