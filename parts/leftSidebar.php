<div class='body'>
    <div class='left-sidebar'>
        <div class='left-top'>
            <div class='left-inner-heading'>
                <span class='dim-label'>
                    Suggested Mitras
                </span>
                <hr class="label-underline">
            </div>
            <?php

            $p_address_id = $_SESSION['user']['p_address_id'];
            $t_address_id = $_SESSION['user']['t_address_id'];
            $p_address_id = $_SESSION['user']['p_address_id'];
            $academic_institution_id = $_SESSION['user']['academic_institution_id'];

            // MITRAPARK-NOTE : Suggested Mitras -> Should not be Mitra, Any of the personal info should match (p-address, t-address, college-name)
            $getUsers = "SELECT * FROM users WHERE uid NOT IN (SELECT sender_id FROM friends WHERE acceptor_id = '$uid' UNION SELECT acceptor_id FROM friends WHERE sender_id = '$uid')
                    AND uid <> '$uid' AND (users.academic_institution_id = '$academic_institution_id' OR users.p_address_id = '$p_address_id' OR users.t_address_id = '$t_address_id') LIMIT 6";

            $result = mysqli_query($connection, $getUsers);
            if ($c = mysqli_affected_rows($connection)) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="left-inner-body">
                        <div class="mitra-request-list-item" id="user-<?php echo $row['uid']; ?>">
                            <a class="redirect-to-profile" href="user.php?id=<?php echo $row['uid']; ?>">
                                <img class="mitra-request-profile-list" src="<?php echo "./" . $row['profile_picture']; ?>">
                                <span class="uname">
                                    <?php echo $row['fname'] . " " . $row['lname']; ?>
                                </span>
                            </a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No users found";
            }
            ?>


        </div>
        <div class="left-bottom">
            <div class="left-inner-heading">
                <span class="dim-label">
                    Mitra Requests
                </span>
                <hr class="label-underline">
            </div>
            <div id="mitraList" class="left-inner-body">
                No requests found
            </div>
        </div>
    </div>