<?php
    // ALEN : Update remaining access time in each call

    include_once "../../db_connection.php";
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $checkStrictMode = "SELECT * FROM `strict_mode` WHERE `strictMode`=1 AND `endStrictDate`=CURDATE() AND `uid`='$uid'";

    $result = mysqli_query($connection, $checkStrictMode);
    $result = mysqli_fetch_assoc($result);

   
  

    if($result != null)
    {
        if($result['availableAccessSeconds']>=0)
        {
           
            $updateQuery = "UPDATE `strict_mode` SET `availableAccessSeconds`=`availableAccessSeconds` - 5 WHERE `endStrictDate`=CURDATE() AND `uid`='$uid'";
            mysqli_query($connection, $updateQuery);

            $checkStrictMode1 = "SELECT * FROM `strict_mode` WHERE `strictMode`=1 AND `endStrictDate`=CURDATE() AND `uid`='$uid'";

            $result1 = mysqli_query($connection, $checkStrictMode1);
            $result1 = mysqli_fetch_assoc($result1);

           

            $result = array("strict-mode"=>true, "strict-lock"=>false);
            echo json_encode($result);
        }else{
            if($result['strictMode']==1)
            {
                $result = array("strict-mode"=>true, "strict-lock"=>true);
                echo json_encode($result);
            }else{
                $result = array("strict-mode"=>false, "strict-lock"=>false);
                echo json_encode($result);

            }
           
        }
    }else{
        $result = array("strict-mode"=>false, "strict-lock"=>false);
            echo json_encode($result);
    }

    


?>