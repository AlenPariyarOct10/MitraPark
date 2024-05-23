<?php

include_once("../../server/db_connection.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_SESSION['loggedInAdmin']) && $_SESSION['loggedInAdmin'] === true) {
        $search = htmlspecialchars(trim($_GET['search']));
        $getSearchPosts = "
            SELECT 
                p.post_id, 
                CONCAT(u.fname, ' ', u.lname) AS uname, 
                p.media, 
                p.status, 
                p.content 
            FROM 
                posts p 
            INNER JOIN 
                users u ON u.uid = p.author_id 
            WHERE 
                p.content LIKE '%$search%' 
                OR CONCAT(u.fname, ' ', u.lname) LIKE '%$search%' 
                OR p.post_id = '$search'
        ";

        $result = mysqli_query($connection, $getSearchPosts);

        $allData = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $allData[] = $row;
        }

        echo json_encode($allData);

    } else {
        // Return an empty array if the admin is not logged in
        echo json_encode(array());
    }

} else {
    // Return an empty array for invalid request methods
    echo json_encode(array());
}
?>
