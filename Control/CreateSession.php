<?php
    require_once 'connect.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    /**
     * CreateSession class
     * 
     * This control class manages the creation of session by the Admin user.
     * Creation of session involves verification and inserting new session into the database.
     * 
     */
    class createSession{
        public const MAXSLOTS = 99;
        public const MAXLENGTH = 100;

        // Create a new session
        // Return sessionID of the new Session

        /**
         * createSession
         * 
         * Creates a new session
         * This function inserts the newly created session into the Session database
         * All parameters have been verified before insertion
         * 
         * @param String $gardenID
         * @param Date $date
         * @param Time $startTime
         * @param Time $endTime
         * @param String $activity
         * @param Int $maxSlots
         * 
         * @return Int $sessionID   Session ID of the newly created session
         */
        public static function createSession($gardenID, $date, $startTime, $endTime, $activity, $maxSlots){
            $conn = OpenCon();
            $result = mysqli_query($conn, "SELECT * FROM session");
            $sessionID = mysqli_num_rows($result) + 1;
            while (true){
                $result = mysqli_query($conn, "SELECT * FROM session WHERE sessionID = '$sessionID'");
                if(mysqli_num_rows($result)>0)
                    $sessionID ++;
                else
                    break;
            }

            $query = "INSERT INTO session (sessionID, gardenID, date, startTime, endTime, activity, maxSlots)
            VALUES ('$sessionID','$gardenID', '$date', '$startTime', '$endTime', '$activity', '$maxSlots')";
            mysqli_query($conn,$query);

            CloseCon($conn);
            return $sessionID;
        }

        /**
         * verifyDetails
         * 
         * Verifies the details being entered into creating new session
         * This function checks for empty invalid inputs.
         * 
         * @return String[] $errors    Array of errors that have been found in detail inputs
         */
        public static function verifyDetails($date, $startTime, $endTime, $activity, $maxSlots){
            $start = strtotime($startTime);
            $end = strtotime($endTime);
            $nowDate = strtotime(date("Y-m-d"));
            date_default_timezone_set("Asia/Singapore");
            $nowTime = strtotime(date("H:i"));
            $num = 0;
            $errors = [];

            // Check all parameters are filled.
            if(!$date)
                $errors[] = 'Session date is required.';
            if(!$startTime)
                $errors[] = 'Session start time is required.';
            if(!$endTime)
                $errors[] = 'Session end time is required.';
            if(strlen($activity) === 0)
                $errors[] = 'Session activity is required.';
            if(strlen($maxSlots) === 0)
                $errors[] = 'Session max slots is required.';
            if(!$date||!$startTime||!$endTime||!$activity||!$maxSlots){
                return $errors;
            }
            
            if($date < date("Y-m-d"))
                $errors[] = "Session date should not be earlier than current date.";
            if($start >= $end)
                $errors[] = "Session start time should be earlier than end time.";

            if(!is_numeric($maxSlots))
                $errors[] = "Session max slots should be a positive integer.";
            else{
                if(strpos($maxSlots, '.') === false){
                    $num = (int)$maxSlots;
                    if($num <= 0)
                        $errors[] = "Session max slots should be positive.";
                    else if($num > self::MAXSLOTS)
                        $errors[] = 'Session max slots should be less than '.self::MAXSLOTS.'.';
                }
                else
                    $errors[] = "Session max slots should be a positive integer.";
            }

            if(strlen($activity) > self::MAXLENGTH)
                $errors[] = "Session activity description is too long.";

            return $errors;
        }
    }

?>