<div class='body'>
<div class="left-nav">
            <div class="left-top">
                <div class="left-inner-heading">
                    <span class="dim-label">
                        Suggested Mitras
                    </span>
                    <hr class="label-underline">
                </div>

                <!-- -------------------------------- -->
                <?php
                    $getUsers = "SELECT * FROM `users` WHERE `uid` NOT IN (SELECT `sender_id` as 'uid' FROM `friends` WHERE `sender_id`='$uid' or `acceptor_id`='$uid') AND `uid` <> '$uid'";

                
                    $result = mysqli_query($connection, $getUsers);
                    if($c=mysqli_affected_rows($connection))
                    {
                        

                        while($row = mysqli_fetch_assoc($result))
                        {
                     

                            ?>
                            <div class="left-inner-body">
                                <div class="mitra-request-list-item" id="user-<?php echo $row['uid'];?>">
                                    <a class="redirect-to-profile" href="user.php?id=<?php echo $row['uid']; ?>">
                                        <img class="mitra-request-profile-list" src="<?php echo "./". $row['profile_picture']; ?>">
                                        <span class="uname">
                                            <?php echo $row['fname']." ".$row['lname']; ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                <?php
                        }
                    }else{
                        echo "No users found";
                    }
                ?>

                <!-- -------------------------------- -->
                
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