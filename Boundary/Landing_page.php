<?php
	session_start();
	if(isset($_GET['logout']))
		session_destroy();
?>
<!DOCTYPE html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<html lang="en">
	<head>
		<title>Home</title>
		<meta charset="utf-8">
		<meta name="format-detection" content="telephone=no" />
		<link rel="icon" href="images/favicon.ico">
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" media="screen" href="css/ie.css">
	</head>
	<!-- <body class="page1" id="top"> -->
<!--==============================header=================================-->
		<header><div class="container_12"><div class="grid_12">
					<h1>
						<img src="images/logo.png" alt="Let'sGardenSG" height="317" width="296" style = "margin-top:0;">
					</h1>
					<!-- <div class = "slogan">glorify the nature around you</div> -->
				</div></div></header>
<!--==============================Content=================================-->
        <br>
		<div class="content">
			<br>
			<div class="ic"></div>
			<div class="container_12">
				<div class="grid_4">
					<div class="block1">
						<div class="img_block">
							<img src="images/gardening-icon3.png" style = "border:none;" alt="" class="img_inner">
							<!-- <span class="l"></span>
							<span class="ll"></span>
							<span class="r"></span>
							<span class="rr"></span>
							<span class="lb"></span>
							<span class="llb"></span>
							<span class="rb"></span>
							<span class="rrb"></span> -->
						</div>
						<div class="text1">Learn More about growing plants</div><br>
						<form action="searchGardenResources.php">
						<button type = "submit" class = "btn btn-primary" style = "background-color:green; border:none;">Search for plants</button>
						</form></div>
					</div>
					<div class="grid_4">
					<div class="block1">
						<div class="img_block">
							<img src="images/gardening-icon1.png" alt="" style = "border:none;" class="img_inner">
							<!-- <span class="l"></span>
							<span class="ll"></span>
							<span class="r"></span>
							<span class="rr"></span>
							<span class="lb"></span>
							<span class="llb"></span>
							<span class="rb"></span>
							<span class="rrb"></span> -->
						</div>
						<div class="text1">Help out in a garden near you</div><br>
						<form action="LoginUI.php">
						<button type = "submit" class = "btn btn-primary" style = "background-color:green; border:none;">Register/Login</button>
						</form></div>
					</div>
					<div class="grid_4">
					<div class="block1">
						<div class="img_block">
							<img src="images/gardening-icon2.png" alt="" style = "border:none;" class="img_inner">
							<!-- <span class="l"></span>
							<span class="ll"></span>
							<span class="r"></span>
							<span class="rr"></span>
							<span class="lb"></span>
							<span class="llb"></span>
							<span class="rb"></span>
							<span class="rrb"></span> -->
						</div>
						<div class="text1">Check out the gardens near you</div><br>
						<form action="Gardens.php">
						<button type = "submit" class = "btn btn-primary" style = "background-color:green; border:none;">Search for Gardens</button>
						</form></div>
					</div>
				<div class="clear"></div>
				<div class="grid_8">
</div></div><br><br>
<!--==============================footer=================================-->
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