<?php
session_start();
$user_otp = $_POST['otp'] ?? '';

if (!isset($_SESSION['otp'])) {
    echo "No OTP sent.";
    exit;
}

if (time() > $_SESSION['otp_expire']) {
    echo "OTP expired!";
    exit;
}

if ($user_otp == $_SESSION['otp']) {
    echo "Phone verified successfully!";
} else {
    echo "Invalid OTP.";
}
