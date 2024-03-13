<?php session_start()?>
<head>
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
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
                <img src="images/logo.png" alt="Let'sGardenSG" width="296" height="317" >
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
                        <li class="sf-menu"><a href="Volunteer_main.php">Main Page</a></li>
                        <li><a href="Gardens.php">Gardens</a></li>
                    </ul>
                </nav>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</header>
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
<body>
    <?php require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/ProfileMgr.php'); ?>
    <div class="content"><div class='ic'></div>
    <div class="container_12" style = "font-family:'Marvel'">
        <?php
        if(isset($_POST['confirm_edits'])){
            $username = $_POST["Username"];
            $email= $_POST["Email"];
            $number = $_POST["Number"];
            $preferred_contact = $_POST["Preferred_Contact"];
            $skills = $_POST["Skills"];
            $interests = $_POST["Interests"];
            $experiences = $_POST["Experiences"];
            $val  = validateVolunteerEdits($_SESSION['ID'],$username, $email, $number, $skills, $interests, $experiences,$preferred_contact);
            if (sizeof($val) == 0){
                $_SESSION['ID'] = $_POST["Username"];
                echo '<script type ="text/JavaScript">';  
                echo 'confirm("Changes Saved!")';  
                echo '</script>';  
                echo"<meta http-equiv='Refresh' content='0; url= EditVolunteerProfileUI.php?'>";
            }
            else{
                echo "<br><div class ='alert alert-danger' role='alert'>";
                echo "<strong> Invalid Edits!</strong><br>";
                foreach ($val as $error){
                    echo "<div><li>$error</li></div>";
                } 
                echo "</div>";
            }
        }
        ?>
        <h4>
        <?php $row = getProfileDetails($_SESSION['ID'],$_SESSION['Type']); ?> 
        <form method = "POST", action = ""> 
            <p style="font-size:24pt;">Edit Information</p>
            <p style="font-size:18pt;">Your current account information is as follows. Please edit the fields that you would like to change and press "Confirm Edits" to save your edited information.</p>
            <div class="form-group">    
            <strong>Username:</strong><br><input type="text" name = "Username" placeholder = "<?php echo $row['username'] ?>" value = "<?php echo $row['username'] ?>" required>
            <br><small class="form-text text-muted">Enter your unique Username.</small><br>
            </div>  
            <br> 

            <div class="form-group">
            <strong>Email Address:</strong><br><input type="email" name = "Email" placeholder = "<?php echo $row['emailAddress'] ?>" value = "<?php echo $row['emailAddress'] ?>" required>
            <br><small class="form-text text-muted">Enter a valid email address. An email address cannot be used for multiple accounts.</small><br>
            </div>
            <br>

            <div class="form-group">
            <strong>Contact Number:</strong><br><input type= "number" name = "Number" placeholder = "<?php echo $row['contactNumber'] ?>" value = "<?php echo $row['contactNumber'] ?>" required>
            <br><small class="form-text text-muted">Enter your contact number.</small><br>
            </div>
            <br>

            <div class="form-group">
            <h4><strong>Preferred Contact:</strong></h4>
            <input type="radio" id="PHONE" name="Preferred_Contact" value="PHONE" 
            <?php if ($row['preferredContact'] == "PHONE"){
                echo "checked = 'checked'";}
            ?> required>
            <label for="PHONE">PHONE</label><br>
            <input type="radio" id="EMAIL" name="Preferred_Contact" value="EMAIL" <?php if ($row['preferredContact'] == "EMAIL"){
                echo "checked = 'checked'";}
            ?> required>
            <label for="EMAIL">EMAIL</label><br>
            <small class="form-text text-muted">Enter your preferred contact. This contact information will be used for further communication with other users.</small><br>
            </div>
            <br>

            <div class="form-group">
            <strong>Skills:</strong><br><textarea name= "Skills" cols="40" rows="5" style = "vertical-align:middle" placeholder = "<?php echo $row['gardeningSkill'] ?>" required><?php echo $row['gardeningSkill']?></textarea>
            <br><small class="form-text text-muted">Elaborate on some gardening skills you might have. This information will be visible to garden owners.</small><br>
            </div>
            <br>

            <div class="form-group">
            <strong>Interests:</strong><br><textarea name= "Interests" cols="40" rows="5" style="vertical-align:middle" placeholder = "<?php echo $row['gardeningInterest'] ?>" required><?php echo $row['gardeningInterest']?></textarea>
            <br><small class="form-text text-muted">Elaborate on some gardening related interests you might have. This information will be visible to garden owners.</small><br>
            </div>
            <br>

            <div class="form-group">
            <strong>Experiences:</strong><br><textarea name= "Experiences" cols="40" rows="5" style="vertical-align:middle" placeholder = "<?php echo $row['gardeningExperience'] ?>" required><?php echo $row['gardeningExperience'] ?> </textarea>
            <br><small class="form-text text-muted">Elaborate on your gardening experiences. This information will be visible to garden owners.</small><br>
            </div>
            <br>
            <div class="form-group row">
            <button type = "submit" class ='btn btn-success btn-lg' name = "confirm_edits">Confirm Edits</button>
            </div>
        </form>
        <br>
        <form method = "POST", action = "volunteerProfileUI.php"> 
            <div class="form-group row">    
            <button type = "submit" class ='btn btn-success btn-lg' name = "return">Return To Profile Page</button>
            </div>
        </form>
        </h4>
    </div></div>
</body>
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
</html>