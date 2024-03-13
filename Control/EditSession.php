<?php
    require_once 'connect.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    /**
     * EditSession Class
     * 
     * This control class manages the editing of existing sessions at a garden
     * Details of a session that may be edited include: 
        * date
        * startTime
        * endTime
        * activity
        * maxSlots
     */
    class EditSession{
        public const MAXSLOTS = 99;
        public const MAXLENGTH = 100;
        // Edit the session with sessionID
        // Return true if succeed, false if input is invalid

        /**
         * editSession
         * 
         * Edits the session with sessionID and new details
         * Parameters that are passed in as null will be left unedited
         * This function updates the session details in the Session database.
         * 
         * @param String $sessionID Session ID of session to be edited
         * @param Date $date        New date of session
         * @param Time $startTime   New starting time for session
         * @param Time $endTime     New ending time for session
         * @param String $activity  New activity for session
         * @param Int $maxSlots     New maximum number of slots for session
         * 
         * @return Boolean true     Session has successfully been edited
         */
        public static function editSession($sessionID, $date, $startTime,
        $endTime, $activity, $maxSlots){
            $conn = OpenCon();
            if ($date!=null){
                $query = "UPDATE session
                SET date = '$date' WHERE sessionID = '$sessionID'";
                mysqli_query($conn,$query);
            }
            if ($startTime!=null){
                $query = "UPDATE session
                    SET startTime = '$startTime' WHERE sessionID = '$sessionID'";
                    mysqli_query($conn,$query);
            }
            if ($endTime){
                $query = "UPDATE session
                SET endTime = '$endTime' WHERE sessionID = '$sessionID'";
                mysqli_query($conn,$query);
            }
            if ($activity!=null){
                $query = "UPDATE session
                SET activity = '$activity' WHERE sessionID = '$sessionID'";
                mysqli_query($conn,$query);
            }
            if ($maxSlots!=null){
                $query = "UPDATE session
                SET maxSlots = '$maxSlots' WHERE sessionID = '$sessionID'";
                mysqli_query($conn,$query);
            }
            CloseCon($conn);

            return true;
        }
    }



?>