<?php
    require_once 'ScheduleUI.php';

    session_start();
    $gardenID = $_SESSION['ID'];
    if(!$gardenID)
        echo "Error: GardenID not found.";

    $scheduleUI = new ScheduleUI();

    $sessionID = $_GET['sessionID'] ?? null;
    if(!$sessionID){
        header('Location: Admin_timeTable.php');
        exit;
    }

    $session = ScheduleUI::retrieveSessionBySessionID($sessionID);

    $date = $session['date'];
    $startTime = $session['startTime'];
    $endTime = $session['endTime'];
    $activity = $session['activity'];
    $maxSlots = $session['maxSlots'];

    if($session['date'] < date("Y-m-d")){
        echo "<script> alert('Past sessions cannot be edited.');
              window.location.href='Admin_timetable.php'; </script>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $date = $_POST['date'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $activity = $_POST['activity'];
        $maxSlots = $_POST['maxSlots'];

        $errors = ScheduleUI::verifyInputDetails($date, $startTime, $endTime, $activity, $maxSlots);
        if(empty($errors)){            
            $scheduleUI->editSession($sessionID, $date, $startTime, $endTime, $activity, $maxSlots);
            echo "<script> alert('Session updated successfully!');
                window.location.href='Admin_timetable.php'; </script>";
        }
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ceate New Session</title>
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
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
   
  <!-- Import boundary class  -->
  <?php require_once "ScheduleUI.php" ?>

</head>
<body id="top">
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
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
            <li><a href="Volunteer_main.html">Switch Account</a></li>
            <li class="current"><a href="Admin_timetable.html">Timetable</a></li>
            <li><a href="Gardens.html">Gardens</a></li>
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
    <a style="font-size: 30px">Edit Session <?php echo $sessionID; ?>:</a><br>
    <a style="font-size: 30px">Garden ID: <?php echo $gardenID; ?></a>
    <br>

    <!-- Print input errors -->
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo $error; ?></div>
            <?php  endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" onSubmit="return confirm('Confirm editing this session?')">
      <label for="birthday">Date:</label>
      <input type="date" id="birthday" name="date" value="<?php echo $date ?>">
    <br>
    <br>
      <label for="appt">Start Time:</label>
      <input type="time" id="appt" name="startTime" value="<?php echo $startTime ?>">
    <br>
    <br>
      <label for="appt1">End Time:</label>
      <input type="time" id="appt1" name="endTime" value="<?php echo $endTime ?>">
    <br>
    <br>
    <div class="input-group input-group-sm" style="width:800px">
      <span class="input-group-addon" id="sizing-addon3" style="width:70px">Activity</span>
      <input type="text" class="form-control" placeholder="Gardening activity" value="<?php echo $activity ?>" aria-describedby="sizing-addon3" name="activity">
    </div><br>
    <div class="input-group input-group-sm" style="width:800px">
      <span class="input-group-addon" id="sizing-addon3" style="width:70px">Max slots</span>
      <input type="text" class="form-control" placeholder="Max number of volunteers" value="<?php echo $maxSlots ?>" aria-describedby="sizing-addon3" name="maxSlots">
    </div>
    </table>
    <br>
    <br>
    <br>
    <button type="button"style="margin-left: 0px"><a href="Admin_timetable.php">Back</a></button>
    <button type="submit" style="margin-left: 650px">Confirm</button>
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
