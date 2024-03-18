<?php
    include_once("../../server/db_connection.php");
    $SEARCH = $_POST['search'];
    $query = "SELECT concat(`fname`,' ',`lname`) as `name`, `uid`, `profile_picture` FROM users WHERE concat(`fname`,' ',`lname`) LIKE '%$SEARCH%'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Fetching all rows as associative array
        $allUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        // Free result set
        mysqli_free_result($result);
        
        // Output as JSON
        echo json_encode($allUsers);
    } else {
        // Handle query execution error
        echo "Error: " . mysqli_error($connection);
    }

    // Close database connection
    mysqli_close($connection);
?>
