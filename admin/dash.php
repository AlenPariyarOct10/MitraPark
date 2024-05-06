<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap");

        /*  styling scrollbars  */
        ::-webkit-scrollbar {
            width: 5px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px #a5aaad;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #3ea175;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a5aaad;
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            box-sizing: border-box;
            font-family: "Lato", sans-serif;
        }

        .text-primary-p {
            color: #a5aaad;
            font-size: 14px;
            font-weight: 700;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-title {
            color: #2e4a66;
        }

        .text-lightblue {
            color: #469cac;
        }

        .text-red {
            color: #cc3d38;
        }

        .text-yellow {
            color: #a98921;
        }

        .text-green {
            color: #3b9668;
        }

        .container {
            display: grid;
            height: 100vh;
            grid-template-columns: 0.8fr 1fr 1fr 1fr;
            grid-template-rows: 0.2fr 3fr;
            grid-template-areas:
                "sidebar nav nav nav"
                "sidebar main main main";
            /* grid-gap: 0.2rem; */
        }

        .navbar {
            background: #ffffff;
            grid-area: nav;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px 0 30px;
            border-bottom: 1px solid lightgray;
        }

        .nav_icon {
            display: none;
        }

        .nav_icon>i {
            font-size: 26px;
            color: #a5aaad;
        }

        .navbar__left>a {
            margin-right: 30px;
            text-decoration: none;
            color: #a5aaad;
            font-size: 15px;
            font-weight: 700;
        }

        .navbar__left .active_link {
            color: #265acc;
            border-bottom: 3px solid #265acc;
            padding-bottom: 12px;
        }

        .navbar__right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar__right>a {
            margin-left: 20px;
            text-decoration: none;
        }

        .navbar__right>a>i {
            color: #a5aaad;
            font-size: 16px;
            border-radius: 50px;
            background: #ffffff;
            box-shadow: 2px 2px 5px #d9d9d9, -2px -2px 5px #ffffff;
            padding: 7px;
        }

        main {
            background: #f3f4f6;
            grid-area: main;
            overflow-y: auto;
        }

        .main__container {
            padding: 20px 35px;
        }

        .main__title {
            display: flex;
            align-items: center;
        }

        .main__title>img {
            max-height: 100px;
            object-fit: contain;
            margin-right: 20px;
        }

        .main__greeting>h1 {
            font-size: 24px;
            color: #2e4a66;
            margin-bottom: 5px;
        }

        .main__greeting>p {
            font-size: 14px;
            font-weight: 700;
            color: #a5aaad;
        }

        .main__cards {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            height: 70px;
            padding: 25px;
            border-radius: 5px;
            background: #ffffff;
            box-shadow: 5px 5px 13px #ededed, -5px -5px 13px #ffffff;
        }

        .card_inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card_inner>span {
            font-size: 25px;
        }

        .charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 50px;
        }

        .charts__left {
            padding: 25px;
            border-radius: 5px;
            background: #ffffff;
            box-shadow: 5px 5px 13px #ededed, -5px -5px 13px #ffffff;
        }

        .charts__left__title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .charts__left__title>div>h1 {
            font-size: 24px;
            color: #2e4a66;
            margin-bottom: 5px;
        }

        .charts__left__title>div>p {
            font-size: 14px;
            font-weight: 700;
            color: #a5aaad;
        }

        .charts__left__title>i {
            color: #ffffff;
            font-size: 20px;
            background: #ffc100;
            border-radius: 200px 0px 200px 200px;
            -moz-border-radius: 200px 0px 200px 200px;
            -webkit-border-radius: 200px 0px 200px 200px;
            border: 0px solid #000000;
            padding: 15px;
        }

        .charts__right {
            padding: 25px;
            border-radius: 5px;
            background: #ffffff;
            box-shadow: 5px 5px 13px #ededed, -5px -5px 13px #ffffff;
        }

        .charts__right__title {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .charts__right__title>div>h1 {
            font-size: 24px;
            color: #2e4a66;
            margin-bottom: 5px;
        }

        .charts__right__title>div>p {
            font-size: 14px;
            font-weight: 700;
            color: #a5aaad;
        }

        .charts__right__title>i {
            color: #ffffff;
            font-size: 20px;
            background: #39447a;
            border-radius: 200px 0px 200px 200px;
            -moz-border-radius: 200px 0px 200px 200px;
            -webkit-border-radius: 200px 0px 200px 200px;
            border: 0px solid #000000;
            padding: 15px;
        }

        .charts__right__cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .card1 {
            background: #d1ecf1;
            color: #35a4ba;
            text-align: center;
            padding: 25px;
            border-radius: 5px;
            font-size: 14px;
        }

        .card2 {
            background: #d2f9ee;
            color: #38e1b0;
            text-align: center;
            padding: 25px;
            border-radius: 5px;
            font-size: 14px;
        }

        .card3 {
            background: #d6d8d9;
            color: #3a3e41;
            text-align: center;
            padding: 25px;
            border-radius: 5px;
            font-size: 14px;
        }

        .card4 {
            background: #fddcdf;
            color: #f65a6f;
            text-align: center;
            padding: 25px;
            border-radius: 5px;
            font-size: 14px;
        }

        /*  SIDEBAR STARTS HERE  */

        #sidebar {
            background: #020509;
            grid-area: sidebar;
            overflow-y: auto;
            padding: 20px;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
        }

        .sidebar__title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #f3f4f6;
            margin-bottom: 30px;
            /* color: #E85B6B; */
        }

        .sidebar__img {
            display: flex;
            align-items: center;
        }

        .sidebar__title>div>img {
            width: 75px;
            object-fit: contain;
        }

        .sidebar__title>div>h1 {
            font-size: 18px;
            display: inline;
        }

        .sidebar__title>i {
            font-size: 18px;
            display: none;
        }

        .sidebar__menu>h2 {
            color: #3ea175;
            font-size: 16px;
            margin-top: 15px;
            margin-bottom: 5px;
            padding: 0 10px;
            font-weight: 700;
        }

        .sidebar__link {
            color: #f3f4f6;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 5px;
        }

        .active_menu_link {
            background: rgba(62, 161, 117, 0.3);
            color: #3ea175;
        }

        .active_menu_link a {
            color: #3ea175 !important;
        }

        .sidebar__link>a {
            text-decoration: none;
            color: #a5aaad;
            font-weight: 700;
        }

        .sidebar__link>i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar__logout {
            margin-top: 20px;
            padding: 10px;
            color: #e65061;
        }

        .sidebar__logout>a {
            text-decoration: none;
            color: #e65061;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sidebar__logout>i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar_responsive {
            display: inline !important;
            z-index: 9999 !important;
            left: 0 !important;
            position: absolute;
        }

        @media only screen and (max-width: 978px) {
            .container {
                grid-template-columns: 1fr;
                /* grid-template-rows: 0.2fr 2.2fr; */
                grid-template-rows: 0.2fr 3fr;
                grid-template-areas:
                    "nav"
                    "main";
            }

            #sidebar {
                display: none;
            }

            .sidebar__title>i {
                display: inline;
            }

            .nav_icon {
                display: inline;
            }
        }

        @media only screen and (max-width: 855px) {
            .main__cards {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 0;
            }

            .charts {
                grid-template-columns: 1fr;
                margin-top: 30px;
            }
        }

        @media only screen and (max-width: 480px) {
            .navbar__left {
                display: none;
            }
        }
    </style>
    <title>CSS GRID DASHBOARD</title>
</head>

<body id="body">
    <div class="container">
    

        <main>
            <div class="main__container">
                <!-- MAIN TITLE STARTS HERE -->

                <div class="main__title">
                    <img src="assets/hello.svg" alt="" />
                    <div class="main__greeting">
                        <h1>Hello Codersbite</h1>
                        <p>Welcome to your admin dashboard</p>
                    </div>
                </div>

                <!-- MAIN TITLE ENDS HERE -->

                <!-- MAIN CARDS STARTS HERE -->
                <div class="main__cards">
                    <div class="card">
                        <i class="fa fa-user-o fa-2x text-lightblue" aria-hidden="true"></i>
                        <div class="card_inner">
                            <p class="text-primary-p">Number of Subscribers</p>
                            <span class="font-bold text-title">578</span>
                        </div>
                    </div>

                    <div class="card">
                        <i class="fa fa-calendar fa-2x text-red" aria-hidden="true"></i>
                        <div class="card_inner">
                            <p class="text-primary-p">Times of Watching</p>
                            <span class="font-bold text-title">2467</span>
                        </div>
                    </div>

                    <div class="card">
                        <i class="fa fa-video-camera fa-2x text-yellow" aria-hidden="true"></i>
                        <div class="card_inner">
                            <p class="text-primary-p">Number of Videos</p>
                            <span class="font-bold text-title">340</span>
                        </div>
                    </div>

                    <div class="card">
                        <i class="fa fa-thumbs-up fa-2x text-green" aria-hidden="true"></i>
                        <div class="card_inner">
                            <p class="text-primary-p">Number of Likes</p>
                            <span class="font-bold text-title">645</span>
                        </div>
                    </div>
                </div>
                <!-- MAIN CARDS ENDS HERE -->

                <!-- CHARTS STARTS HERE -->
                <div class="charts">
                    <div class="charts__left">
                        <div class="charts__left__title">
                            <div>
                                <h1>Daily Reports</h1>
                                <p>Cupertino, California, USA</p>
                            </div>
                            <i class="fa fa-usd" aria-hidden="true"></i>
                        </div>
                        <div id="apex1"></div>
                    </div>

                    <div class="charts__right">
                        <div class="charts__right__title">
                            <div>
                                <h1>Stats Reports</h1>
                                <p>Cupertino, California, USA</p>
                            </div>
                            <i class="fa fa-usd" aria-hidden="true"></i>
                        </div>

                        <div class="charts__right__cards">
                            <div class="card1">
                                <h1>Income</h1>
                                <p>$75,300</p>
                            </div>

                            <div class="card2">
                                <h1>Sales</h1>
                                <p>$124,200</p>
                            </div>

                            <div class="card3">
                                <h1>Users</h1>
                                <p>3900</p>
                            </div>

                            <div class="card4">
                                <h1>Orders</h1>
                                <p>1881</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CHARTS ENDS HERE -->
            </div>
        </main>

        <div id="sidebar">
            <div class="sidebar__title">
                <div class="sidebar__img">
                    <img src="assets/logo.png" alt="logo" />
                    <h1>Codersbite</h1>
                </div>
                <i onclick="closeSidebar()" class="fa fa-times" id="sidebarIcon" aria-hidden="true"></i>
            </div>

            <div class="sidebar__menu">
                <div class="sidebar__link active_menu_link">
                    <i class="fa fa-home"></i>
                    <a href="#">Dashboard</a>
                </div>
                <h2>MNG</h2>
                <div class="sidebar__link">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <a href="#">Admin Management</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-building-o"></i>
                    <a href="#">Company Management</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-wrench"></i>
                    <a href="#">Employee Management</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-archive"></i>
                    <a href="#">Warehouse</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-handshake-o"></i>
                    <a href="#">Contracts</a>
                </div>
                <h2>LEAVE</h2>
                <div class="sidebar__link">
                    <i class="fa fa-question"></i>
                    <a href="#">Requests</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-sign-out"></i>
                    <a href="#">Leave Policy</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-calendar-check-o"></i>
                    <a href="#">Special Days</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-files-o"></i>
                    <a href="#">Apply for leave</a>
                </div>
                <h2>PAYROLL</h2>
                <div class="sidebar__link">
                    <i class="fa fa-money"></i>
                    <a href="#">Payroll</a>
                </div>
                <div class="sidebar__link">
                    <i class="fa fa-briefcase"></i>
                    <a href="#">Paygrade</a>
                </div>
                <div class="sidebar__logout">
                    <i class="fa fa-power-off"></i>
                    <a href="#">Log out</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // This is for able to see chart. We are using Apex Chart. U can check the documentation of Apex Charts too..
        var options = {
            series: [{
                    name: "Users",
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
                },
                {
                    name: "Posts",
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
                },
                {
                    name: "Free Cash Flow",
                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
                },
            ],
            chart: {
                type: "bar",
                height: 250, // make this 250
                sparkline: {
                    enabled: true, // make this true
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["transparent"],
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            },
            yaxis: {
                title: {
                    text: "$ (thousands)",
                },
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands";
                    },
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex1"), options);
        chart.render();

        // Sidebar Toggle Codes;

        var sidebarOpen = false;
        var sidebar = document.getElementById("sidebar");
        var sidebarCloseIcon = document.getElementById("sidebarIcon");

        function toggleSidebar() {
            if (!sidebarOpen) {
                sidebar.classList.add("sidebar_responsive");
                sidebarOpen = true;
            }
        }

        function closeSidebar() {
            if (sidebarOpen) {
                sidebar.classList.remove("sidebar_responsive");
                sidebarOpen = false;
            }
        }
    </script>
</body>

</html>