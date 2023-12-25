<?php
    $connection = new mysqli("localhost","root","","mitrapark");

    if($connection->connect_error)
    {
        die("Unable to connect to database");
    }


?>