<?php
    
    if(isset($_POST['Withdraw'])){
        $sessionID = $_POST['sessionID'];
        $username = $_SESSION['ID'];

        echo '<script>alert("Withdrawn from Session");
            window.location.href="RequestedSessionsUI.php";</script>';
        WithdrawRequestedSession($sessionID, $username);
    }
    /**
     * DisplayrequestedSessions
     * Takes in a unique Volunteer ID to search through the request and session database for any requested sessions. 
     * Prints out any requested sessions in a table format.
     * 
     * @param  String $username unique ID for a Volunteer user
     * @return void
     */
    function DisplayRequestedSessions($username){
        include 'conn.php';
        $conn = OpenCon();
        
        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `request`
                    INNER JOIN `session` ON `request`.sessionID = `session`.sessionID
                    WHERE username like '$username'
                    AND requestStatus like 'pending'";
        
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) == 0){
            echo "<strong><div style = 'text-align:center'>No sessions requested yet!</strong></div>";
        }
        
        
        while($row = mysqli_fetch_array($result)){
            echo "<table class='jumbotron' style='width: 800px; padding-top: 0px; padding-bottom: 0px; background-color: #eae6de; margin-left: 8%;'>";
            echo
            "<tr><td> <h1 style='font-size: 25px; white-space:pre-wrap; word-wrap:break-word;'> Session ID: {$row['sessionID']} </h1></td>
            <td><form method='POST' action=''> <input name='sessionID' value='",$row["sessionID"],"' hidden>
            <button type='submit' name='Withdraw' value='",$row["sessionID"],"' style='font-size: 15px; margin-top: 20px; margin-left: 30%;' class ='btn btn-success btn-lg' >Withdraw </button/></form></td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>Garden ID: {$row["gardenID"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>{$row["activity"]}</p> </td></tr>
            <tr><td></td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>{$row["date"]}</p> </td></tr>
            <tr><td> <p style='font-size: 25px; margin-left: 20px;'>{$row["startTime"]} to {$row["endTime"]}</p> </td></tr>";
            echo "</table> <br>";
        }
        
        CloseCon($conn);
        return;
    }
    /**
     * WithdrawRequestedSession
     * Withdraws a user form an existing requested session. 
     * 
     * Searches through the requests Database to find any entry that belongs to the given sessionID and username, and deletes the entry from the requests database.
     * 
     * @param  String $sessionID a unique Sesssion identifier 
     * @param  String $username a uinque ID for the Volunteer
     * @return void
     */
    function WithdrawRequestedSession($sessionID, $username){
        include 'conn.php';
        $conn = OpenCon();
            
        mysqli_select_db($conn,'database');
        $query =
        "DELETE FROM `request` WHERE sessionID like '$sessionID' AND username like '$username'";
        
        $result = mysqli_query($conn,$query);
        
        while($row = mysqli_fetch_array($result)){
            DisplayRequestedSessions($username);}
        
        CloseCon($conn);
        return;
    }
?>


