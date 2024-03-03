<?php
    include_once("db_connection.php");

    function validate_name($name)
    {
        $name=htmlspecialchars($name);
        if(empty($name))
        {
            return false;
        }else if(!preg_match('/^[a-zA-Z]{3,10}$/',$name))
        {
            return false;
        }else{
            return true;
        }
    }

    function validate_password($password)
    {
        $password = htmlspecialchars($password);
        $passwordLength = strlen($password) >= 12 && strlen($password) <= 18;
        $hasSpecialChar = preg_match('/[`!@#$%^&*()_+\-=\[\]{};\'":\\|,.<>\/?~]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasUpperCase = preg_match('/[A-Z]/', $password);
        $hasLowerCase = preg_match('/[a-z]/', $password);

        if($passwordLength && $hasSpecialChar && $hasNumber && $hasUpperCase &&$hasLowerCase)
        {
            return true;
        }else{
            return false;
        }
    }

    function validate_cpassword($password, $cpassword)
    {
        if(htmlspecialchars($password) === htmlspecialchars($cpassword))
        {
            return true;
        }else{
            return false;
        }
    }

    function validate_email($email)
    {
        $email = htmlspecialchars($email);
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            return true;
        }else{
            return false;
        }
    }

    function validate_phone($phone)
    {
        $phone = htmlspecialchars($phone);
        if(preg_match('/^\d{10}$/',$phone))
        {
            return true;
        }else{
            return false;
        }

    }

    function isExistingUser($email, $phone)
    {
        $phone = htmlspecialchars($phone);
        $email = htmlspecialchars($email);
        $hasPhone = false;
        $hasEmail = false;

        $checkPhone = "select * from users where `phone`='$phone'";
        $checkPhone = $GLOBALS['connection']->query($checkPhone);
        if(mysqli_affected_rows($GLOBALS['connection'])>0)
        {
            $hasPhone = true;
        }

        $checkEmail = "select * from users where `email`='$email'";
        $checkEmail = $GLOBALS['connection']->query($checkEmail);
        if(mysqli_affected_rows($GLOBALS['connection'])>0)
        {
            $hasEmail = true;
        }

        if($hasPhone || $hasEmail)
        {
            return true;
        }else{
            return false;
        }
    }

    function validate_signup($fname, $lname,$email,$phone, $password, $cpassword)
    {
        if(isExistingUser($email, $phone))
        {
            if(!isset($_SESSION)){session_start();}
            
            $_SESSION['existingUser'] = '<div class="signup-error">User already exists.</div>';
        }
        if(validate_name($fname) && validate_name($lname) && validate_phone($phone) && validate_password($password) && validate_cpassword($password,$cpassword) && validate_email($email) && !isExistingUser($email, $phone))
        {
            return true;
        }else{
            return false;
        }
    }


?>