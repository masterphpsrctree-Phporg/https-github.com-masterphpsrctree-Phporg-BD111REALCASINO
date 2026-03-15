<?php
$otp = $otp ?? '123456'; // dynamic OTP from PHP
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Casino OTP Verification</title>
<style>
  html, body { margin:0; padding:0; font-family: Arial, sans-serif; background:#111; color:#fff; }
  .otp-button { display:inline-block; padding:15px 30px; background:#FFD700; color:#111; font-size:24px; font-weight:bold; border-radius:8px; margin:20px 0; text-decoration:none; }
</style>
</head>
<body>
<center>
<h1 style="color:#FFD700;">🎰 BD111 Casino</h1>
<h2>Verify Your Phone Number</h2>
<p>Use the OTP below to verify your phone number:</p>
<a href="#" class="otp-button"><?= htmlspecialchars($otp) ?></a>
<p style="color:#AAA;">If you did not request this OTP, ignore this email.</p>
</center>
</body>
</html>
