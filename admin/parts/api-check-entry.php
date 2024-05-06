<?php
  if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['loggedInAdmin'])) {
    echo "Unauthorized access blocked";
    exit();
}
if (isset($_SESSION['loggedInAdmin'])) {
    if ($_SESSION['loggedInAdmin'] == false) {
        echo "Unauthorized access blocked";
        exit();
    }
}
?>