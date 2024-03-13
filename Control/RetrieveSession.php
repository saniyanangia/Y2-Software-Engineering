<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    require_once 'connect.php';

    class retrieveSession {        
        /**
         * retrieveSessionByGardenID
         * retrives a session based on the gardenID
         *
         * @param  String  $gardenID  unique ID for Admin
         * @return MYSQLI_BOTH $row   a row from the session database
         */
        public static function retrieveSessionByGardenID($gardenID){
            $conn = OpenCon();
            $query = "SELECT * FROM session where gardenID = '$gardenID'";
            $result = mysqli_query($conn,$query);
            CloseCon($conn);
            return $result;
        }

        /**
         * retrieveSessionByDate
         * retrives a session based on the gardenID and the date
         *
         * @param  String $gardenID   unique ID for Admin
         * @param  String $date       a string input for the date 
         * @return MYSQLI_BOTH $row   a row from the session database
         */
        public static function retrieveSessionByDate($gardenID, $date){
            $conn = OpenCon();
            $query = "SELECT * FROM session where gardenID = '$gardenID' AND date = '$date' ORDER BY startTime";
            $result = mysqli_query($conn,$query);
            CloseCon($conn);
            return $result;
        }
        
        /**
         * retrieveSessionBySessionID
         * retrives a session based on the SessionID
         * 
         * @param  String $sessionID  unique identifier for sessions
         * @return MYSQLI_BOTH $row   a row from the session database
         */
        public static function retrieveSessionBySessionID($sessionID){
            $conn = OpenCon();
            $query = "SELECT * FROM session where sessionID = '$sessionID'";
            $result = mysqli_query($conn,$query);
            CloseCon($conn);
            return mysqli_fetch_array($result);
        }
        
        /**
         * retrieveVolunteer
         * retrives a session based on the Volunteer username 
         * 
         * @param  String $gardenID  unique ID for Admin users
         * @param  String $sessionID unique identifier for sessions
         * @return MYSQLI_BOTH $row   a row from the session database
         */
        public static function retrieveVolunteer($gardenID, $sessionID){
            $conn = OpenCon();
            $query = "SELECT * FROM request where sessionID = '$sessionID' AND gardenID = '$gardenID'  ORDER BY username";
            $result = mysqli_query($conn,$query);
            CloseCon($conn);
            return $result;
            
        }
    }


?>