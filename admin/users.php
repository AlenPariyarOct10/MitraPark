<?php
include_once ("./parts/entryCheck.php");
include_once ("../server/db_connection.php");
$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users ~ <?php echo $aboutSite['system_name']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Khand:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/boxicons/css/boxicons.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .card-style-red {
            background: -webkit-gradient(linear, left top, right top, from(#fe5d70), to(#fe909d));
            background: linear-gradient(to right, #fe5d70, #fe909d);
            color: white;
        }

        .card-stats-count {
            font-size: xxx-large;
            font-weight: bolder;
        }

        .search-box{
            background-color: white;
            width: 35%;
            box-shadow: 0.5px 0.5px 5px 0.5px grey;
        }


        .search-box-inp{
            outline:none;
            border: none;
            width: 90%;
            height: 100%;
            font-size: large;
        }
    </style>
</head>

<body>
    <div class="body">
        <?php include_once ("./parts/sidebar.php") ?>
        <div class="content">
            <div class="inner-header">
                <p>All Users ~ <?php echo $aboutSite['system_name']; ?></p>
            </div>
            <div class="inner-body">
                <div class="inner-body-section">
                  <div class="search-box">
                    <input type="text" placeholder="Search by Name, UID or Email" class="search-box-inp" id="search-box-inp">
                  </div>
                </div>

                <div class="inner-body-section table-wrapper">
                    <p id="table-mode"></p>
                    <table id="record-table">
                        <thead style="padding: 20px;" class="th">
                            <th class="table-heading">UID</th>
                            <th class="table-heading">Name</th>
                            <th class="table-heading">Profile Picture</th>
                            <th class="table-heading">Status</th>
                            <th class="table-heading">Operation</th>
                        </thead>
                        <tbody id="users-data">

                        </tbody>
                    </table>
                    <div id="pagination-count">
                        <?php
                            $getPagination = "SELECT count(uid) as count FROM `users`";
                            $getPagination = mysqli_query($connection, $getPagination);
                            $getPagination = mysqli_fetch_assoc($getPagination);
                            
                            $count = $getPagination['count']/8;
                            
                            for($i=1;$i<=ceil($count);$i++)
                            {
                                echo '<button class="pagination-btn" id="pagination-btn-'.$i.'" onclick="getAllUsers('.$i.')">'.$i.'</button>';
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="../assets/scripts/jquery.js"></script>
<script>

    let searchBoxInp =document.getElementById("search-box-inp");
    var allUsers = [];

    searchBoxInp.addEventListener("keyup",()=>{
        if(searchBoxInp.value.length > 0)
        {
            searchUser(searchBoxInp.value);
        }else{
            getAllUsers(1);
        }
    })

    function searchUser(search)
    {
        $.ajax({
            url: "./api/getUserBySearch.php",
            type: "GET",
            data: {
                search: search,
            },
            success: (response)=>{
                let responseObj = JSON.parse(response);
                allUsers =responseObj;
                $("#users-data")[0].innerHTML = "";
                responseObj.map((item)=>{
                    $("#users-data")[0].innerHTML += `<tr>
                <td>${item.uid}</td>
                <td>${item.uname}</td>
                <td><img height="40px" style="border-radius:50%" src="../${item.profile_picture}" alt="" srcset=""></td>
                
                <td>${item.status}</td>
                <td>
                    ${(item.status === 'active') ? 
                        `<button class="table-option operation-btn" onclick="restrictUser(${item.uid})">Restrict</button>`:
                        `<button class="table-option operation-btn" onclick="unrestrictUser(${item.uid})">Unrestrict</button>`
                    }
                    <button class="table-option" onclick="viewUser(${item.uid})" class="operation-btn">View</button>
                    <a class="table-option" href="viewUser.php?uid=${item.uid}" class="operation-btn">View</a>
                </td>
                </tr>`;
                })
                
            }
        })
    }

    function getAllUsers(page)
    {
        $.ajax({
            url: "./api/getAllUsers.php",
            type: "POST",
            data: {
                page: page,
            },
            success: (response)=>{
                let responseObj = JSON.parse(response);
              
                $(".pagination-btn").removeClass("active-page");
                if(!$(`#pagination-btn-${page}`).hasClass("active-page"))
                {
                    $(`#pagination-btn-${page}`).addClass("active-page");
                }else{
                    $(`#pagination-btn-${page}`).removeClass("active-page");
                }

                allUsers =responseObj;
                console.log(responseObj);
                $("#users-data")[0].innerHTML = "";
                responseObj.map((item)=>{
                    $("#users-data")[0].innerHTML += `<tr>
                <td>${item.uid}</td>
                <td>${item.uname}</td>
                <td><img height="40px" style="border-radius:50%" src="../${item.profile_picture}" alt="" srcset=""></td>
                
                <td>${item.status}</td>
                <td>
                ${(item.status === 'active') ? 
                        `<button class="table-option operation-btn" onclick="generateRestrictUserModal(${item.uid})">Restrict</button>`:
                        `<button class="table-option operation-btn" onclick="generateUnrestrictUserModal(${item.uid})">Unrestrict</button>`
                    }
                    <a class="table-option" href="viewUser.php?uid=${item.uid}" class="operation-btn">View</a>
                </td>
                </tr>`;
                })
                
            }
        })
    }

    getAllUsers(1);


    function getRestrictedInfo() {
        // ALEN : Get restricted and reported data
        $.ajax({
            url: "./api/userInfo.php",
            type: "POST",
            success: async (response) => {
                // console.log(response);
                const responseObj = await JSON.parse(response);
                $("#restricted_users")[0].innerText = responseObj.restricted_users;
                $("#reported_users")[0].innerText = responseObj.reported_users;
            }
        })
    }

    $('body').css({
        'height': $(this).height()
    });
    if ($(window).width() > 576) {
        if ($(".sidebar").hasClass("sidebar-mobile")) {
            $(".sidebar").removeClass("sidebar-mobile");
            $(".sidebar").addClass("sidebar-desktop");
            $(".sidebar-links").show();
            $(".card-grid").css({
                'height': '100%',
                'flex-direction': 'row',
                'justify-content': 'space-around'
            });
            $(".card").css({
                "width": "20%"
            })
        }
    } else if ($(window).width() < 576) {
        if ($(".sidebar").hasClass("sidebar-desktop")) {
            $(".sidebar").removeClass("sidebar-desktop");
            $(".sidebar").addClass("sidebar-mobile");
            $(".sidebar-links").hide();
            $(".card-grid").css({
                'height': '100%',
                'flex-direction': 'column',
                'justify-content': 'space-around'
            });
            $(".card").css({
                "width": "90%"
            })
        }
    }

    $(window).resize(() => {
        if ($(window).width() > 576) {
            if ($(".sidebar").hasClass("sidebar-mobile")) {
                $(".sidebar").removeClass("sidebar-mobile");
                $(".sidebar").addClass("sidebar-desktop");
                $(".sidebar-links").show();
                $(".card-grid").css({
                    'height': '100%',
                    'flex-direction': 'row',
                    'justify-content': 'space-around'
                });
                $(".card").css({
                    "width": "20%"
                })
            }
        } else if ($(window).width() < 576) {
            if ($(".sidebar").hasClass("sidebar-desktop")) {
                $(".sidebar").removeClass("sidebar-desktop");
                $(".sidebar").addClass("sidebar-mobile");
                $(".sidebar-links").hide();
                $(".card-grid").css({
                    'height': '100%',
                    'flex-direction': 'column',
                    'justify-content': 'space-around'
                });
                $(".card").css({
                    "width": "90%"
                })
            }
        }
    })



    function restrictUser(uid) {
        $.ajax({
            url: "./api/restrictUser.php",
            type: "GET",
            data: {
                userId: uid
            },
            success: (response) => {
                getAllUsers(1);
                removeModal();
            },
            error: (response) => {
                // console.log(response);
            }
        })
    }

    function generateUnrestrictUserModal(userId) {
        if ($("#modal-wrapper")[0] === undefined) {
            $(".body")[0].innerHTML += "<div id='modal-wrapper'></div>";
            $("#modal-wrapper")[0].innerHTML = `
            
          
            <div class="modal">
                <img class="modal-popup-head" height="80px" src="../assets/images/restriction.png" alt="" srcset="">
                <div class="post-uploader">
                    <div class="post-uploader-head">
                        <h3>Are you sure you want to unrestrict this user?</h3>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-red close-modal">No</button>
                        <button onclick="unrestrictUser(${userId})" class="btn btn-green">Yes</button>
                    </div>
                </div>
            </div>
       
            `;
            $(".close-modal").click(removeModal);
            getRestrictedInfo();
        }
    }


    function unrestrictUser(userId) {
        $.ajax({
            url: "./api/unrestrictUser.php",
            type: "GET",
            data: {
                userId: userId,
            },
            success: (response) => {
                console.log(response);
                console.log("clicked -> "+userId);
                getAllUsers(1);
                removeModal();
             
            },
            error: (response) => {
                // console.log(response);
            }
        })
    }

    function generateDeleteUserModal(reportId) {
        if ($("#modal-wrapper")[0] === undefined) {
            $(".body")[0].innerHTML += "<div id='modal-wrapper'></div>";
            $("#modal-wrapper")[0].innerHTML = `
            
            <!-- ALEN Report delete modal -->
            <div class="modal">
                <img class="modal-popup-head" height="80px" src="../assets/images/trash.png" alt="" srcset="">
                <div class="post-uploader">
                    <div class="post-uploader-head">
                        <h3>Are you sure you want to delete this report?</h3>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-red close-modal">No</button>
                        <button onclick="BtndeleteReport(${reportId})" class="btn btn-green">Yes</button>
                    </div>
                </div>
            </div>
            <!-- End delete modal -->
            `;
            $(".close-modal").click(removeModal);
            getRestrictedInfo();
            return;
        }
    }

    function generateRestrictUserModal(uid) {
        if ($("#modal-wrapper")[0] === undefined) {
            $(".body")[0].innerHTML += "<div id='modal-wrapper'></div>";
            $("#modal-wrapper")[0].innerHTML = `
            
            <!-- ALEN Report delete modal -->
            <div class="modal">
                <img class="modal-popup-head" height="80px" src="../assets/images/restriction.png" alt="" srcset="">
                <div class="post-uploader">
                    <div class="post-uploader-head">
                        <h3>Are you sure you want to restrict this user?</h3>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-red close-modal">No</button>
                        <button onclick="restrictUser(${uid})" class="btn btn-green">Yes</button>
                    </div>
                </div>
            </div>
            <!-- End delete modal -->
            `;
            $(".close-modal").click(removeModal);
        }
    }

    function generateModal() {
        if ($("#modal-wrapper")[0] === undefined) {
            $(".body")[0].innerHTML += "<div id='modal-wrapper'></div>";
            $("#modal-wrapper")[0].innerHTML = `
            
            <!-- ALEN Report post modal -->

            <div class="modal">
                <img class="modal-popup-head" height="80px" src="" alt="" srcset="">
                <div class="post-uploader">
                    <div class="post-uploader-head">
                        <h3></h3>
                    </div>
                    <hr class="section-break-hr">
                    <div class="modal-body">
                        model body
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-red close-modal">Close</button>
                        <button class="btn btn-green">Hello</button>
                    </div>
                </div>
            </div>
            <!-- End Report post modal -->
     
            `;
            $(".close-modal").click(removeModal);
        }
    }

    function removeModal() {
        try {
            $("#modal-wrapper")[0].remove();
        } catch (error) {

        }
    }


</script>

</html>