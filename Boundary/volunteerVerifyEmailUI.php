<?php session_start()?>
<?php require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/PasswordMgr.php'); ?>
<html lang="en">
<head>
    <title>Services</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <link rel="icon" href="images/favicon.ico">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" media="screen" href="css/ie.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> 
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
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<head>
</header>
</head>
<body>
<div class="content"><div class="ic"></div>
    <div class="container_12">
    <div class="form-group row">
        <?php
            if(isset($_POST['verify'])){
                $email = $_POST['email'];
                if ($_SESSION['Type'] == "Volunteer"){
                    $val  = validateVolunteerEmail($_SESSION['ID'],$email);
                }
                if($_SESSION['Type'] == "Admin"){
                    $val  = validateAdminEmail($_SESSION['ID'],$email);
                }
                if ($val == 1){
                    $link = 'volunteerChangePasswordUI.php';
                    echo "<br><div class ='alert alert-success' role='alert'>";
                    echo "<strong>Email Sent!</strong>";
                    echo "<br><a href='".$link."'>Email link</a>";
                    echo"</div>";
                }
                else{
                    echo "<br><div class ='alert alert-danger' role='alert'>";
                    echo "<strong> Invalid Email!</strong><br>";
                    echo "</div>";
                }
            }
        ?>
        <h4>
        </div>
        <form method = "POST", action = ""> 
            <div class="form-group row">
            <p style= "font-size:20pt;"> Change Password </p>
            <h4>Enter the Email Address associated with your account</h4>
                <h4>Email Address:</h4><input type= "email" name = "email" required>
            </div>
            <br>
            <div class="form-group row">
                <button type = "submit" name = "verify">Verify Email</button>
            </div>
        </form>
        <br>
        <form method = "POST", action = "Volunteer_main.php"> 
            <div class="form-group row">
                <button type = "submit" name = "return">Return To Main Page</button>
            </div>
        </form>
    </h4>
    </div></div>
</body>

<html>