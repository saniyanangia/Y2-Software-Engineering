<?php
/* USE CASE 6 and 12*/
   include 'conn.php';   
   /**
    * getProfileDetails
    * Returns a row from the volunteer/admin database that has the same username as the function input $ID. 
    *
    * Both ID and type are SESSION variables stored when login/registration occurs. 
    * <p>
    * This method does a mysql query to the database to select user profiles that have 
    * the same username as the function input $ID. Returns the rows from that query.
    * $ID and username are unique to each user. 
    *
    * @param  String $ID        unique user ID (Volunteers -> username, Admin -> GardenID)
    * @param  String $type      type of the user, which can either be Volunteer or User
    * @return MYSQLI_BOTH row   a row from the volunteer/admin database 
    */
   function getProfileDetails($ID,$type){ 
        $conn = OpenCon();
        mysqli_select_db($conn,'database');
        if ($type == "Volunteer"){ 
            $query = "SELECT * FROM `volunteer` WHERE username = '$ID'";
            $result = mysqli_query($conn,$query);
        } 
        if ($type == "Admin"){ 
            $query = "SELECT * FROM `admin` WHERE gardenID = '$ID'";
            $result = mysqli_query($conn,$query);
        } 
        $row = mysqli_fetch_array($result);
        CloseCon($conn);
        return $row;
   }    
    /**
     * displayProfilePage
     * Prints out a user's details in a HTML table.
     * 
     * Both ID and type are SESSION variables stored when login/registration occurs. 
     * <p>
     * This method does a mysql query to the database to select user profiles that have 
     * the same username as the function input $ID. Relevant fields from the mysql query are printed out.
     * 
     * Relevant fields for Volunteer: Username, Email Address, Contact Number, Preferred Contact, Skills, Interests, Experience
     * Relevant fields for Admin: GardenID, Email Address, Location, Region, Name, Contact Number, Preferred Contact
     * 
     * $ID and username are unique to each user. 
     * 
     * @param  String $ID     unique user ID (Volunteers -> username, Admin -> GardenID)
     * @param  String $type   type of the user, which can either be Volunteer or User
     * @return void
     */
    function displayProfilePage($ID, $type){ 
        $conn = OpenCon();
        mysqli_select_db($conn,'database');
        if ($type == "Volunteer"){ 
            $query = "SELECT * FROM `volunteer` WHERE username = '$ID'";
            $result = mysqli_query($conn,$query);
        } 
        if ($type == "Admin"){ 
            $query = "SELECT * FROM `admin` WHERE gardenID = '$ID'";
            $result = mysqli_query($conn,$query);
        } 
        echo "<table class = 'table table-bordered'>";
        if($type == "Volunteer"){
            while($row = mysqli_fetch_array($result)){  
                echo "<tr><td> Username: </td><td>". $row['username'] . "</td></tr><tr><td> Email Address: </td><td>" . $row['emailAddress'] . "</td></tr><tr><td> Contact Number: </td><td>". $row['contactNumber'] . "</td></tr><tr><td> Preferred Contact : </td><td>". $row['preferredContact']."</td></tr><tr><td> Skills: </td><td>" . $row['gardeningSkill'] . "</td></tr><tr><td> Interests: </td><td>". $row['gardeningInterest'] . "</td></tr><tr><td> Experience: </td><td>". $row['gardeningExperience'] . "</td></tr>"; 
            }
        }
        if($type == "Admin"){
            while($row = mysqli_fetch_array($result)){  
                echo "<tr><td> GardenID: </td><td>". $row['gardenID'] ."</td></tr><tr><td> Email Address: </td><td>" . $row['emailAddress'] ."</td></tr><tr><td> Location: </td><td>". $row['gardenLocation'] ."</td></tr><tr><td> Region: </td><td>". $row['region']."</td></tr><tr><td> Name: </td><td>". $row['adminName']."</td></tr><tr><td> Contact Number: </td><td>". $row['contactNumber']."</td></tr><tr><td> Preferred Contact : </td><td>". $row['preferredContact']."</td></tr>"; 
            }
        }
        echo "</table>";
        CloseCon($conn);
        return;
    }
    
    /**
     * validateVolunteerEdits
     * Checks whether the user inputs for editing user profile fields are valid, for a Volunteer and returns an array of the errors.
     * 
     * This function is meant to accept volunteer edit information only. 
     * The validation is done for 4 fields and are as follows:
     * Username: check if username is unique by checking in the volunteer Database of existence of other instances
     * Email Address : check if Email Address is unique by checking in the volunteer Database of existence of other instances
     * Contact Number : check if Contact Number is unique by checking in the volunteer Database of existence of other instances
     * Email Address : check if Email is valid (using PHP FILTER_VALIDATE_EMAIL Filter)
     * Contact Number:  check if  Contact Number is 8 digits long by comparing numerically 
     * 
     * The return array can be empty, and if it is empty, the function saveVolunteerEdits will be directly called from this function.
     *
     * @param  String $initial            unique initial user ID (can be edited by this function)
     * @param  String $username           user input for the field username 
     * @param  String $email              user input for the field emailAddress 
     * @param  Int    $number             user input for the field contactNumber
     * @param  String $skills             user input for the field gardeningSkills
     * @param  String $interests          user input for the field gerdeningInterest
     * @param  String $experiences        user input for the field gardeningExperience
     * @param  ENUM   $preferred_contact  user input for the field preferredContact
     * @return String[] $errors           errors messages to be printed to the user
     */
    function validateVolunteerEdits($initial,$username, $email, $number, $skills, $interests,$experiences,$preferred_contact){
        $errors = [];
        $conn = OpenCon();
        $valid = 1;
        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `volunteer` WHERE username = '$initial'";
        $result = mysqli_query($conn,$query);
        $result = mysqli_fetch_array($result);
        if ($username != $result['username']){
            $query = "SELECT COUNT(*) AS `count` from `volunteer` where username = '$username'";
            $username_result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($username_result);
            $count = $row['count'];
            if($count > 0) {
                $errors[] = 'Invalid Username. Username already in use';
                $valid = 0; 
            }
        }
        if ($email != $result['emailAddress']){
            $query = "SELECT COUNT(*) AS `count` from `volunteer` where emailAddress = '$email'";
            $email_result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($email_result);
            $count = $row['count'];
            if($count > 0) {
                $errors[] = 'Invalid Email Address. Email Address already in use.';
                $valid = 0; 
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = $email.' is not a valid Email Address.';
                $valid = 0;
            } 
        }
        if ($number != $result['contactNumber']){
            $query = "SELECT COUNT(*) AS `count` from `volunteer` where contactNumber = '$number'";
            $number_result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($number_result);
            $count = $row['count'];
            if($count > 0) {
                $errors[] = 'Invalid Contact Number. Contact Number already in use.';
                $valid = 0; 
            }
            if ($number < 100000000){
                if($number < 10000000){
                    $errors[] = 'Contact Number is less than 8 digits long.';
                    $valid = 0;
                }
            }
            else{
                $errors[] = 'Contact Number is more than 8 digits long.';
                $valid = 0;
            }
        }
        if ($valid){
            CloseCon($conn);
            saveVolunteerEdits($initial,$username, $email, $number, $skills,$interests,$experiences,$preferred_contact);
            return $errors;
        }
        else{
            CloseCon($conn);
            return $errors;
        }
    }    
    /**
     * saveVolunteerEdits
     * This function saves valid user inputs in the database, for a Volunteer.
     * 
     * This function uses $initial, the previous user ID to locate the user's information in the database. Then,
     * an sql update query is performed to update the database.
     * 
     * In the event where the username is changed, a new SESSION ID has to be set outside of this function.
     *
     * @param  String $initial            unique initial user ID (can be edited by this function)
     * @param  String $username           user input for the field username 
     * @param  String $email              user input for the field emailAddress 
     * @param  Int    $number             user input for the field contactNumber
     * @param  String $skills             user input for the field gardeningSkills
     * @param  String $interests          user input for the field gardeningExperiencees
     * @param  String $experiences        user input for the field gardeningExperience
     * @param  ENUM   $preferred_contact  user input for the field prefetredContact
     * @return void
     */
    function saveVolunteerEdits($initial,$username, $email, $number, $skills,$interests,$experiences,$preferred_contact){
        $conn = OpenCon();
        mysqli_select_db($conn,'database');
        $query = "UPDATE `volunteer` SET `username`='$username',`emailAddress`='$email',`contactNumber`='$number',`gardeningskill`='$skills',`gardeningInterest`='$interests',`gardeningExperience`='$experiences',`preferredContact`='$preferred_contact' WHERE `username` = '$initial'";
        $result = mysqli_query($conn,$query);
        $query = "UPDATE `request` SET `username`='$username' WHERE `username` = '$initial'";
        $result = mysqli_query($conn,$query);
        CloseCon($conn);
        return;
    }    
    /**
     * validateAdminEdits
     * 
     * Checks whether the user inputs for editing user profile fields are valid, for an Admin and returns an array of the errors.
     * 
     * This function is meant to accept volunteer edit information only. 
     * The validation is done for 4 fields and are as follows:
     * GardenID: check if GardenID is unique by checking in the volunteer Database of existence of other instances
     * Email Address : check if Email Address is unique by checking in the volunteer Database of existence of other instances
     * Contact Number : check if Contact Number is unique by checking in the volunteer Database of existence of other instances
     * Email Address : check if Email is valid (using PHP FILTER_VALIDATE_EMAIL Filter)
     * Contact Number:  check if  Contact Number is 8 digits long by comparing numerically 
     * 
     * The return array can be empty, and if it is empty, the function saveVolunteerEdits will be directly called from this function.
     *
     * @param  String $initial            unique initial user ID (can be edited by this function)
     * @param  String $gardenID           user input for the field gardenID 
     * @param  String $email              user input for the field emailAddress 
     * @param  String $location           user input for the field gardenLocation
     * @param  String $region             user input for the field region
     * @param  String $name               user input for the field adminName
     * @param  String $number             user input for the field contactNumber
     * @param  ENUM   $preferred_contact  user input for the field preferredContact
     * @return String[] $errors           errors messages to be printed to the user
     * 
     */
    function validateAdminEdits($initial,$gardenID,$email,$location,$region,$name,$number,$preferred_contact){
        $errors = [];
        $conn = OpenCon();
        $valid = 1;
        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `admin` WHERE gardenID = '$initial'";
        $result = mysqli_query($conn,$query);
        $result = mysqli_fetch_array($result);
        if ($gardenID != $result['gardenID']){
            $query = "SELECT COUNT(*) AS `count` from `admin` where gardenID = '$gardenID'";
            $username_result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($username_result);
            $count = $row['count'];
            if($count > 0) {
                $errors[] = 'Invalid GardenID. GardenID already in use.';
                $valid = 0; 
            }
        }
        if ($email != $result['emailAddress']){
            $query = "SELECT COUNT(*) AS `count` from `admin` where emailAddress = '$email'";
            $email_result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($email_result);
            $count = $row['count'];
            if($count > 0) {
                $errors[] = 'Invalid Email Address. Email Address already in use.';
                $valid = 0; 
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] =  $email.' is not a valid Email Address.';
                $valid = 0;
            } 
        }
        if ($number != $result['contactNumber']){
            $query = "SELECT COUNT(*) AS `count` from `admin` where contactNumber = '$number'";
            $number_result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($number_result);
            $count = $row['count'];
            if($count > 0) {
                $errors[] = 'Invalid Contact Number. Contact Number already in use.';
                $valid = 0; 
            }
            if ($number < 100000000){
                if($number < 10000000){
                    $errors[] = 'Contact Number is less than 8 digits long.';
                    $valid = 0;
                }
            }
            else{
                $errors[] = 'Contact Number is more than 8 digits long.';
                $valid = 0;
            }
        }
        if ($valid){
            CloseCon($conn);
            saveAdminEdits($initial,$gardenID,$email,$location,$region,$name,$number,$preferred_contact);
            return $errors;
        }
        else{
            CloseCon($conn);
            return $errors;
        }
    }    
    /**
     * saveAdminEdits
     * This function saves valid user inputs in the database, for a Admin.
     * 
     * This function uses $initial, the previous user ID to locate the user's information in the database. Then,
     * an sql update query is performed to update the database.
     * 
     * In the event where the username is changed, a new SESSION ID has to be set outside of this function.
     *
     * @param  String $initial            unique initial user ID (can be edited by this function)
     * @param  String $gardenID           user input for the field gardenID 
     * @param  String $email              user input for the field emailAddress 
     * @param  String $location           user input for the field gardenLocation
     * @param  String $region             user input for the field region
     * @param  String $name               user input for the field adminName
     * @param  String $number             user input for the field contactNumber
     * @param  ENUM   $preferred_contact  user input for the field preferredContact
     * @return void
     */
    function saveAdminEdits($initial,$gardenID,$email,$location,$region,$name,$number,$preferred_contact){
        $conn = OpenCon();
        mysqli_select_db($conn,'database');
        $query = "UPDATE `admin` SET `gardenID`='$gardenID',`emailAddress`='$email',`gardenLocation`='$location',`region`='$region',`adminName`='$name',`contactNumber`='$number',`preferredContact`='$preferred_contact' WHERE `gardenID` = '$initial'";
        $result = mysqli_query($conn,$query);
        $query = "UPDATE `request` SET `gardenID`='$gardenID' WHERE `gardenID` = '$initial'";
        $result = mysqli_query($conn,$query);
        $query = "UPDATE `session` SET `gardenID`='$gardenID' WHERE `gardenID` = '$initial'";
        $result = mysqli_query($conn,$query);
        CloseCon($conn);
        return;
    }

?>
