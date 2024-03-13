at<?php session_start()?>


<?php

    $state = $_POST["requestStatus"];
    $username = $_POST["username"];
    $gardenID = $_POST["gardenID"];
    $sessionID = $_POST["sessionID"];


    // Uses $state to perform approval or rejection
    if ($state == 'approve'){
        approveRequest($gardenID,$sessionID,$username);
    }
    else{
        rejectRequest($gardenID,$sessionID,$username);
    }

    /**
     * approveRequest
     * 
     * Approves an existing volunteer request
     * This function updates the status of volunteer's request from 'pending' to 'approved'
     * 
     * @param String $gardenID     Garden ID for the garden with the request
     * @param String $sessionID    Session ID of the session being booked by volunteer
     * @param String $username  Username of the volunteer booking session
     */
    function approveRequest($gardenID,$sessionID,$username){
        include 'conn.php';

        $conn = OpenCon();
        mysqli_select_db($conn,'database');
        $query = "UPDATE request SET requestStatus='approved' WHERE gardenID='$gardenID' AND sessionID='$sessionID' AND username='$username'"; //You don't need a ; like you do in SQL
        $result = mysqli_query($conn,$query);
        $query = "SELECT `filledSlots`, `maxSlots` FROM `session` WHERE gardenID='$gardenID' AND sessionID='$sessionID'";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_array($result);
        $filled = $row['filledSlots'];
        $max = $row['maxSlots'];
        echo $filled.$max;
        if ($filled+1 <= $max){
            $filled = $filled + 1;
            echo $filled.$max;
            echo $gardenID.$sessionID;
            $query = "UPDATE `session` SET `filledSlots`= '$filled' WHERE gardenID ='$gardenID' AND sessionID ='$sessionID'";
            $result = mysqli_query($conn,$query);
            echo '<script>alert("Approval complete.");window.location.href="2006/Boundary/Admin_manage_request.php";</script>';
            echo '<script>window.location.replace("../Boundary/Admin_manage_request.php")</script>';
        }
        else{
            echo '<script> alert("Cannot request for session as all slots are booked!")</script>';
            echo '<script>window.location.replace("../Boundary/Admin_manage_request.php")</script>';
        }
 
        CloseCon($conn);
    }

     /**
     * rejectRequest
     * 
     * Rejects an existing volunteer request
     * This function updates the status of volunteer's request from 'pending' to 'rejected'
     * 
     * @param String $gardenID     Garden ID for the garden with the request
     * @param String $sessionID    Session ID of the session being booked by volunteer
     * @param String $username  Username of the volunteer booking session
     */
    function rejectRequest($gardenID,$sessionID,$username){
        include 'conn.php';
        $conn = OpenCon();
        mysqli_select_db($conn,'database');

        $query = "UPDATE request SET requestStatus='rejected' WHERE gardenID='$gardenID' AND sessionID='$sessionID' AND username='$username'"; //You don't need a ; like you do in SQL
        $result = mysqli_query($conn,$query);
        echo '<script>alert("Rejection complete.");</script>';
        echo '<script>window.location.replace("../Boundary/Admin_manage_request.php")</script>';

        CloseCon($conn);
    }

?>