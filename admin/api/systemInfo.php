<?php
    // ALEN [System Info]

    include_once("../../server/db_connection.php");

    if(session_status()!=PHP_SESSION_ACTIVE)
{
  session_start();
}


    
    function getSystemInfo()
    {
        global $connection;
        $getSystemColor = "SELECT * FROM `system_data` WHERE 1";
        $result = mysqli_query($connection, $getSystemColor);    
        $result = mysqli_fetch_assoc($result);

        echo json_encode($result);
  
    }

    function changeName($newName){
        global $connection;
        $updateName = "UPDATE `system_data` SET `system_name`='$newName' WHERE 1";
        $result = mysqli_query($connection, $updateName);

        if($result)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }
    }

    function changeDescription($newDescription)
    {
        global $connection;
        $updateDescription = "UPDATE `system_data` SET `system_description`='$newDescription' WHERE 1";
        $result = mysqli_query($connection, $updateDescription);

        if($result)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }
    }

    function changeMaintenanceMode()
    {
        global $connection;
        $getMaintenanceMode = "SELECT `maintenance_mode` FROM `system_data` WHERE 1";
        $result = mysqli_query($connection, $getMaintenanceMode);
        $result = mysqli_fetch_assoc($result);

        if($result['maintenance_mode']==1)
        {
            $toggleMaintenanceMode = "UPDATE `system_data` SET `maintenance_mode`='0' WHERE 1";
        }else{
            $toggleMaintenanceMode = "UPDATE `system_data` SET `maintenance_mode`='1' WHERE 1";
        }

        $result = mysqli_query($connection, $toggleMaintenanceMode);

        if($result)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }

    }

    function changeLogo($newLogoPath)
    {
        global $connection;
        $newLogo = "UPDATE `system_data` SET `system_logo`='$newLogoPath' WHERE 1";
        $result = mysqli_query($connection, $newLogo);

        if($result)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }  
    }

   function updateColorTheme($primaryColor="#222831", $secondaryColor="#FEFBF6", $themeBgColor="#FEFBF6")
   {
        global $connection;
        $colors = '{ "primaryColor": "'.$primaryColor.'", "secondaryColor": "'.$secondaryColor.'", "ThemeBgColor": "'.$themeBgColor.'" }';
        $updateColor = "UPDATE `system_data` SET `themeSpecification`='$colors' WHERE 1";
        $result = mysqli_query($connection, $updateColor);

        if($result)
        {
            echo json_encode(array("success"=>true));
        }else{
            echo json_encode(array("success"=>false));
        }
   }

   function getColorTheme()
   {
       global $connection;
       $getSystemColor = "SELECT * FROM `system_data` WHERE 1";
       $result = mysqli_query($connection, $getSystemColor);
   
       $result = mysqli_fetch_assoc($result);
       $data = json_decode($result['themeSpecification'], true);


       echo json_encode($data);
   }

   

   if($_SERVER["REQUEST_METHOD"]=="POST")
   {
       switch($_POST['mode'])
       {
           case "getSystemInfo":
               getSystemInfo();
               break;
           
           case "changeName":
               changeName($_POST['newName']);
               break;
           
           case "changeDescription":
               changeDescription(($_POST['newDescription']));
               break;
           
           case "changeMaintenance":
               changeMaintenanceMode();
               break;
           
           case "changeLogo":
               changeLogo($_FILES['logo']);
               break;
           
           case "updateColorTheme":
               updateColorTheme($_POST['primaryColor'], $_POST['secondaryColor'], $_POST['themeBgColor']);
               break;

            case "getColor":
                getColorTheme();
                break;

            case "setColor":
                $primaryColor = $_POST['primaryColor'];
                $secondaryColor = $_POST['secondaryColor'];
                $themeBgColor = $_POST['themeBgColor'];
                updateColorTheme($primaryColor, $secondaryColor, $themeBgColor);
                break;
       }
   }



?>
