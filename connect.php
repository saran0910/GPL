
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


?>