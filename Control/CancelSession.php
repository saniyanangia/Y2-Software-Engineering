<?php
    require_once 'connect.php';
    require_once 'retrieveSession.php';

    /**
     * CancelSession class
     */
    class CancelSession{

        /**
         * deleteSession
         * 
         * Deletes a session from the Session database by Session ID
         * 
         * @param String $sessionID    Session ID of the session being deleted
         */
        public static function deleteSession($sessionID){
            $conn = OpenCon();
            $query = "DELETE FROM session WHERE sessionID = '$sessionID'";
            mysqli_query($conn,$query);
            CloseCon($conn);
        }

        // Return the confirmedVolunteerList of the session with sessionID
        // Not implemented
        /*
        public static function retrieveContacts($sessionID){
            $result = RetrieveSession::retrieveSessionBySessionID($sessionID);
            $row = mysqli_fetch_array($result);
            return $row["confirmedVolunteerList"];
        }
        */

        /**
         * notifyVolunteers (NOT IMPLEMENTED YET)
         * 
         * Notifies confirmed volunteers that the volunteering session has been cancelled
         * This function has not been fully implemented yet and will currently only display an alert 
         */
        public static function notifyVolunteers(){
            echo '<script>alert("All confirmed volunteers are notified.");
            window.location.href="Admin_timetable.php";</script>';
        }
    }



?>