
<?php
    include 'conn.php';    
    /**
     * DisplayRequests
     * 
     * This function takes in the date and the garden ID and filters the requests database by the entered date and ID.
     * Prints a list of requests.
     * 
     * 
     * @param  String $gardenID unique ID for Admin Users
     * @param  String $date     string represenation of a date 
     * @return void
     */
    function DisplayRequests($gardenID,$date){
        $conn = OpenCon();
        mysqli_select_db($conn,'database');
        echo "<div class='container_12' style = 'font-family:'Marvel';'>";
        echo "<table class='jumbotron' style='width: 800px; padding-top: 0px; padding-bottom: 0px;'>";
        $query = "SELECT * FROM `session` WHERE gardenID like '$gardenID' AND `date` LIKE '$date'";
        $sessions = mysqli_query($conn,$query);
        if (mysqli_num_rows($sessions) == 0){
            echo "<div style = 'text-align:center;'><strong>No requests on this day!</strong></div><br>";
            return;
        }
        while($session = mysqli_fetch_array($sessions)){
            $sessionID = $session['sessionID'];
            $activity = $session['activity'];
            $query = "SELECT * FROM `request` WHERE gardenID like '$gardenID' AND `sessionID` LIKE '$sessionID' AND requestStatus LIKE 'pending'";
            $requests = mysqli_query($conn,$query);
            if (mysqli_num_rows($requests) == 0){
                echo "<div style = 'text-align:center;'><strong>No requests on this day!</strong></div><br>";
                return;
            }
            while($request = mysqli_fetch_array($requests)){
                $username = $request['username'];
                $query = "SELECT * FROM `volunteer` WHERE username LIKE '$username'";
                $volunteerResult = mysqli_query($conn,$query);
                $volunteer = mysqli_fetch_array($volunteerResult);
                echo"
                <tr><td><h1 style='padding-left: 15px; font-size: 20px'>Session ID: $sessionID | $activity</h1></td></tr>
                <tr><td><p style='padding-left: 15px;font-size: 15px'>Volunteer name: $username</p></td></tr>
                <tr><td><p style='padding-left: 15px;font-size: 15px'>Phone: (+65) {$volunteer['contactNumber']}</p></td></tr>
                <tr><td><p style='padding-left: 15px;font-size: 15px'>Email Address: {$volunteer['emailAddress']}</p></td></tr>
                <tr><td><p style='padding-left: 15px;font-size: 15px'>Skills: {$volunteer['gardeningSkill']}</p></td></tr>
                <tr><td><p style='padding-left: 15px;font-size: 15px'>Interests: {$volunteer['gardeningInterest']}</p></td></tr>
                <tr><td><p style='padding-left: 15px;font-size: 15px'>Experiences: {$volunteer['gardeningExperience']}</p></td></tr>
                ";
                echo"<td><form method='POST' action = '/2006/Control/handleRequest.php'>
                <input type='hidden' name='gardenID' value='$gardenID'/>
                <input type='hidden' name='username' value='$username'/>
                <input type='hidden' name='sessionID' value='$sessionID'/>
                <button style='padding-left: 10px;' type='submit' name='requestStatus' placeholder='Approve' value='approve' style='font-size: 15px; margin-top: 15px; margin-left: 15px; ' class ='btn btn-primary btn-lg' >Approve </button>
                <button style='padding-left: 10px;' type='submit' name='requestStatus' placeholder='Reject' value='reject' style='font-size: 15px; margin-top: 15px;margin-left: 15px; ' class ='btn btn-primary btn-lg' >Reject </button>
                </form></td>
                <tr><td><hr></td></tr>
                ";
                echo "</table>";
            }
        }
        echo "</div>";
        CloseCon($conn);
        return;
    }


?>