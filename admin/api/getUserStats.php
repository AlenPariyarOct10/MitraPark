<?php
include_once("../../server/db_connection.php");

function NumToMonth($month)
{
    $months = array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    );

    return $months[$month];
}

if($_SERVER['REQUEST_METHOD']==="GET"){

    $currentYear = date("Y");
    $currentMonth = date("m");

    $formattedResult = array();

    $deletReportQuery = "SELECT 
    MONTH(createdDateTime) AS month,
    COUNT(*) AS user_count
    FROM users
    WHERE YEAR(createdDateTime) = YEAR(CURDATE())
    GROUP BY MONTH(createdDateTime)";

    $result = mysqli_query($connection, $deletReportQuery);
    if(mysqli_affected_rows($connection))
    {
        while($row = mysqli_fetch_assoc($result))
        array_push($formattedResult, array(NumToMonth($row['month']), $row['user_count']));
    }
    
    if(count($formattedResult)>0)
    {
        echo json_encode($formattedResult);
    }else{
        echo json_encode(array(NumToMonth($currentMonth) => 0));
    }
}
?>

