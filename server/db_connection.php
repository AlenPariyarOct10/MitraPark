<?php
    // Establishing a connection to the database
    $connection = mysqli_connect("localhost", "root", "", "mitrapark");

    // Checking for connection errors
    if(mysqli_connect_errno()) {
        die("Unable to connect to database: " . mysqli_connect_error());
    }


?>
