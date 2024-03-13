<?php
    
    if(isset($_POST['Withdraw'])){
        $sessionID = $_POST['sessionID'];
        $username = $_SESSION['ID'];

        echo '<script>alert("Withdrawn from Session");
            window.location.href="ConfirmedSessionsUI.php";</script>';
        WithdrawConfirmedSession($sessionID, $username);
    }
        
    /**
     * DisplayConfirmedSessions
     * Takes in a unique Volunteer ID to search through the request database and the session database for any confirmed sessions. 
     * Prints out any confirmed sessions in a table format.
     * 
     * @param  String $username unique ID for a Volunteer user
     * @return void
     */
    function DisplayConfirmedSessions($username){
        include 'conn.php';
        $conn = OpenCon();
        
        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `request`
                    INNER JOIN `session` ON `request`.sessionID = `session`.sessionID
                    WHERE username like '$username'
                    AND requestStatus like 'approved'";
        
        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) == 0){
            echo "<strong><div style = 'text-align:center'>No sessions approved yet!</strong></div>";
        }
        echo "<table class='jumbotron' style='width: 800px; padding-top: 0px; padding-bottom: 0px; background-color: #eae6de; margin-left: 8%;'>";
        
        while($row = mysqli_fetch_array($result)){
            echo
            "<tr><td> <h1 style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'> Session ID: {$row['sessionID']} </h1></td>
            <td><form method='POST' action=''> <input name='sessionID' value='",$row["sessionID"],"' hidden>
            <button type='submit' name='Withdraw' value='",$row["sessionID"],"' style='font-size: 20px; margin-top: 20px; margin-left: 30%;' class ='btn btn-primary btn-lg' >Withdraw </button/></form></td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>Garden ID: {$row["gardenID"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>{$row["activity"]}</p> </td></tr>
            <tr><td></td></tr>
            <tr><td> <p style='font-size: 2px; margin-left: 20px;'>{$row["date"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>{$row["startTime"]} to {$row["endTime"]}</p> </td></tr>";
        }
        echo "</table>";
        
        CloseCon($conn);
        return;
    }
        
    /**
     * WithdrawConfirmedSession
     * Withdraws a user form an existing confirmed session. 
     * 
     * Searches through the request database to find any entry that belongs to the given sessionID and username, and deletes the entry from the requests database.
     * 
     * Decreases the filledSlots for that certain session by 1 
     * 
     * @param  String $sessionID a unique Sesssion identifier 
     * @param  String $username a uinque ID for the Volunteer
     * @return void
     */
    function WithdrawConfirmedSession($sessionID, $username){
        include 'conn.php';
        $conn = OpenCon();
        
        $username = $_SESSION['ID'];
        
        mysqli_select_db($conn,'database');
        $query = "SELECT `filledSlots`, `maxSlots` FROM `session` WHERE sessionID='$sessionID'";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_array($result);
        $filled = $row['filledSlots'];
        $max = $row['maxSlots'];
        echo $filled.$max;
        if ($filled-1 >= 0){
            $filled = $filled - 1;
            echo $filled.$max;
            echo $gardenID.$sessionID;
            $query = "UPDATE `session` SET `filledSlots`= '$filled' WHERE sessionID ='$sessionID'";
            $result = mysqli_query($conn,$query);
        }
        $query =
        "DELETE FROM `request` WHERE sessionID like '$sessionID' AND username like '$username'";
        $result = mysqli_query($conn,$query);
        while($row = mysqli_fetch_array($result)){
            DisplayConfirmedSessions($username);}
        
        CloseCon($conn);
        return;
    }
?>


