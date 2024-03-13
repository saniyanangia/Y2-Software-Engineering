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
<body>
<div class="content"><div class="ic"></div>
    <div class="container_12">
    <div class="form-group row">
        <?php
            if(isset($_POST['confirm_password'])){
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                if ( $password != $password2){
                    echo "<br><div class ='alert alert-danger' role='alert'>";
                    echo "<strong>The entered passwords do not match.</strong><br>";
                    echo "</div>";
                }
                else{
                    $val = validatePassword($_SESSION['ID'],$_SESSION['Type'],$password);
                    if ($val == 0){
                        echo "<br><div class ='alert alert-danger' role='alert'>";
                        echo "<strong>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</strong><br>";
                        echo "</div>";
                    }
                    else{
                        echo "<br><div class ='alert alert-success' role='alert'>";
                        echo "<strong>Password successfully changed!</strong><br>";
                        echo "</div>";
                    }
                }

            }
        ?>
        </div>  
        <h4>
        <form method = "POST", action = ""> 
            <div class="form-group row"> 
            <p style="font-size:24pt;">Enter New Password</p>   
            Enter a new password. Password guidelines are as follows:
            <br>
            <ul>
            <li>Password must be at least 8 characters in length.</li>
            <li>Password must include at least one upper case letter.</li>
            <li>Password must include at least one number.</li>
            <li>Password must include at least one special character.</li>
            </ul>
            </div>
            <div class="form-group row">
            Password:<input type= "password" name = "password" required>
            </div>
            <br>
            <div class="form-group row">
            Re-Enter Password: <input type="password" name = "password2" required>
            </div>
            <br>
            <div class="form-group row">
            <button type = "submit" name = "confirm_password">Confirm Password</button>
            </div>
        </form>
        <br>
        <form method = "POST", action = "Volunteer_main.php">
            <div class="form-group row">  
                <button type = "submit" name = "done">Return To Main Page</button>
            </div> 
        </form>
        </h4>
    </div>
</body>

<html>