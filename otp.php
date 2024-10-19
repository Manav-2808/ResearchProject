<?php
 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions

try {
    //settings
    $mail->SMTPDebug=2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='ankushtechnical111@gmail.com'; // SMTP username
    $mail->Password='******'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('ankushtechincal111@gmail.com', 'optional sender name');

    //recipient
    $mail->addAddress('ankushpanchal144@gmail.com', 'optional recipient name');     // Add a recipient
    //content
    $otp = mt_rand(10000000,99999999);
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='Humsecure.com sent you an OTP';
    $mail->Body='OTP TO DOWNLOAD IMAGES <b>'.$otp.'</b>';
    $mail->AltBody='OTP TO DOWNLOAD IMAGES IS :: '.$otp;

    if($mail->send(1)){
        echo $otp;
    }else{
        echo "no";
    }

    
    } 
    catch(Exception $e) {
        //  echo 'Mailer Error: '.$mail->ErrorInfo;
    }
?>
