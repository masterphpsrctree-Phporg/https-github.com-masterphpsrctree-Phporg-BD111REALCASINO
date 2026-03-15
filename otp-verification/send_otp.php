<?php
session_start();
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

$phone = $_POST['phone'];
$email = $_POST['email'];

// Generate OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expire'] = time() + 300; // 5 min expiry

// Send Email via PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';
    $mail->Password = 'your_email_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'BD111 Casino');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for BD111 Casino';
    $mail->Body = file_get_contents("templates/otp_email.php");

    $mail->send();
    echo "OTP sent via Email.";
} catch (Exception $e) {
    echo "Mail Error: {$mail->ErrorInfo}";
}

// Send SMS via Twilio
require_once 'vendor/twilio/sdk/Twilio/autoload.php';
use Twilio\Rest\Client;

$sid = 'YOUR_TWILIO_SID';
$token = 'YOUR_TWILIO_AUTH_TOKEN';
$twilio = new Client($sid, $token);

$twilio->messages->create($phone, [
    'from' => 'YOUR_TWILIO_NUMBER',
    'body' => "Your BD111 Casino OTP is: $otp"
]);

echo "OTP sent via SMS.";
