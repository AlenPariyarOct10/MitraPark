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
            font-family: 'poppins';
            font-size: 28px;
            font-weight: normal;
        }

        .body {
            display: flex;
            background-color: #f2f2f2;
            height: 100%;

        }

        .inner-body{
            margin-top:25px;
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
            margin: 5px;
            cursor: pointer;

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

        /* ALEN : Content Space -----------------------*/
        .body{
            position: relative;
        }

        .wrapper{
            position: absolute;
            background-color: #295fff5e;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            display: none;
        }

        .modal{
            background-color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            width: 50%;
            position: relative;

        }

        /* Update Modal Style */
        input[type=text]{
            width: 50%;
        }

        form{
            width: 100%;
        }

        .form-item{
            display: flex;
            justify-content: space-between;
            margin: 5px;
        }

        .form-item label{
            font-size: large;
        }

        tr{
            padding: 5px;
        }
        tr:nth-child(odd){
            background-color: rgb(228, 228, 228);
        }

        input[type=submit], button{
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #6088ff;
            font-size: medium;
            color: white;
        }

        

        input[type=submit]:hover, button:hover{
            background-color: #49b6ff;
        }

        .bg-red{
            background-color: #FF204E;
        }

        #changeLogoLabel{
            font-size: small;
            background-color: #6088ff;
            cursor: pointer;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        #changeLogoLabel:hover{
            background-color: #49b6ff;
        }

        .modal-close{
            position: absolute;
            top: 0;
            right: 0;
            background-color: #FF204E;
            padding: 8px;
            cursor: pointer;
        }

        .modal-close:hover{
            background-color: red;
        }


        .inner-header{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .label-success{
            font-size: medium;
            background-color: #5fffbf;
            padding: 10px;
            border-left: 4px solid #00b96f;
        }
        .label-success{
            font-size: medium;
            background-color: #5fffbf;
            padding: 10px;
            border-left: 4px solid #00b96f;
        }
        .label-fail{
            font-size: medium;
            background-color: #ff9999;
            padding: 10px;
            border-left: 4px solid #b90000;
        }
    </style>
</head>

<body>

    <div class="body">
        <!-- Modal Wrapper -->
    <div class="wrapper">
        <div class="modal">
            <span class="modal-close">x</span>
            <form action="updateSystemInfo.php" method="POST" enctype="multipart/form-data">
            <div class="modal-head">
                <p class="modal-title">Update System Info</p>
            </div>
            <hr>
            <div class="modal-body">
                <div class="form-item">
                    <label for="system_name">Name :</label>
                    <input type="text" name="system_name" id="form-system_name" required>
                </div>
                <div class="form-item">
                    <label for="system_name">Description :</label>
                    <input type="text" name="system_description" id="form-system_description" required>
                </div>
                <div class="form-item">
                    <label for="system_name">Maintenance Mode :</label>
                    <label for="maintenance_on">On</label>
                    <input type="radio" name="maintainance_mode" value='1' id="maintenance_on">
                    <label for="maintenance_off">Off</label>
                    <input type="radio" name="maintainance_mode" value='0' id="maintenance_off">
                    <!-- <input name="maintenance_mode" value=0 type="button" id="maintenance_mode">Turn On</input> -->
                </div>
                <div class="form-item">
                    <label>System Logo :</label>
                    <input style="display: none;" type="file" name="logo_img" id="form_logo_img">
                    <label id="changeLogoLabel" for="form_logo_img">
                        Change Logo
                    </label>
                </div>
                <div class="form-item">
                    <div style="width: 100%">
                    <label for="system_name">System Color Theme :</label>
                    <table>
                        <tr>
                            <td>Primary Color</td>
                            <td>Secondary Color</td>
                            <td>Background Color</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="color" class="colorSelector" name="primaryColor" id="form_primaryColor">
                            </td>
                            <td>
                                <input type="color" class="colorSelector" name="secondaryColor" id="form_secondaryColor">
                            </td>
                            <td>
                                <input type="color" class="colorSelector" name="bgColor" id="form_bgColor">
                            </td>
                        </tr>
                    </table>
                    </div>
                    

                </div>
            </div>
            <input type="submit" value="Save">
            </form>
        </div>
    </div>
    <?php include_once("./parts/sidebar.php") ?>

        <div class="content">
            <div class="inner-header">
                <p>System ~ <?php echo $aboutSite['system_name']; ?> </p>
                <div><button id="updateSystemBtn">Update System Info</button></div>
            </div>
            <div class="inner-body">
            <?php 
                if(isset($_GET['updateSuccess']))
                {
                    echo '
                    <div class="label-success">
                    System info updated succesfully
                </div>
                    ';
                }
                if(isset($_GET['updateFailed']))
                {
                    echo '
                    <div class="label-fail">
                    Unable to update system into
                </div>
                    ';
                }

            ?>
                
                <div class="inner-body-section">
                    <!-- ALEN : CARD -->
                    <div class="card-grid">
                        <div class="card" data-mode="changeName">
                            <div class="card-row">
                                <p class="lite-dim">System Name</p>
                            </div>
                            <div class="card-row">
                                <p id="systemName"></p>
                            </div>
                          
                        </div>
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">System Logo</p>
                            </div>
                            <div class="card-row">
                                <img id="system_logo" src="." alt="">
                            </div>
                            
                        </div>
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">Maintenance Mode</p>
                            </div>
                            <div class="card-row">
                                <p id="maintenanceMode">Off</p>
                            </div>
                            <div class="card-row">
                            
                                <span class="icon-cover bg-red">
                                  
                                </span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">System Color </p>
                            </div>
                            <div class="card-row">
                                <div style="display: flex;">
                                    <div style="height: 30px;width: 30px; background-color: red;margin:2px;" id="showPrimaryColor" class="color-box"></div>
                                    <div style="height: 30px;width: 30px; background-color: red;margin:2px;" id="showSecondaryColor" class="color-box"></div>
                                    <div style="height: 30px;width: 30px; background-color: red;margin:2px;" id="showBgColor" class="color-box"></div>
                                </div>

                            </div>
                            
                        </div>
                        <div class="card">
                            <div class="card-row">
                                <p class="lite-dim">System description</p>
                            </div>
                            <div class="card-row">
                                <p id="system_description"></p>
                            </div>
                        
                        </div>
                       
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
<script src="../assets/scripts/jquery.js"></script>
<script>
    // ALEN : Update Modal Button -> Show Modal
    $("#updateSystemBtn").click(()=>{
        $(".wrapper").css({"display":"flex"});
    })

    // ALEN : Hide Modal
    $(".modal-close").click(()=>{
        $(".wrapper").css({"display":"none"});
    })

    // ALEN : Modal Data Load
    $(document).ready(()=>{
        $.ajax({
        url: "./api/systemInfo.php",
        type: "POST",
        data: {
            mode : "getSystemInfo"
        },
        success: (response)=>{
            // console.log(response);
            let responseObj = JSON.parse(response);
            // console.log(responseObj);
        
            $("#form-system_name")[0].value =responseObj.system_name;
            $("#form-system_description")[0].value =responseObj.system_description;
          
            if(responseObj.maintenance_mode==1)
            {
                $("#maintenance_on")[0].checked = true;
                $("#maintenance_off")[0].checked = false;

            }else{
                $("#maintenance_on")[0].checked = false;
                $("#maintenance_off")[0].checked = true;


            }
 
            let responseColorObj =JSON.parse(responseObj.themeSpecification);
    
            $("#form_primaryColor").val(responseColorObj.primaryColor);
            $("#form_secondaryColor").val(responseColorObj.secondaryColor);
            $("#form_bgColor").val(responseColorObj.ThemeBgColor);
            $("#form_logo_img")[0].val(responseObj.system_logo);
        }
    }
    
    )


    $("#maintenance_mode").click((btn)=>{
        if(btn.target.innerText == "Turn Off")
        {
            btn.target.innerText = "Turn On";
            btn.target.style.backgroundColor = "#FA7070";
        }else{
            btn.target.innerText = "Turn Off";
            btn.target.style.backgroundColor = "#90D26D";
            
        }
    })

    })


    // ALEN : Color Selector Event
    $(".colorSelector").change((item)=>{
        // console.log(item.target.id);
        // console.log(item.target.value);

    })

    // ALEN : FETCH System Data
    $.ajax({
        url: "./api/systemInfo.php",
        type: "POST",
        data: {
            mode : "getSystemInfo"
        },
        success: (response)=>{
            // console.log(response);
            let responseObj = JSON.parse(response);
            // console.log(responseObj);
            // console.log($("#systemName").innerHTML);
            $("#systemName")[0].innerHTML = responseObj.system_name;
            $("#maintenanceMode")[0].innerHTML = (responseObj.maintenance_mode==1)?"On":"Off";
            $("#system_description")[0].innerHTML = responseObj.system_description;
            $("#system_logo")[0].src = ".."+responseObj.system_logo;
            $("#system_logo")[0].style.height = "60px";
            const colorTheme = JSON.parse(responseObj.themeSpecification);
            // console.log(colorTheme);

            $("#showPrimaryColor")[0].style.backgroundColor =colorTheme.primaryColor;
            $("#showSecondaryColor")[0].style.backgroundColor =colorTheme.secondaryColor;
            $("#showBgColor")[0].style.backgroundColor =colorTheme.ThemeBgColor;
        }
    })
    
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

  

</script>

</html>