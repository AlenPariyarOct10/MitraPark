<?php
if (!isset($_SESSION)) {
    session_start();
}


if (!isset($_SESSION['loggedIn'])) {
    
}
if (isset($_SESSION['loggedIn'])) {
    if ($_SESSION['loggedIn'] == false) {
        header('Location: login.php?loginFirst2');
    }
    exit();
}

?>