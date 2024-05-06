<?php

include_once('../../parts/entryCheck.php');
include_once('../../server/db_connection.php');
include_once('../../server/validation.php');
include_once('../../server/functions.php');

(session_status() !== PHP_SESSION_ACTIVE) ? session_start() : "";
$uid = $_SESSION['user']['uid'];

$rawData = file_get_contents("php://input");

$data = json_decode($rawData, true);

$fname = $_SESSION['user']['fname'];
$lname = $_SESSION['user']['lname'];
$bio = $_SESSION['user']['bio'];
$gender = $_SESSION['user']['gender'];
$permanent_address_id = $_SESSION['user']['p_address_id'];
$temporary_address_id = $_SESSION['user']['t_address_id'];
$academic_institution_id = $_SESSION['user']['academic_institution_id'];


if (!empty($data['fname'])) {
    $fname = $data['fname'];
    $updateFnameQuery = "UPDATE `users` SET `fname`='$fname' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateFnameQuery);
}


if (!empty($data['lname'])) {
    $lname = $data['lname'];
    $updateLnameQuery = "UPDATE `users` SET `lname`='$lname' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateLnameQuery);
}


if (isset($data['bio'])) {
    $bio = $data['bio'];
    $updateBioQuery = "UPDATE `users` SET `bio`='$bio' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateBioQuery);
}


if (isset($data['gender'])) {
    $gender = $data['gender'];
    $updateGenderQuery = "UPDATE `users` SET `gender`='$gender' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateGenderQuery);
}


if (!empty($data['p_address'])) {
    $permanent_address_id = $data['p_address'];
    $updatePAddressQuery = "UPDATE `users` SET `p_address_id`='$permanent_address_id' WHERE `uid`='$uid'";
    mysqli_query($connection, $updatePAddressQuery);
}


if (!empty($data['t_address'])) {
    $temporary_address_id = $data['t_address'];
    $updateTAddressQuery = "UPDATE `users` SET `t_address_id`='$temporary_address_id' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateTAddressQuery);
}


if (!empty($data['academic_institution'])) {

    $academic_institution_id = $data['academic_institution'];
    $updateAcademicInstitutionQuery = "UPDATE `users` SET `academic_institution_id`='$academic_institution_id' WHERE `uid`='$uid'";
    mysqli_query($connection, $updateAcademicInstitutionQuery);
}


$_SESSION['user']['fname'] = $fname;
$_SESSION['user']['lname'] = $lname;
$_SESSION['user']['bio'] = $bio;
$_SESSION['user']['gender'] = $gender;
$_SESSION['user']['p_address_id'] = $permanent_address_id;
$_SESSION['user']['t_address_id'] = $temporary_address_id;
$_SESSION['user']['academic_institution_id'] = $academic_institution_id;

echo json_encode(['success' => true]);
