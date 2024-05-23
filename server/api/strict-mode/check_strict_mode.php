<?php

    // ALEN : Checking if strict mode exists 
    include_once "../../db_connection.php";
    if(session_status()!=PHP_SESSION_ACTIVE)
    {
        session_start();
    }

    $uid = $_SESSION['user']['uid'];
    $checkStrictMode = "SELECT * FROM `strict_mode` WHERE `uid`='$uid'";

    $result = mysqli_query($connection, $checkStrictMode);
    $result = mysqli_fetch_assoc($result);

    if($result['strictMode']==1 && $result['autoRenew']==1)
    {
        $today = date("Y-m-d");
        if(strtotime($result['today_date'])!=strtotime($today))
        {
            $renewStrictMode = "UPDATE `strict_mode` SET `today_date`='$today',`endStrictDate`='$today', `availableAccessSeconds`=`maxAccessSeconds` WHERE `uid`='$uid'";
            mysqli_query($connection, $renewStrictMode);
        }
    }else if($result['strictMode']==1 && $result['autoRenew']==0)
    {
        $today = date("Y-m-d");
        if(strtotime($result['today_date'])!=strtotime($today))
        {
            $renewStrictMode = "DELETE FROM `strict_mode` WHERE `uid`='$uid'";
            mysqli_query($connection, $renewStrictMode);
        }
    }


    
    if($result == null)
    {
        $result = array("strict-mode"=>false, "strict-lock"=>false);
        
    }else if($result['availableAccessSeconds']>=0)
    {
        $result = array("strict-mode"=>true, "strict-lock"=>false, "availableAccessSeconds"=>$result['availableAccessSeconds'], "getWarning"=>$result['getWarning']);
        
    }else{
        $result = array("strict-mode"=>true, "strict-lock"=>true);
        
    }
    echo json_encode($result);

    


?>