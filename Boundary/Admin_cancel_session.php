<?php
	require_once "ScheduleUI.php";
	$sessionID = $_POST['sessionID'] ?? null;
	if(!$sessionID){
		echo '<script>alert("Cancellation failed.");
            window.location.href="Admin_timetable.php";</script>';
		exit;
	}
	
	$session = ScheduleUI::retrieveSessionBySessionID($sessionID);
	if($session['date'] < date("Y-m-d")){
        echo "<script> alert('Past sessions cannot be cancelled.');
              window.location.href='Admin_timetable.php'; </script>";
    }
	else
		ScheduleUI::cancelSession($sessionID);
?>