<?php 
include_once("./parts/entryCheck.php");
include_once("../server/db_connection.php");
$aboutSite = $connection->query('SELECT * FROM `system_data`');
$aboutSite = $aboutSite->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reported Posts ~ <?php echo $aboutSite['system_name']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Khand:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/boxicons/css/boxicons.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="body">
        <?php include_once("./parts/sidebar.php") ?>
        <div class="content">
            <div class="inner-header">
                <p>Reported Posts ~ <?php echo $aboutSite['system_name']; ?> </p>
            </div>
            <div class="inner-body">
                <div class="inner-body-section">
                    <!-- ALEN : CARD -->
                    <div class="card-grid">
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">TOTAL REPORTED POSTS - Unique</p>
                         
                            </div>
                            <div class="card-row">
                                <p id="reported_users">Loading...</p>
                            </div>
                            <div class="card-row">
                                <span style="cursor:pointer;" onclick="getReportedPosts(1);" class="lite-dim underline" data-num="1">View records</span>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">TOTAL RESTRICTED POSTS - Unique</p>
                      
                            </div>
                            <div class="card-row">
                                <p id="restricted_users">Loading...</p>
                            </div>
                            <div class="card-row">
                                <span style="cursor:pointer;" onclick="getRestrictedPosts(1)" class="lite-dim underline" data-num="1">View records</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-body-section table-wrapper">
                    <p id="table-mode"></p>
                    <table id="record-table" style="display:none">
                        <thead style="padding: 20px;" class="th">
                            <th class="table-heading">Report Id</th>
                            <th class="table-heading">Post ID</th>
                            <th class="table-heading">Report Description</th>
                            <th class="table-heading">Operation</th>
                        </thead>
                        <tbody id="users-data">

                        </tbody>
                    </table>
                    <div id="pagination-count">

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="../assets/scripts/jquery.js"></script>
<script>
    getRestrictedInfo();
    getReportedPosts(1);

    function getRestrictedInfo() {
        // ALEN : Get restricted and reported data
        $.ajax({
            url: "./api/userInfo.php",
            type: "POST",
            success: async (response) => {
                const responseObj = await JSON.parse(response);
                $("#restricted_users")[0].innerText = responseObj.total_restricted_posts;
                $("#reported_users")[0].innerText = responseObj.total_reported_posts;
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

    function getRestrictedPosts(id) {
        $("#pagination-count")[0].innerHTML = "";
        // console.log("clicked");
        $("#users-data")[0].innerHTML = "";
        $("#record-table").css({
            'display': ''
        });
        // ALEN : FETCH RESTRICTED USERS
        $.ajax({
            url: "./api/report.php",
            type: "POST",
            data: {
                reportType: "restrictedPosts",
                page: id,
            },
            success: (result) => {
                // console.log(result);

                $("#table-mode")[0].innerText = "Restricted Posts";
                let resultObj = JSON.parse(result);
                // console.log("obj->",resultObj);
                let totalRow = null;
                if (resultObj.length > 0) {
                    resultObj.forEach((row) => {
                        if (totalRow == null) {
                            totalRow = row.total_count;
                        }
                        // console.log(row);

                        $("#users-data")[0].innerHTML +=
                            `
                            <tr>
                                <td>${row.report_id}</td>
                                <td>${row.component_id}</td>
                                <td>${row.report_content}</td>
                                <td>
                                    <button class="table-option" onclick="unrestrictPost(${row.report_id})" class="operation-btn">Unrestrict</button>
                                    <a class="table-option" href="viewPost.php?postId=${row.component_id}" class="operation-btn">View</a>
                                </td>
                            </tr>
                        `;
                    });

                    let count = totalRow / 20;
                    // console.log("total count - > ",count, totalRow);
                 
                    for (let c = 1; c <= Math.ceil(count); c++) {
                        $("#pagination-count")[0].innerHTML +=
                            `
                        <button class="pagination-btn ${ (id==c)?'active-page':''}" onclick="getRestrictedPosts(${c})"" >${c}</button>
                    `;
                    }
                  
                  
                } else {
                    $("#users-data")[0].innerHTML +=
                        `
                            <tr>
                                <td style="background-color: #5aaa" colspan="5">No records found</td>
                            </tr>
                    `;
     
                }
            }
        })
        getRestrictedInfo();
    }

    function getReportedPosts(id) {
        $("#pagination-count")[0].innerHTML = "";
        $("#users-data")[0].innerHTML = "";
        // console.log(id);


        $("#record-table").css({
            'display': ''
        });
        // ALEN : FETCH REPORTED USERS
        $.ajax({
            url: "./api/report.php",
            type: "POST",
            data: {
                reportType: "post",
                page: id,
            },
            success: async (result) => {
                $("#table-mode")[0].innerText = "Reported Posts";
                // console.log(result);
                let resultObj = await JSON.parse(result);
                let totalRow = null;

                if (resultObj.length > 0) {
                    resultObj.forEach((row) => {
                        if (totalRow == null) {
                            totalRow = row.total_count;
                        }

                        $("#users-data")[0].innerHTML +=
                            `
                            <tr>
                                <td>${row.report_id}</td>
                                <td>${row.component_id}</td>
                                <td>${row.report_content}</td>
                                <td>
                                    <button class="table-option" onclick="deleteReport(${row.report_id})" class="operation-btn">Delete</button>
                                    <button class="table-option" onclick="generateRestrictUserModal(${row.report_id})" class="operation-btn">Restrict</button>
                                    <a class="table-option" href="viewPost.php?postId=${row.component_id}" class="operation-btn">View</a>
                                </td>
                            </tr>
                    `;
                    });
                    
                    let count = totalRow / 20;

                    for (let c = 1; c <= Math.ceil(count); c++) {
                        $("#pagination-count")[0].innerHTML +=
                            `
                        <button class="pagination-btn ${ (id==c)?'active-page':''}" onclick="getReportedPosts(${c})"">${c}</button>
                    `;
                    }
             

                } else {
                    $("#users-data")[0].innerHTML +=
                        `
                            <tr>
                                <td style="background-color: #5aaa" colspan="5">No records found</td>
                            </tr>
                    `;
            

                }

            }
        })
        getRestrictedInfo();
    }

    $(".showReportedUsers").click(() => {
        getReportedPosts(1);
    })

    function deleteReport(reportId) {
        // console.log(reportId);
        generateDeleteUserModal(reportId);
        getRestrictedInfo();
    }

    function BtndeleteReport(reportId) {
        $.ajax({
            url: "./api/deleteReport.php",
            type: "GET",
            data: {
                reportId: reportId
            },
            success: (response) => {
                getReportedPosts(1);
                removeModal();
                getRestrictedInfo();
            },
            error: (response) => {
                // console.log(response);
            }
        })
    }

    function restrictPost(reportId) {
        $.ajax({
            url: "./api/restrictPost.php",
            type: "GET",
            data: {
                reportId: reportId
            },
            success: (response) => {
                getReportedPosts(1);
                removeModal();
                getRestrictedInfo();
            },
            error: (response) => {
                // console.log(response);
            }
        })
    }

    function generateUnrestrictUserModal(reportId) {
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
                        <button onclick="restrictPost(${reportId})" class="btn btn-green">Yes</button>
                    </div>
                </div>
            </div>
       
            `;
            $(".close-modal").click(removeModal);
            getRestrictedInfo();
        }
    }

    function viewUser(uid) {
        // console.log(uid);
    }

    function unrestrictPost(reportId) {
        $.ajax({
            url: "./api/unrestrictPost.php",
            type: "GET",
            data: {
                reportId: reportId
            },
            success: (response) => {
                getRestrictedPosts(1);
                removeModal();
                getRestrictedInfo();
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

    function generateRestrictUserModal(reportId) {
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
                        <button onclick="restrictPost(${reportId})" class="btn btn-green">Yes</button>
                    </div>
                </div>
            </div>
            <!-- End delete modal -->
            `;
            $(".close-modal").click(removeModal);
            getRestrictedInfo();
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