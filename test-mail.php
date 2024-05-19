<?php
function getOTP($length = 6) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= random_int(0, 9);
    }
    return $otp;
}

$otp = getOTP();

$receiver = "oct10.alenpariyar@gmail.com";
$subject = "Email Test via PHP using Localhost";
$body = '
<!DOCTYPE html>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<style>
    *{
        color: white;
    }
</style>
    </head>
    <body style="background-color: #363636;color:white;font-family:poppins; padding:20px">
        <div style="text-align: center;border-radius: 5px;">
            <h1>MitraPark</h2>
        </div>
        <div style="padding:20px 0px; text-align: center;">
            <div style="height: 500px;">
                <div style="text-align:center;">
                    <h3>Verify Your Account</h3>
                    <p style="text-align:justify;">Dear User,<br>
                        We have received a request to reset the password for your account on MitraPark. To proceed with resetting your password, please use the following One-Time Password (OTP) to verify your identity.</p>
                    <div style="padding: 15px; background-color: cadetblue;">
                        <h1>'.$otp.'</h1>
                    </div>
                </div>
                <p>This OTP is valid for the next 5 minutes.</p>
                <p>Do not share this code with anyone. Our support team will never ask for your OTP.</p>
            </div>
        </div>
    </body>
</html>
';


$headers = "Content-Type: text/html; charset=UTF-8\r\n";

if(mail($receiver, $subject, $body, $headers)){
    echo "Email sent successfully to $receiver";
}else{
    echo "Sorry, failed while sending mail!";
}
?>