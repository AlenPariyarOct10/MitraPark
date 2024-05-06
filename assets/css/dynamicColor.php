<?php

    // include_once("server/db_connection.php");

    $getColor = mysqli_query($connection, "SELECT `themeSpecification` FROM `system_data` WHERE 1");
    $getColor = mysqli_fetch_assoc($getColor);
    $getColor = json_decode($getColor['themeSpecification'], true);

?>

<style>
    :root{
        --mp-color-1 : <?php  echo $getColor['primaryColor']; ?>;
        --mp-theme-bg : <?php  echo $getColor['ThemeBgColor']; ?>;
    }

    * {
        margin: 0px;
        font-family: 'poppins';
        color: <?php echo $getColor['secondaryColor']; ?>;
    }
</style>