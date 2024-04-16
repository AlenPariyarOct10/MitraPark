<?php 

    var_dump($_POST);
    var_dump($_FILES);

    // array(6) { ["system_name"]=> string(9) "MitraPark" ["system_description"]=> string(28) "Connecting Mitras all around" ["maintainance_mode"]=> string(1) "1" ["primaryColor"]=> string(7) "#fefbf6" ["secondaryColor"]=> string(7) "#fefbf6" ["bgColor"]=> string(7) "#000000" } array(1) { ["logo_img"]=> array(6) { ["name"]=> string(0) "" ["full_path"]=> string(0) "" ["type"]=> string(0) "" ["tmp_name"]=> string(0) "" ["error"]=> int(4) ["size"]=> int(0) } } 

// /MitraPark/assets/images/mitrapark.png
if (isset($_POST)) {

    include_once("../server/db_connection.php");

    $validImg = false;
    $validFile = false;

    $systemName = $_POST['system_name'];
    $systemDesc = $_POST['system_description'];
    $primaryColor = $_POST['primaryColor'];
    $secondaryColor = $_POST['secondaryColor'];
    $bgColor = $_POST['bgColor'];
    $maintainance_mode = $_POST['maintainance_mode'];
    $colorTheme = '{   "primaryColor": "'.$primaryColor.'",   "secondaryColor": "'.$secondaryColor.'",   "ThemeBgColor": "'.$bgColor.'" }';

    if (isset($_FILES['file'])) {
        $img = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTempName = $_FILES['file']['tmp_name'];
        $path = "../../assets/images/";

        $validFileType = array("jpg", "jpeg", "png");
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $validFileType)) {
            $validFile = true;
            $newName = uniqid() . "." . $fileExtension;
            move_uploaded_file($fileTempName, $path . $newName);
            $upFilePath = $_GLOBALS['fileName'] = '/user_uploads/' . $newName;
            
            $updateSystemLogo = "UPDATE `system_data` SET `system_name`='$systemName',`system_description`='$systemDesc',`system_logo`='$upFilePath',`maintenance_mode`='$maintainance_mode',`themeSpecification`='$colorTheme' WHERE 1";
            mysqli_query($connection, $updateSystemLogo);
            header("Location: system.php?updateSuccess");
        }else{
            header("Location: system.php?updateFailed");
        }
    }else{
        $updateSystemLogo = "UPDATE `system_data` SET `system_name`='$systemName',`system_description`='$systemDesc',`maintenance_mode`='$maintainance_mode',`themeSpecification`='$colorTheme' WHERE 1";
        mysqli_query($connection, $updateSystemLogo);
        header("Location: system.php?updateSuccess");

    }
    
}

?>