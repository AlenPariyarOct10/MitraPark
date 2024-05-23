<?php
$connection = mysqli_connect("localhost:1822", "root", "root", "mitrapark");

// Checking for connection errors
if(mysqli_connect_errno()) {
    die("Unable to connect to database: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Kathmandu');
?>