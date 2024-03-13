<?php 
    session_start();
    if(!isset($_SESSION['Type'])&&!isset($_SESSION['ID'])){
        echo "<script> location.href='Landing_page.php'; </script>";        
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Services</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <link rel="icon" href="images/favicon.ico">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" media="screen" href="css/ie.css">
</head>
<body id="top">
<!--==============================header=================================-->
<header>
    <div class="container_12">
        <div class="grid_12">
            <h1>
                <img src="images/logo.png" alt="Let'sGardenSG" height="317" width="296" style = "margin-top:0;">
                </a>
            </h1>
        </div>
    </div>
    <div class="clear"></div>
    <div class="menu_block ">
        <div class="container_12" >
            <div class="grid_12" style="margin-left: 13%">
                <nav class="horizontal-nav full-width horizontalNav-notprocessed">
                    <ul class="sf-menu">
                        <li><a href="Landing_page.php?logout=true">Logout</a></li>
                        <li><a href="Volunteer_main.php">Main Page</a></li>
                        <li><a href="Gardens.php">Gardens</a></li>
                    </ul>
                </nav>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</header>
<!--==============================Content=================================-->
<div class="content"><div class="ic"></div>
    <div class="container_12">
        <div class="grid_12">
            <h2>Main Information</h2>
        </div>
        <div class="grid_3">
            <div class="text1"><a href="volunteerProfileUI.php">My Contact Info</a></div>
            <br>View and edit your account information.
            <br>
        </div>
        <div class="grid_3">
            <div class="text1"><a href="ConfirmedSessionsUI.php">My Confirmed Sessions</a></div>
            <br>View your accepted requests and withdraw from accepted requests.
            <br>
        </div>
        <div class="grid_3">
            <div class="text1"><a href="RequestedSessionsUI.php">My Requested Sessions</a></div>
            <br>View your pending requests and withdraw from pending requests.
            <br>
        </div>
        <div class="grid_3">
<!--            defalut Garden 1-->
            <div class="text1"><a href="Gardens.php">Search for volunteering opportunities</a></div>
            <br>View gardens across Singapore and request to volunteer at gardens.
            <br>
        </div>
        <div class="clear cl1"></div>
        <div class="grid_12">
            <h2>Services</h2>
        </div>
        <div class="grid_4">
            <div class="text1"><a href="volunteerVerifyEmailUI.php">Change Password</a></div>
            <br> 
        </div>
        <div class="grid_4">
            <div class="text1"><a href="searchGardenResources.php">Search for Plant Resources</a></div>
            <br> Learn More about growing plants
        </div>

       <!-- <div class="grid_4">
           <div class="text1"><a href="#">Contact Admin</a></div>
           <br>
        </div> -->
    </div>

<br>
<br>
<div class="bottom_block" style="padding-bottom: 10px; background-color: #f3f2e9";>
    <div class="container_12">
        <div class="grid_8">
            <h2>About the Initiative</h2>
            <div class="grid_7">
                <div class="block2">
                    <div class="img_block ib1 fleft">
                        <img src="images/page2_img1.jpg" alt="" class="img_inner">
                        <span class="l"></span>
                        <span class="ll"></span>
                        <span class="r"></span>
                        <span class="rr"></span>
                        <span class="lb"></span>
                        <span class="llb"></span>
                        <span class="rb"></span>
                        <span class="rrb"></span>
                    </div>
                    <div class="extra_wrapper">
                        <div class="title" style="font-size: 23px">Grow A Garden with New Friends!</div>
                            <p style="text-align:justify"> In a one-of-its-kind partnership with NParks, Team Tehc brings to you a platform to connect participants under the Community Gardens national programme with gardening volunteers. Garden admins can curate sessions with specific gardening activities, and volunteers can choose to attend any session at a garden of their choice. Happy Gardening!</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid_4">
            <div class="extra_wrapper">
            <h2>Our Mission</h2><br>
            <blockquote class="bq1" style='text-align: center';>
                <p><q>Connecting gardening enthusiasts,<br> Fostering community bonds<q></p>
                <div class="bq_bot" style='text-align: left';>Team Tehc</div>
            </blockquote>
        </div>
    </div>
</div>
<!--==============================footer=================================-->
<footer>
    <div class="container_12">
        <div class="grid_12">
            <div class="copy">
                Nanyang Technological University <span id="copyright-year"></span>| CZ2006 | Team Tehc</a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</footer>
</body>
</html>