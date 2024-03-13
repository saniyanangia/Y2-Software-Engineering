<?php
    session_start();
    $gardenID = $_SESSION['ID'];
    if(!$gardenID)
        echo "Error: GardenID not found.";

    require_once 'ScheduleUI.php';

    $scheduleUI = new ScheduleUI();

    $sessionID = $_GET['sessionID'] ?? null;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Services</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" media="screen" href="css/grid.css">
    <link rel="icon" href="images/favicon.ico">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" media="screen" href="css/ie.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous" >
    <!-- link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" -->

    <!-- Import boundary class  -->
    <?php require_once "ScheduleUI.php" ?>
    <?php $scheduleUI = new ScheduleUI(); ?>


</head>
<body id="top">
    <script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

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
                        <li class="current"><a href="">View Confirmed Volunteers</a></li>
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
  <div class="container_12" style = "font-family:'Marvel'" >
    <br>
    <a style="font-size: 30px">Garden ID: <?php echo $gardenID; ?></a>
    <br>
    <a style="font-size: 25px">Session ID: <?php echo $sessionID; ?></a>
    <br>

    <?php 
        ScheduleUI::displayVolunteer($gardenID, $sessionID);
    ?>

    <br>
    <button type="button" style="margin-left: 0px" onClick="self.close()">Close</button>
  </div>
</div>

<div class="bottom_block" style="padding-bottom: 10px; background-color: #f3f2e9";>
    <div class="container_12">
        <div class="grid_8">
            <h2>About the Initiative</h2><br>
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
                <p>Connecting gardening enthusiasts,<br> Fostering community bonds</p>
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
