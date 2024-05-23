<?php
include_once("../server/db_connection.php");
include_once("../server/validation.php");
include_once("../server/functions.php");

$aboutSite = $connection->query("SELECT * FROM `system_data`");
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);

if(isset($_POST['check']))
{
    if(isExistingUser($_POST['email']))
    {
        header("Location: verify-email.php?userExists");
    }
}

if (isset($_POST['submit'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
 
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    $otp = htmlspecialchars($_POST['signup_otp']);
    
    if(isExistingUser($email))
    {
        header("../verify-email.php?userExists");
        exit();
    }

    $check = false;
    $check = validate_signup($fname, $lname, $email, $password, $cpassword);

    // Validate OTP

    $checkOTP = "SELECT `created_timestamp`, `code` FROM OTP where `email`='$email'";
    $checkOTP = mysqli_query($connection, $checkOTP);

    if(mysqli_affected_rows($connection)>0)
    {
        $otpRow = mysqli_fetch_assoc($checkOTP);
        $created_time = strtotime($otpRow['created_timestamp']);
        $code = $otpRow['code'];
        $current_time = time();

        $valid_time = 5*60;

        if(password_verify($otp, $code))
        {
            echo "--------->valid<-----------";
        if(($current_time - $created_time < $valid_time))
        {
            if($check && !isExistingUser($email))
            {
                createUser($fname, $lname, $email, $password);
                header("Location: ../login.php?1");

                $deleteOTP = "DELETE FROM OTP where `email`='$email'";
                mysqli_query($connection, $deleteOTP);
            }else{
                header("Location: ../login.php?0");
                $deleteOTP = "DELETE FROM OTP where `email`='$email'";
                mysqli_query($connection, $deleteOTP);
            }
        }else{

            header("Location: ../login.php?0");
            $deleteOTP = "DELETE FROM OTP where `email`='$email'";
            mysqli_query($connection, $deleteOTP);
        }
    }else{
        echo "--------->invalid<-----------";

    }
    }else{
        echo "<script>alert('Invalid OTP');</script>";
        header("../login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email -
        <?php echo $aboutSite['system_name']; ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">

</head>

<body>
    <div class="left">
        <img id="logo" src=" <?php echo "..".$aboutSite['system_logo']; ?>" alt="logo">
       

        <h1>
            <?php echo $aboutSite['system_name']; ?>
        </h1>
        <span id="description">
            <?php echo $aboutSite['system_description']; ?>
        </span>
    </div>
    <div class="right">
        <span class="page-title">Verify your email</span>
        <?php
            if(isset($_GET['userExists'])){echo '<div class="signup-error">User already exists.</div>';echo '<a href="../login.php">Login</a>';exit();}else
            if(isset($check)){if(!$check){echo '<div class="signup-error">Unable to signup. Please check your input and try again later.</div>';}}
        ?>

        <p style="font-size: small; padding: 20px; color:#31363F;">We've sent an OTP in your email address. Please verify your email to signup.</p>
        
        <form action="verify-email.php" autocomplete="false" method="post">
            <span id="otpError"></span>
           <?php
                if(isset($_POST['fname']))
                {
                    echo ' <input class="inp-fields" type="hidden" name="fname" value="'.$_POST['fname'].'" />';
                }
                if(isset($_POST['lname']))
                {
                    echo ' <input class="inp-fields" type="hidden" name="lname" value="'.$_POST['lname'].'" />';
                }
                if(isset($_POST['email']))
                {
                    echo ' <input class="inp-fields" type="hidden" name="email" id="email" value="'.$_POST['email'].'" />';
                }
                if(isset($_POST['password']))
                {
                    echo ' <input class="inp-fields" type="hidden" name="password" value="'.$_POST['password'].'" />';
                }
                if(isset($_POST['cpassword']))
                {
                    echo ' <input class="inp-fields" type="hidden" name="cpassword" value="'.$_POST['cpassword'].'" />';
                }
           ?>
            <input class="inp-fields" type="number" placeholder="OTP" name="signup_otp" id="signup_otp">
            
            
            <button type="submit" name="submit" id="submit" class="btn login-btn">Signup</button>
        </form>
        <div id="underline"></div>
        <a href="../login.php" class="btn">Login</a>
    </div>
</body>
<script src="../assets/scripts/jquery.js"></script>
<script>
    let allowOTP = false;
    let submitBtn =document.getElementById("submit");
    let otpField =document.getElementById("signup_otp");
    
    $.ajax({
        url: "signup-otp-mail.php",
        type: "POST",
        data: {
            email: document.getElementById("email").value,
        },
        success: (status)=>{
            console.log("ok");
        console.log(status);
        },
        error: (res)=>{
            console.log("nok");

            console.log(res);
        }
    })

    controlSubmit();

    submitBtn.disabled = true;
    submitBtn.style.cursor = "not-allowed";
    submitBtn.style.backgroundColor = "#6c757d";

    let otpRule = /^[0-9]{6}$/;

   
   

    otpField.addEventListener("input", () => {
        if (otpRule.test(otpField.value)) {
            allowOTP = true;
            document.getElementById("otpError").innerHTML = "";
        } else {
            document.getElementById("otpError").innerHTML = "Invalid OTP";
            allowOTP = false;
        }
        controlSubmit();
    });

    function controlSubmit() {
        if (allowOTP ) {
            submitBtn.disabled = false;
            submitBtn.style.cursor = "pointer";
            submitBtn.style.backgroundColor = "#28a745";
        } else {
            submitBtn.disabled = true;
            submitBtn.style.cursor = "not-allowed";
            submitBtn.style.backgroundColor = "#6c757d";
        }
    }
</script>

</html>