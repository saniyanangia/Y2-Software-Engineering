<?php session_start()?>
<?php require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/SearchMgr.php'); ?>
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
    <div class="content"><div class='ic'></div>
    <div class="container_12">
        <h4>
        <form method = "POST", action = ""> 
        <div class="form-group" style = 'text-align:center'>
        <br>
        <p style= "font-size:24pt;">Search Garden Resources </p>
            <h4>Search for information about plants and how to grow them!</h4>
            <div class="form-group" style = 'text-align:center;'>
            <input type= "search" name = "searchInput" size = 50>
            <button type = "submit" name = "searchButton" class = "btn btn-success btn-lg">Search</button> 
            <button type = "submit" name = "return" class = "btn btn-success btn-lg">Return</button>
            </div>
            <?php 
            if(isset($_POST['return']) && $_SESSION['ID'] == NULL){
                echo "<meta http-equiv='Refresh' content='0; url= Landing_page.php'>";
            }
            if(isset($_POST['return']) && $_SESSION['ID'] != NULL){
                if ( $_SESSION['Type'] == "Volunteer"){
                    echo "<meta http-equiv='Refresh' content='0; url= Volunteer_main.php'>";
                }
                else{
                    echo "<meta http-equiv='Refresh' content='0; url= Admin_main.php'>";
                }
            }
            ?>
        </form>
        </form>
        <?php
            if(isset($_POST['searchButton'])){
                $searchInput = $_POST['searchInput'];
                $row = searchResources($searchInput);
                if (($row) != NULL){
                    echo "<div style = 'text-align:center'>";
                    echo "<h3>You searched for: $searchInput</h3>";
                    echo "<img src= '".$row['mainImagepath']."' alt= 'Oops! This image does not exist!'>";
                    echo "</div>";
                    echo "<table class = 'table table-bordered' style = 'width: 1000px'>";
                    echo "<tr><td> Name: </td><td>". $row['plantName'] . "</td></tr><tr><td> Description: </td><td>" . $row['description'] . "</td></tr>";
                    if ($row['sunRequirements'] == "Full Sun"){
                        echo "<tr><td>Sun Requirements:</td><td>".$row['sunRequirements']."<br> &#127774 &#127774 &#127774 </td></tr>"; 
                    }
                    else if ($row['sunRequirements'] == "Partial Sun"){
                        echo "<tr><td>Sun Requirements:</td><td>".$row['sunRequirements']."<br> &#127774 &#127774</td></tr>"; 
                    }
                    echo "<tr><td> Sowing Method : </td><td>". $row['sowingMethod']."</td></tr><tr><td> Spread: </td><td>" . $row['spread'] . "</td></tr><tr><td> Row Spacing: </td><td>". $row['rowSpacing'] . "</td></tr><tr><td> Height: </td><td>". $row['height'] . "</td></tr><tr><td> Type: </td><td>Crops</td></tr>";
                }
                else{
                    echo "<br><div class ='form group row'>";
                    echo "<strong> Could not find any search results</strong><br>";
                    echo "</div>";
                }
            }
        ?>
        <br>
        </h4>
    </div></div>
</body>