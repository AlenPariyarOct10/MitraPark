<?php

    include_once ("../server/db_connection.php");
    $aboutSite = mysqli_query($connection, "SELECT * FROM `system_data`");
    $aboutSite = mysqli_fetch_assoc($aboutSite);

    $system_name = $aboutSite['system_name'];

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['email'])) {
        
        function getOTP($length = 6)
        {
            $otp = '';
            for ($i = 0; $i < $length; $i++) {
                $otp .= random_int(0, 9);
            }
            return $otp;
        }

        $email = htmlspecialchars($_POST['email']);
        $email = trim($email);

        $getUid = "SELECT `uid` FROM users WHERE `email`='$email'";
        $getUid = mysqli_query($connection, $getUid);
        if(mysqli_affected_rows($connection)==0)
        {
            header("Location: invalid-email.php");
            exit();
        }
        $getUid = mysqli_fetch_assoc($getUid);
        $uid = $getUid['uid'];
        $otp = getOTP();

        $otphash = password_hash($otp, PASSWORD_DEFAULT);

        // *MitraPark : Insert OTP
        $checkExisting = "SELECT * FROM `OTP` WHERE `uid`='$uid'";
        $result = mysqli_query($connection, $checkExisting);

        if (mysqli_affected_rows($connection) > 0) {
            $current = date('Y-m-d H:i:s');
            $updateOTPQuery = "UPDATE `OTP` SET `created_timestamp`='$current', `code`='$otphash' WHERE `uid`='$uid'";
            $updateResult = mysqli_query($connection, $updateOTPQuery);

        } else {
            $insertOTPQuery = "INSERT INTO `OTP` (`uid`, `code`) VALUES ('$uid', '$otphash')";
            $insertResult = mysqli_query($connection, $insertOTPQuery);
        }

        $receiver = $email;
        $subject = "Forgot password ~ OTP";
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
                <h1>' . $system_name . '</h2>
            </div>
            <div style="padding:20px 0px; text-align: center;">
                <div style="height: 500px;">
                    <div style="text-align:center;">
                        <h3>Verify Your Account</h3>
                        <p style="text-align:justify;">Dear User,<br>
                            We have received a request to reset the password for your account on ' . $system_name . '. To proceed with resetting your password, please use the following One-Time Password (OTP) to verify your identity.</p>
                        <div style="padding: 15px; background-color: cadetblue;">
                            <h1>' . $otp . '</h1>
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
        mail($receiver, $subject, $body, $headers);
        
        $uid_encrypted = base64_encode($uid);
        header("Location: verifyOTP.php?user=".$uid_encrypted);

    } else {
        header("Location: ../");
    }
?>