<?php
    session_start();
    if(isset($_POST['SendRequest'])){
        $sessionID = $_POST['sessionID'];
        $gardenID = $_SESSION['gardenID'];
        if (!isset($_SESSION['ID'])){
            echo "<br><div class ='alert alert-danger' role='alert' style = 'font-size:18;>";
            echo "<strong>Looks like you're not logged in!</strong><br>";
            echo "Please Log In or Register for an account to book sessions!<br>";
            echo "<form method = 'POST', action = 'LoginUI.php'> <button type = 'submit' name = 'login'>Click here to Login</button></form><br>";
            echo "<form method = 'POST', action = 'RegistrationUI.php'> <button type = 'submit' name = 'register'>Click here to Register</button></form>";
            echo "</div>";
            //window.location.href="BookSessionUI.php";</script>';
        }
        else{
            if ($_SESSION['Type'] =='Admin'){
                echo "<br><div class ='alert alert-danger' role='alert' style = 'font-size:18;'>";
                echo "<strong>Looks like you're not a Volunteer!</strong><br>";
                echo "Only volunteer accounts can book sessions!<br>";
                echo "</div>";
            }
            else{
                $username = $_SESSION['ID'];
                echo '<script>alert("Request Sent!");
                    window.location.href="BookSessionUI.php";</script>';
                bookSession($gardenID, $sessionID, $username);
            }
        }
    }
    /**
     * availableSessions 
     * 
     * Prints out all the available sessions at a specific garden
     * Sessions are selected from Session database by passing in query with specific gardenID
     * 
     * @param String $gardenID     Garden ID of the garden to be viewed for sessions
     */
    function availableSessions($gardenID){
        include 'conn.php';
        $conn = OpenCon();
        
        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `session` WHERE gardenID like '$gardenID' AND filledSlots < maxSlots";
        $result = mysqli_query($conn,$query);
        
        
        while($row = mysqli_fetch_array($result)){
            echo "<table class='jumbotron' style='width: 800px; padding-top: 50px; padding-bottom: 0px; background-color: #eae6de; margin-left: 8%;'>";
            echo
            "<tr><td> <h1 style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'> Session ID: {$row['sessionID']} </h1></td>
            <td><form method='POST' action=''> <input name='sessionID' value='",$row["sessionID"],"' hidden><button type='submit' name='SendRequest' value='",$row["sessionID"],"' style='font-size: 15px; margin-top: 15px; margin-left:425px; ' class ='btn btn-success btn-lg' >Send Request </button/></form></td></tr>
            <tr><td> <p style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'>Garden ID: {$row["gardenID"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'>Activity: {$row["activity"]}</p> </td></tr>
            <tr><td><br></td></tr>
            <tr><td> <p style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'>Date: {$row["date"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'>StartTime: {$row["startTime"]} to {$row["endTime"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'>Slots Filled: {$row["filledSlots"]} / {$row["maxSlots"]}</p> </td></tr>";
            echo "</table>";
        }

        CloseCon($conn);
        return;
    }
    
    /**
     * bookSession
     * 
     * Creates a volunteer request for volunteering session and inserts it into the Request database
     * The volunteer request created will have a 'pending' status
     * 
     * @param String $gardenID     Garden ID of the garden organising the volunteering session
     * @param String $sessionID    Session ID of the volunteering session
     * @param String $username  Username of the volunteer booking the session
     */
    function bookSession($gardenID, $sessionID, $username){
        include 'conn.php';
        $conn = OpenCon();
        
        mysqli_select_db($conn,'database');
        $query =
        "INSERT INTO `request` (gardenID, sessionID, username, requestStatus)
        VALUES ('$gardenID', '$sessionID', '$username', 'pending')";
        
        $result = mysqli_query($conn,$query);
        
        while($row = mysqli_fetch_array($result)){
            availableSessions($gardenID);}
        
        CloseCon($conn);
        return;
    }
?>


