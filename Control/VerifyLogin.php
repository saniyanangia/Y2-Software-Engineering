<?php
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'\2006\Entity\Admin.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'\2006\Entity\Volunteer.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'\2006\Entity\DB.php';

    /**
     * Control class to verify user login 
     */
    class VerifyLogin{        
        public function __construct(){}
        /**
         * Check user inputs with database. If userID exist and password matches, then return success to allow user to login
         * @param String $inputUserID       - username/gardenID of user
         * @param String $inputUserPassword - password of user
         * @param String $role              - role of user (Admin/Volunteer)
         * @return array of String if login successfully or error message
         */
        public function verifyUser($inputUserID,$inputUserPassword,$role){
            $found;
            $result = array("message" => "Success");

            if($role==="Admin")
                $found = $this->getAdminByGardenID($inputUserID);
            else if($role==="Volunteer")
                $found = $this->getVolunteerByUsername($inputUserID);
            else
                $result['role'] = "Unknown role";

            if($found){
                $checkPassword = ($role==="Admin")?$found->getGardenPassword():$found->getPassword();
                if($checkPassword===$inputUserPassword){
                    session_start();
                    $_SESSION['ID'] = $inputUserID;
                    $_SESSION['Type'] = $role;
                    return $result;
                }else{
                    $result['password'] = "Incorrect Password";
                }
            }else if(!isset($result['role'])){
                $message = " does not exist";
                $result['userID'] = ($role==="Admin")?$role." garden ID ".$message:$role." username ".$message;
            }
            $result['message'] = "Wrong Inputs";
            return $result;
        }

        /**
         * Retrieve Admin details from database based on garden ID
         * @param String $inputUserID - garden ID of user
         * @return Admin 
         */
        public function getAdminByGardenID($inputUserID){
            $db = new DB();
            $conn= $db->getConn();
            $query = "SELECT * FROM admin WHERE gardenID=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $inputUserID);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_object('Admin');
        }
        
        /**
         * Retrieve Volunteer details from database based on username
         * @param String $inputUserID - username of user
         * @return Volunteer
         */
        public function getVolunteerByUsername($inputUserID){
            $db = new DB();
            $conn= $db->getConn();
            $query = "SELECT * FROM volunteer WHERE username=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $inputUserID);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_object('Volunteer');
        }

        /**
         * Check if user inputs are empty
         * @param array of String from user inputs 
         * @return array of String containing error message if any
         */
        public function checkEmptyFields($inputs){
            $emptyField = array();
            foreach ($inputs as $key => $value) {
                if(!isset($value)||empty($value)){
                    $emptyField[$key] = "Please enter your ".$key;
                }
            }
            if(!isset($inputs['role'])||empty($inputs['role'])){
                $emptyField['role'] = "Please select your role";
            }

            return $emptyField;
        }
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $result;
        $loginController = new VerifyLogin();
        $isEmpty = $loginController->checkEmptyFields($_POST);

        if(sizeof($isEmpty)>0){
            $isEmpty['message'] = "Empty Fields";
            $result = json_encode($isEmpty);            
        }else{
            $result = json_encode($loginController->verifyUser($_POST['userID'],$_POST['password'],$_POST['role']));
        }
        echo $result;
    }
?>
