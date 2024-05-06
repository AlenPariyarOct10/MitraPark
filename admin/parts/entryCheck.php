<?php
if(session_status()!=PHP_SESSION_ACTIVE){
    session_start();
}
if (!isset($_SESSION['loggedInAdmin'])) {
    header('Location: ../login.php?loginFirst1');
}
if (isset($_SESSION['loggedInAdmin'])) {
    if ($_SESSION['loggedInAdmin'] == false) {
        header('Location: ../login.php?loginFirst2');
    }
}

?>