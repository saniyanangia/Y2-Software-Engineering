<?php
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/RetrieveSession.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/CreateSession.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/CancelSession.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/2006/Control/EditSession.php');
    

    class ScheduleUI {
        private $date;

        function __construct(){
            $this->date = date('Y-m-d');
        }

        public function setDate($newDate){
            $this->date = $newDate;
        }

        public function getDate(){
            return $this->date;
        }

        static function displayDate($headerDate){
            $tempDate = $headerDate;
            $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
            echo '<th><a href="Admin_timetable.php?headerDate='.$headerDate.'&&sessionDate='.$tempDate.'">'.$tempDate.'<br>'.$days[date('w', strtotime($tempDate))].'</a></th>';
            $tempDate = date('Y-m-d', strtotime($tempDate. ' + 1 days'));
            echo '<th><a href="Admin_timetable.php?headerDate='.$headerDate.'&&sessionDate='.$tempDate.'">'.$tempDate.'<br>'.$days[date('w', strtotime($tempDate))].'</a></th>';
            $tempDate = date('Y-m-d', strtotime($tempDate. ' + 1 days'));
            echo '<th><a href="Admin_timetable.php?headerDate='.$headerDate.'&&sessionDate='.$tempDate.'">'.$tempDate.'<br>'.$days[date('w', strtotime($tempDate))].'</a></th>';
            $tempDate = date('Y-m-d', strtotime($tempDate. ' + 1 days'));
            echo '<th><a href="Admin_timetable.php?headerDate='.$headerDate.'&&sessionDate='.$tempDate.'">'.$tempDate.'<br>'.$days[date('w', strtotime($tempDate))].'</a></th>';
            $tempDate = date('Y-m-d', strtotime($tempDate. ' + 1 days'));
            echo '<th><a href="Admin_timetable.php?headerDate='.$headerDate.'&&sessionDate='.$tempDate.'">'.$tempDate.'<br>'.$days[date('w', strtotime($tempDate))].'</a></th>';
        }


        static function displaySession($gardenID, $date){
            $sessions = retrieveSession::retrieveSessionByDate($gardenID, $date);
            if(mysqli_num_rows($sessions)==0){
                echo '<div class="jumbotron" style="width: 800px;padding-top: 0px;padding-bottom: 0px">';
                echo '<h1 style="font-size: 20px">No session on '.$date.'</h1>';
                echo "</div>";
            }
            while($session = mysqli_fetch_array($sessions)){
                echo '<div class="jumbotron" style="width: 800px;padding-top: 0px;padding-bottom: 0px">';
                echo '<h1 style="font-size: 20px"> Session ID: '.$session["sessionID"].'</h1>';
                echo '<p style="font-size: 18px"> Activity: '.$session["activity"].'</p>';
                echo '<p style="font-size: 18px"> Date: '.$session["date"].'</p>';
                echo '<p style="font-size: 18px"> Time: '.$session["startTime"]." - ".$session["endTime"].'</p>';
                echo '<p style="font-size: 18px"> Available Slots: '.($session["maxSlots"]-$session["filledSlots"])." / ".$session["maxSlots"].'</p>';
                echo '<p style="font-size: 18px">';

                // Cancel button
                echo '<form method="post" action="Admin_cancel_session.php" style="display: inline-block" onSubmit="return confirm(\'Confirm cancelling this session?\')">';
                echo '<input type="hidden" name="sessionID" value='.$session["sessionID"].'>';
                echo '<button type="submit" style="font-size: 15px;margin-top: 0px; margin-left:0px; color:white;" class ="btn btn-primary btn-lg">Cancel</button>';
                echo '</form>';
                // Edit button
                echo '<a style="font-size: 15px;margin-top: 0px; margin-left:5px; color:white" class="btn btn-primary btn-lg" href="Admin_edit_session.php?sessionID='.$session["sessionID"].'" role="button">Edit</a>';
                // View confirmed volunteers button
                echo '<a style="font-size: 15px;margin-top: 0px; margin-left: 5px; color:white" class="btn btn-primary btn-lg" role="button" onClick="popupWindow(\'Admin_view_volunteer.php?sessionID='.$session["sessionID"].'\')">View confirmed volunteers</a> </p>';
                echo "</div>";
            }
        }

        static function createSession($gardenID, $date, $startTime, $endTime, $activity, $maxSlots){
            return CreateSession::createSession($gardenID, $date, $startTime, $endTime, $activity, $maxSlots);
        }

        static function verifyInputDetails($date, $startTime, $endTime, $activity, $maxSlots){
            
            return CreateSession::verifyDetails($date, $startTime, $endTime, $activity, $maxSlots);
        }

        static function cancelSession($sessionID){
            CancelSession::deleteSession($sessionID);
            CancelSession::notifyVolunteers();
            // !! To be added:
            // Update status of conrresponding request
        }

        static function retrieveSessionBySessionID($sessionID){
            return RetrieveSession::retrieveSessionBySessionID($sessionID);
        }

        static function editSession($sessionID, $date, $startTime, $endTime, $activity, $maxSlots){
            return EditSession::editSession($sessionID, $date, $startTime, $endTime, $activity, $maxSlots);
        }

        static function displayVolunteer($gardenID, $sessionID){
            $requests = RetrieveSession::retrieveVolunteer($gardenID, $sessionID);

            if(mysqli_num_rows($requests)==0){
                echo '<div class="jumbotron" style="width: 800px;padding-top: 0px;padding-bottom: 0px">';
                echo '<h1 style="font-size: 20px">No volunteer request in this session</h1>';
                echo "</div>";
            }

            while($request = mysqli_fetch_array($requests)){
                echo '<div class="jumbotron" style="width: 800px;padding-top: 0px;padding-bottom: 0px">';
                echo '<h1 style="font-size: 20px"> Volunteer username: '.$request["username"].'</h1>';
                echo '<p style="font-size: 12px"> Request status: '.$request["requestStatus"].'</p>';
                echo "</div>";
            }

        }

    }

?>