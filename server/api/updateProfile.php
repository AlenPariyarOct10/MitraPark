<?php

    include_once('../../parts/entryCheck.php');
    include_once('../../server/db_connection.php');
    include_once('../../server/validation.php');
    include_once('../../server/functions.php');

    (session_status() !== PHP_SESSION_ACTIVE) ? session_start() : "";
    $uid = $_SESSION['user']['uid'];
    $rawData = file_get_contents("php://input");

    $data = json_decode($rawData, true);
        $fname = $data['fname'];
        $lname = $data['lname'];
        $bio = $data['bio'];
        $gender = $data['gender'];
        $permanent_address = $data['p_address'];
        $temporary_address = $data['t_address'];
        $academic_institution = $data['academic_institution'];

        $updateProfileQuery = "UPDATE `users` SET `bio`='$bio',`fname`='$fname',`gender`='$gender',`lname`='$lname',`p_address_id`='$permanent_address',`academic_institution_id`='$academic_institution',`t_address_id`='$temporary_address' WHERE `uid`='$uid'";
        $result = mysqli_query($connection, $updateProfileQuery);

        if ($result) {
            refreshUserData();
            var_dump($_SESSION['user']);
            echo json_encode(['success' => true]); // Return JSON response for success
        } else {
            echo json_encode(['success' => false]); // Return JSON response for failure
        }
