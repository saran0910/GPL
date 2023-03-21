<?php 
    //connecting to the database
    $host="localhost";
    $user="root";
    $password="";
    $db="gpl";
    $con=mysqli_connect($host,$user,$password,$db);
    mysqli_select_db($con,$db);
    session_start();

    if(mysqli_connect_errno())
    {
        echo " Failed to connect to SQL :".mysqli_connect_error();
    }


    $sql = "SELECT * FROM odds WHERE match_id='m01'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $team1_odds = $row['team1_odds'];
    $team2_odds = $row['team2_odds'];

    



    $_SESSION['placed'] = 'Team 1- ratio is ' . $team1_odds . ' team 2- ratio is ' . $team2_odds;
    

   // echo $_SESSION['placed'];
    //check if it is submitted

    if(isset($_SESSION['submit']) && $_SESSION['submit']==true)
    {
        echo "You have already placed your bet.";
    }

    else
    {
        if($_SERVER['REQUEST_METHOD']=='POST' )
        {
    
            $user_id=$_POST['user_id'];
            $team=$_POST['team'];
            $amount=$_POST['amount'];
    
    
            $sql2="SELECT* FROM user_info where user_id='$user_id'";
            $result2=mysqli_query($con,$sql2);
            $row2=mysqli_fetch_assoc($result2);;
            $total_coins=$row2['coins'];
           
           
    
            $total_coins=$total_coins-$amount;
    
            if($total_coins>=0)
            {
                $updateQuery = "UPDATE user_info SET coins = $total_coins WHERE user_id = '$user_id'";
                $updateResult = mysqli_query($con, $updateQuery);
    
                $sql = "INSERT INTO bets (user_id, team, amount) VALUES ('$user_id', '$team', '$amount')";
    
                if (mysqli_query($con, $sql)) {
                   
                    $_SESSION['message']='Sucessfully placed your bit';
                    //header("location:bet.php");
    
                    $sql3="SELECT* FROM cricket where match_id='m01'";
                    $result3 = mysqli_query($con, $sql3);
                    $row3 = mysqli_fetch_assoc($result3);
                    $winner=$row3['winner'];
                    if($winner=="team1")
                    {
                       if($team=="team1")
                       {
                            $profit=$amount*$team1_odds-$amount;
                            $_SESSION['winner']='You won! Your Profit is-  '.$profit;
                            $total_coins=$total_coins+$profit+$amount;
                            $_SESSION['coins']='You Have '.$total_coins.'coins';
                            $updateQuery1="UPDATE user_info SET coins=$total_coins  WHERE user_id='$user_id'";
                            $updateResult=mysqli_query($con,$updateQuery1);
                       }
                       else
                       {
                            $_SESSION['coins']='You Have '.$total_coins.'coins';
                            $_SESSION['loss']='You Lost!';
    
                       }
    
                    }
                    else{
                        if($team=="team2")
                        {
                            $profit=$amount*$team2_odds-$amount;
                            $_SESSION['winner']='You won! Your Profit is-  '.$profit;
                            $total_coins=$total_coins+$profit+$amount;
                            $_SESSION['coins']='You Have '.$total_coins.'coins';
                            $updateQuery="UPDATE user_info SET coins=$total_coins  WHERE user_id='$user_id'";
                            $updateResult=mysqli_query($con,$updateQuery);
                        }
                        else{
    
                            $_SESSION['loss']='You Lost!';
                            $_SESSION['coins']='You Have '.$total_coins.'coins';
                        }
                    }
    
                    
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            }
            else{
                
                echo "You dont have enough balance to bit";
            }
    
    
    
            $_SESSION['submit']=true;
    
            
     
    
        }


    }

   


  

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Betting</title>
    <link rel="stylesheet"  href="">
</head>
<body>
    
    <?php
        if(isset($_SESSION['placed']))
        {
            echo $_SESSION['placed'];
            unset($_SESSION['placed']);
        }
    ?>

    <br>

    <?php
        if(isset($_SESSION['coins']))
        {
            echo $_SESSION['coins'];
            unset($_SESSION['coins']);
        }
    ?>

 





    <form method='POST' action="initial.php">
         <label>Enter the username:</label>
        <input type="text" name='user_id'><br>
        <label>Enter the team you want to bet on:</label><br>
        <input type='radio' name='team' value='team1'> Team 1<br>
        <input type='radio' name='team' value='team2'> Team 2<br>
        <label>Enter the amount to bet:</label><br>
        <input type='number' name='amount'><br>
        <input type='submit' value='Place Bet'>


    </form>

    <?php
       if(isset($_SESSION['message']))
       {
           echo $_SESSION['message'];
           unset($_SESSION['message']);
       }
    ?>




        <br>

        <?php
            if(isset($_SESSION['loss']))
            {
                echo $_SESSION['loss'];
                unset($_SESSION['loss']);
            }
        ?>

        <br>

        <?php
            if(isset($_SESSION['winner']))
            {
                echo $_SESSION['winner'];
                unset($_SESSION['winner']);
            }
        ?>


</body>
</html>