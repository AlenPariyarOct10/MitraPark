<?php 
// array(6) { ["system_name"]=> string(9) "MitraPark" ["system_description"]=> string(28) "Connecting Mitras all around" ["maintainance_mode"]=> string(1) "1" ["primaryColor"]=> string(7) "#fefbf6" ["secondaryColor"]=> string(7) "#fefbf6" ["bgColor"]=> string(7) "#000000" } array(1) { ["logo_img"]=> array(6) { ["name"]=> string(0) "" ["full_path"]=> string(0) "" ["type"]=> string(0) "" ["tmp_name"]=> string(0) "" ["error"]=> int(4) ["size"]=> int(0) } } 

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST

    include_once("../server/db_connection.php");

    $validImg = false;
    $validFile = false;

    $systemName = $_POST['system_name'];
    $systemDesc = $_POST['system_description'];
    $primaryColor = $_POST['primaryColor'];
    $secondaryColor = $_POST['secondaryColor'];
    $bgColor = $_POST['bgColor'];
    $maintainance_mode = $_POST['maintainance_mode'];
    $colorTheme = json_encode(array(
        "primaryColor" => $primaryColor,
        "secondaryColor" => $secondaryColor,
        "ThemeBgColor" => $bgColor
    ));

    var_dump($_FILES['logo_img']);

    // Check if a file is uploaded
    if (isset($_FILES['logo_img']) && $_FILES['logo_img']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['logo_img'];
        $fileName = $_FILES['logo_img']['name'];
        $fileTempName = $_FILES['logo_img']['tmp_name'];
        $path = "../assets/images/";

        $validFileType = array("jpg", "jpeg", "png");
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if the uploaded file has a valid extension
        if (in_array($fileExtension, $validFileType)) {
            $validFile = true;
            $newName = uniqid() . "." . $fileExtension;
            move_uploaded_file($fileTempName, $path . $newName);
            $upFilePath = '/assets/images/' . $newName; // Relative path to the uploaded image
            
            // Update system data with the new logo path
            $updateSystemLogo = "UPDATE `system_data` SET `system_name`='$systemName', `system_description`='$systemDesc', `system_logo`='$upFilePath', `maintenance_mode`='$maintainance_mode', `themeSpecification`='$colorTheme' WHERE 1";
            mysqli_query($connection, $updateSystemLogo);
            echo "Image changed";
            header("Location: system.php?updateSuccess");
            exit(); // Exit to prevent further execution
        } else {
            header("Location: system.php?updateFailed");
            exit(); // Exit to prevent further execution
        }
    } else {
        // Update system data without changing the logo path
        $updateSystemLogo = "UPDATE `system_data` SET `system_name`='$systemName', `system_description`='$systemDesc', `maintenance_mode`='$maintainance_mode', `themeSpecification`='$colorTheme' WHERE 1";
        mysqli_query($connection, $updateSystemLogo);
        echo "Image not changed";
        header("Location: system.php?updateSuccess");
        exit(); // Exit to prevent further execution
    }
}

?>
