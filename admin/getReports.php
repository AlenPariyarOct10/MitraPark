<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Khand:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/boxicons/css/boxicons.css">
    <style>
        body {
            margin: 0px;
            padding: 0px;
            background-color: #F3F3F9;
            display: flex;
            flex-direction: column;
            font-family: 'Hanken Grotesk';
            font-size: 28px;
            font-weight: normal;
        }

        .body {
            display: flex;
            background-color: #f2f2f2;
            height: 100%;

        }


        /* ALEN: SIDEBAR */
        .sidebar {
            background-color: #3d4d82;
            ;
            transition: width 0.9s ease;
            color: rgb(243, 243, 243);
            font-size: medium;
            line-height: 30px;

        }

        .sidebar-mobile {
            width: 60px;
        }

        .sidebar-desktop {
            width: 180px;

        }

        .sidebar ul>*:hover {
            background-color: #535C91;
        }





        .sidebar ul>li {

            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .active-tab {
            background-color: #FF204E;
            font-weight: bold;
        }

        .sidebar ul {
            padding: 0;
            margin: 0;
            width: 100%;
        }

        a {
            width: 100%;
            color: whitesmoke;
            text-decoration: none;
        }

        .sidebar ul>li {
            padding-left: 20px;
            /* background-color: red; */
        }

        .inner-body {
            height: 100%;
        }


        /* ---------------------------------------- */
        .content {
            padding: 30px;
            width: 100%;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .content {
            display: flex;
            flex-direction: column;
        }



        /* Card Style */
        .card {
            display: flex;
            flex-direction: column;
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0px 0px 20px 1px #9f9f9f66;
            width: 20%;
            height: 100px;

        }

        .card:hover {

            box-shadow: 0px 0px 20px 1px #9f9f9fad;

        }

        .card-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .lite-dim {
            font-weight: 500;
            font-size: small;
            color: #535C91;
        }

        .underline {
            text-decoration: underline;
        }

        .bg-green {
            background-color: #6effc5;
            color: #00b96f;
        }

        .bg-red {
            background-color: #ff6e6e;
            color: #b90000;
        }

        .bg-yellow {
            background-color: #ffee6e;
            color: #b9b300;
        }

        .bg-blue {
            background-color: #6e8bff;
            color: #002eb9;
        }

        .icon-cover {
            padding: 5px 8px 5px 8px;
            border-radius: 10px;
        }

        .card-grid {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        /* ----------------TABLE--------------------------- */
        table {
            font-size: large;
            width: 100%;
        }

        tr:nth-child(even) {
            background-color: #d4d4d4;

        }

        th {
            font-size: large;
            text-align: center;
            font-weight: bold;
            color: white;
            background-color: #295fff;
            padding: 10px;

        }

        td {
            text-align: center;
        }

        .table-wrapper {
            margin-top: 10px;
            height: 75vh;
            overflow: scroll;
        }
        
        .operation-btn{
            cursor: pointer;
        }

        /* Pagination */
        .pagination-btn {
            border: none;
            background-color: darkgray;
            padding: 5px;
            color: white;
            cursor: pointer;
        }

        .active-page {
            background-color: #295fff;
        }
    </style>
</head>

<body>

    <div class="body">
        <div class="sidebar sidebar-desktop">
            <span><a href="">MitraPark</a></span>
            <ul>
                <li class="active-tab"><i class="bx bxs-dashboard"></i><a class="sidebar-links" href="">Dashboard</a>
                </li>
                <li><i class="bx bxs-user"></i><a class="sidebar-links" href="">Reported Users</a></li>
                <li><i class="bx bx-card"></i><a class="sidebar-links" href="">Reported Posts</a></li>
                <li><i class="bx bx-info-square"></i><a class="sidebar-links" href="">System</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="inner-header">
                <p>Dashboard ~ MitraPark </p>
            </div>
            <div class="inner-body">
                <div class="inner-body-section">
                    <!-- ALEN : CARD -->
                    <div class="card-grid">
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">TOTAL REPORTED USERS</p>
                                <p class="lite-dim">+0.00%</p>
                            </div>
                            <div class="card-row">
                                <p>5K</p>
                            </div>
                            <div class="card-row">
                                <span style="cursor:pointer;" class="lite-dim underline showReportedUsers" data-num="1">View records</span>
                                <span class="icon-cover bg-red">
                                    <i><i class="bx bxs-user">
                                            <div></div>
                                        </i></i>
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">TOTAL RESTRICTED USERS</p>
                                <p class="lite-dim">+0.00%</p>
                            </div>
                            <div class="card-row">
                                <p>5K</p>
                            </div>
                            <div class="card-row">
                                <span style="cursor:pointer;" class="lite-dim underline showRestrictedUsers" data-num="1">View records</span>
                                <span class="icon-cover bg-yellow">
                                    <i><i class="bx bxs-user">
                                            <div></div>
                                        </i></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-body-section table-wrapper">
                    <p id="table-mode"></p>
                    <table id="record-table" style="display:none">
                        <thead style="padding: 20px;" class="th">
                            <th class="table-heading">Report Id</th>
                            <th class="table-heading">UID</th>
                            <th class="table-heading">Name</th>
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

    function getRestrictedUsers(id)
    {
        $("#users-data")[0].innerHTML = "";
        $("#record-table").css({
            'display': ''
        });
        // ALEN : FETCH RESTRICTED USERS
        $.ajax({
            url: "./api/report.php",
            type: "POST",
            data: {
                reportType: "restrictedUser",
                page: id,
            },
            success: (result) => {
                console.log(result);

                $("#table-mode")[0].innerText = "Restricted Users";
                let resultObj = JSON.parse(result);
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
                                <td>${row.uid}</td>
                                <td>${row.fname} ${row.lname}</td>
                                <td>${row.report_content}</td>
                                <td>
                                    <button class="operation-btn">Delete</button>
                                    <button class="operation-btn">Restrict</button>
                                    <button class="operation-btn">View</button>
                                </td>
                            </tr>
                        `;
                    });

                    let count = totalRow / 20;
                    console.log(count);
                    $("#pagination-count")[0].innerHTML = "";
                    for (let c = 1; c <= Math.ceil(count); c++) {
                        $("#pagination-count")[0].innerHTML +=
                            `
                        <button class="pagination-btn ${ (id==c)?'active-page':''}" onclick="getRestrictedUsers(${c})"" >${c}</button>
                    `;
                    }
                } else {
                    $("#users-data")[0].innerHTML +=
                        `
                            <tr>
                                <td style="background-color: #5aaa" colspan="4">No records found</td>
                            </tr>
                    `;
                }
            }
        })
    }

    function getReportedUsers(id) {
        $("#users-data")[0].innerHTML = "";
        console.log(id);


        $("#record-table").css({
            'display': ''
        });
        // ALEN : FETCH REPORTED USERS
        $.ajax({
            url: "./api/report.php",
            type: "POST",
            data: {
                reportType: "user",
                page: id,
            },
            success: (result) => {
                $("#table-mode")[0].innerText = "Reported Users";
                let resultObj = JSON.parse(result);
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
                                <td>${row.uid}</td>
                                <td>${row.fname} ${row.lname}</td>
                                <td>${row.report_content}</td>
                                <td>
                                    <button class="operation-btn">Delete</button>
                                    <button class="operation-btn">Restrict</button>
                                    <button class="operation-btn">View</button>
                                </td>
                            </tr>
                    `;
                    });

                    let count = totalRow / 20;
                    $("#pagination-count")[0].innerHTML = "";
                    for (let c = 1; c <= Math.ceil(count); c++) {
                        $("#pagination-count")[0].innerHTML +=
                            `
                        <button class="pagination-btn ${ (id==c)?'active-page':''}" onclick="getReportedUsers(${c})"">${c}</button>
                    `;
                    }
                } else {
                    $("#users-data")[0].innerHTML +=
                        `
                            <tr>
                                <td style="background-color: #5aaa" colspan="4">No records found</td>
                            </tr>
                    `;
                }

            }
        })
    }



    $(".showReportedUsers").click(() => {
        getReportedUsers(1);
    })
    $(".showRestrictedUsers").click(() => {
        getRestrictedUsers(1);
    })
</script>

</html>