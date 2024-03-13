<?php
/*USE CASE 5 */
include 'conn.php';

/**
 * validateVolunteerEmail
 * Validate the email entered in by the volunteer before changing password
 * 
 * This function accesses the email from the Volunteer database to crosscheck with the entered email.
 * $inital is a SESSION variable stored when login/registration occurs.
 * 
 * @param String $initial   Volunteer's user ID
 * @param String $email     Volunteer's entered email address that is to be verified
 * 
 * @return Int              1 if email is valid, 0 if invalid
 */
function validateVolunteerEmail($initial,$email){
    $conn = OpenCon();
    $valid = 1;
    mysqli_select_db($conn,'database');
    $query = "SELECT * FROM `volunteer` WHERE username = '$initial'";
    $result = mysqli_query($conn,$query);
    $result = mysqli_fetch_array($result);
    if ($result['emailAddress'] == $email){
        return 1;
    }
    else{
        return 0;
    }
    CloseCon($conn);
}
/**
 * validateAdminEmail
 * Validate the email entered in by the admin before changing password
 * 
 * This function accesses the email from the Admin database to crosscheck with the entered email.
 * $inital is a SESSION variable stored when login/registration occurs.
 * 
 * @param String $initial   Admin's user ID
 * @param String $email     Volunteer's entered email address that is to be verified
 * 
 * @return Int              1 if email is valid, 0 if invalid
 * 
 */
function validateAdminEmail($initial,$email){
    $conn = OpenCon();
    $valid = 1;
    mysqli_select_db($conn,'database');
    $query = "SELECT * FROM `admin` WHERE gardenID = '$initial'";
    $result = mysqli_query($conn,$query);
    $result = mysqli_fetch_array($result);
    if ($result['emailAddress'] == $email){
        return 1;
    }
    else{
        return 0;
    }
    CloseCon($conn);
}
/**
 * validatePassword
 * Validates the user's password based on safety requirements. 
 * 
 * Safety Requirements:
 * Password must be at least 8 characters in length.
 * Password must include at least one upper case letter.
 * Password must include at least one number.
 * Password must include at least one special character.
 * 
 * $id and $type are SESSION variables stored when login/registration occurs.
 *
 * This function directly calls saveVolunteerPassword()/saveAdminPassword() if the entered password is valid.
 * @param  String $id        unique user ID 
 * @param  String $type      type of the user, which can either be Volunteer or User
 * @param  String $password  user input for a new password

  * @return Int              1 if email is valid, 0 if invalid
 */
function validatePassword($id,$type,$password){
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return 0;
    }
    else{
        if ($type == "Volunteer"){
            saveVolunteerPassword($id,$password);
        }
        if ($type == "Admin"){
            saveAdminPassword($id, $password);
        }
        return 1;
    }
}

/**
 * saveVolunteerPassword
 * Saves the validated user input for the password field into the database.
 * 
 * Locates the database by searching for all database entires with the Volunteer's unique user ID and updates the password field.
 *
 * @param  String $id        Volunteer's unique user ID
 * @param  String $password  Validated user input for password 
 * @return void
 */
function saveVolunteerPassword($id,$password){
    $conn = OpenCon();
    mysqli_select_db($conn,'database');
    $query = "UPDATE `volunteer` SET `password`='$password' WHERE `username` = '$id'";
    $result = mysqli_query($conn,$query);
    CloseCon($conn);
    return;
}
/**
 * saveAdminPassword
 * Saves the validated user input for the password field into the database.
 * 
 * Locates the database by searching for all database entires with the Admins's unique user ID and updates the password field.
 *
 * @param  String $id        Admins's unique user ID
 * @param  String $password  Validated user input for password 
 * @return void
 */
function saveAdminPassword($id,$password){
    $conn = OpenCon();
    mysqli_select_db($conn,'database');
    $query = "UPDATE `admin` SET `gardenPassword`='$password' WHERE `gardenID` = '$id'";
    $result = mysqli_query($conn,$query);
    CloseCon($conn);
    return;
}

?>