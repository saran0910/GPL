<?php



$host="localhost";
$user="root";
$password="";
$db="demo";


$con=mysqli_connect($host,$user,$password,$db) or die("Connection Failed");
mysqli_select_db($con,$db);

session_start();

$errors = [];


if(isset($_POST['submit'])){

    


    $uname=$_POST['email'];
    $password=$_POST['password'];



    $sql="select * from loginform where email='".$uname."'AND Pass='".$password."'
    limit 1";

    $result=mysqli_query($con,$sql);

    if(mysqli_num_rows($result)==1){

        $_SESSION['user']=$uname;

       // echo "you have Successfully Logged In";
       // header('Location:initial.php');
       echo $_SESSION['user'];
       
        exit();
    }
    else
    {
        $_SESSION['incorrect']="Wrong Password Entered";
    }

}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet"  href="style1.css">
</head>
<body>
  <!--  <div class="container">

        <h2>Let's Login</h2>

        <form action="login.php" method="post">

    
            <div class="tbox">
                <input type="email" name="email" placeholder=" Enter email" value="">
            </div>

            <div class="tbox">
                <input type="password" name="password"  placeholder=" Enter Password" value="">
            </div>


            <input class="btn" type="submit" name="submit" value="LOGIN">
        </form>

        <a class="b1" href="forgetpassword.php">FORGOT PASSWORD ? </a> -->


        <section>
        <div class="form-box">
            <div class="form-value">
                <form action="login.php" method="post">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" placeholder=" Enter email" value="">
                       
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password"  placeholder=" Enter Password" value="">
                    </div>
                    <div class="forget">
                        <a class="b1"  href="forgetpassword.php">FORGOT PASSWORD ? </a>
                      
                    </div>
                    <input class="btn" type="submit" name="submit" value="LOGIN">
                    
                </form>
                <?php
            if ($errors > 0) {
                foreach ($errors as $displayErrors) {
            ?>
                    <div id="alert"><?php echo $displayErrors; ?></div>
            <?php
                }
            }
        ?>



        <div id="incorrect">
            <?php
                    if(isset($_SESSION['incorrect']))
                    {
                        echo $_SESSION['incorrect'];
                        unset($_SESSION['incorrect']);
                    }
            ?>
        </div>


            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>




       

    
</body>
</html>