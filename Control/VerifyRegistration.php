<?php
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'\2006\Entity\Admin.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'\2006\Entity\Volunteer.php';
    require_once realpath($_SERVER["DOCUMENT_ROOT"]).'\2006\Entity\DB.php';
    
    /**
     * control class to verify user registration
     */
    class VerifyRegistration{        
        public function __construct(){}

        /**
         * Create a new Admin/Volunteer user account for user to use. 
         * @param String $userID
         * @param String $password
         * @param String $email
         * @param String $role
         * @return array of String if create user account is successful or error message if fail.
         *  $userID
         * @param String $passsword
         * @param String $email
         * @param String role
         * @return array of String 
         */
        public function createUser($userID,$password,$email,$role){
            $result = $this->verifyCredentials($userID,$password,$email,$role);
            if(empty($result)){
                $created;
                if($role==="Admin"){
                    $checkGardenExist = $this->getGardenDetails($userID);
                    if($checkGardenExist["message"]==="found"){
                        $created = $this->createAdmin($userID, $password, $email, $checkGardenExist["gardenLocation"], $checkGardenExist["gardenRegion"]);
                    }else{
                        $result['userID'] = $checkGardenExist["message"];
                        $result['message'] = "Invalid Inputs";
                    }
                }else{
                    $created = $this->createVolunteer($userID, $password, $email);
                }
                if(!empty($created)){
                    $result['message'] = $created;
                    if(str_contains($created,"already exist")){
                        if(str_contains($created,"Garden ID")||str_contains($created,"Username")){
                            $result['message'] = "Duplicate Value";
                            $result['userID'] = $created;
                        }else if(str_contains($created,"Email Address")){
                            $result['message'] = "Duplicate Value";
                            $result['email'] = $created;
                        }
                    }
                }
            }else{
                $result['message'] = "Invalid Inputs";
            }
            return $result;
        }

        public function getGardenDetails($gardenID){
            $response = file_get_contents('https://data.gov.sg/api/action/resource_show?id=9cb42cb6-a710-4406-b281-30b3903de33a');
            $json = json_decode($response);

            $file = $json->result->url;
            $tempLocalFile = 'tmp_file.zip';
            $result = array("message" => "failed to download $file...");

            if (copy($file, $tempLocalFile)) {
                $zip = new ZipArchive();
                if ($zip->open($tempLocalFile, ZIPARCHIVE::CREATE)===TRUE) {
                    $cib_list = $zip->getFromIndex(0);
                    $xml = simplexml_load_string($cib_list);
                    
                    $result["message"] = "No garden with this Garden ID";
                    for ($i = 0; $i < sizeof($xml->Document[0]->Folder->Placemark); $i++) {
                        $description = (string) $xml->Document[0]->Folder->Placemark[$i]->description;

                        $findText = "<td>GardenID</td>";
                        $findGid = substr($description,strpos($description, $findText)+strlen($findText));
                        $findText = "<td>";
                        $findGid = substr($findGid,strpos($findGid, $findText)+strlen($findText),strpos($findGid, "</td>"));
                        $findText = "</td>";
                        $findGid = substr($findGid,0,strpos($findGid,$findText));

                        $findText = "<td>CDC</td>";
                        $findRegion = substr($description,strpos($description, $findText)+strlen($findText));
                        $findText = "<td>";
                        $findRegion = substr($findRegion,strpos($findRegion, $findText)+strlen($findText),strpos($findRegion, "</td>"));
                        $findText = "</td>";
                        $findRegion = substr($findRegion,0,strpos($findRegion,$findText));     

                        if($findGid===$gardenID){
                            $result["gardenLocation"] = $xml->Document[0]->Folder->Placemark[$i]->name;
                            $result["gardenRegion"] = $findRegion;
                            $result["message"] = "found";
                            break;
                        }
                    }
                }
                unset($zip);
            }
            unlink($tempLocalFile);
            return $result;
        }

        public function createAdmin($gardenID, $gardenPassword, $emailAddress, $gardenLocation, $region){
            try{
                $db = new DB();
                $conn= $db->getConn();
                $sql = "INSERT INTO admin (gardenID, gardenPassword, emailAddress, gardenLocation, region) VALUES (?,?,?,?,?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('issss', $gardenID, $gardenPassword, $emailAddress, $gardenLocation, $region);
                $stmt->execute();

                session_start();
                $_SESSION['ID'] = $gardenID;
                $_SESSION['Type'] = "Admin";

                return "Success";
            } catch(mysqli_sql_exception $e){
                if($e->getCode()===1062){
                    $message;
                    if(str_contains($e->getMessage(),"PRIMARY")){
                        $message = "Garden ID already exist";
                    }else{
                        $message = "Email Address already exist";
                    }
                    return $message;
                }else{
                    return $e->getMessage();
                }
            }
        }

        public function createVolunteer($username, $password, $emailAddress){
            try{
                $db = new DB();
                $conn= $db->getConn();
                $sql = "INSERT INTO volunteer(username, password, emailAddress) VALUES (?,?,?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $username, $password, $emailAddress);
                $stmt->execute();

                session_start();
                $_SESSION['ID'] = $username;
                $_SESSION['Type'] = "Volunteer";

                return "Success";
            }  catch(mysqli_sql_exception $e){
                if($e->getCode()===1062){
                    $message;
                    if(str_contains($e->getMessage(),"PRIMARY")){
                        $message = "Username already exist";
                    }else{
                        $message = "Email Address already exist";
                    }
                    return $message;
                }else{
                    return $e->getMessage();
                }
            }
        }

        public function validateEmail($email){
            if (!isset($email) || empty($email)){
                return "Email cannot be empty";
            }else if(!(preg_match(("/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/"), $email))){
                return "Invalid email";
            }
            return true;
        }

        public function validateUserID($userID,$role){
            if (!isset($userID) || empty($userID)){
                $message = ($role==="Admin")?"Garden ID":"Username";
                return $message." cannot be empty";
            }else if(!ctype_alnum($userID)&&$role==="Volunteer"){
                return "Only letters and numbers are allowed for username";
            }else if((strlen($userID)<8||strlen($userID)>40)&&$role==="Volunteer"){
                return "Use 8 to 40 alphanumeric characters for your username";
            }else if(!ctype_digit($userID)&&$role==="Admin"){
                return "Only numbers are allowed for garden ID";
            }
            return true;
        }

        public function validatePassword($password){
            $errMsg = array();
            if(!(preg_match("/^(?=.*[a-z]).*$/", $password))||!(preg_match("/^(?=.*[A-Z]).*$/", $password))){
                array_push($errMsg, "At least one uppercase and lowercase");
            }
            if(!(preg_match("/^(?=.*[0-9]).*$/", $password))){
                array_push($errMsg, "At least one digit");
            }
            if(!(preg_match("/^(?=.*[!@#$%^&*]).*$/", $password))){
                array_push($errMsg, "At least one special characters");
            }
            if(strlen($password)<8 || !isset($password) || empty($password) || strlen($password)>40){
                array_push($errMsg, "Minimum 8 to 40 characters");
            }
            if(empty($errMsg)){
                return true;
            }
            return $errMsg;
        }

        public function validateRole($role){
            if (!isset($role) || empty($role) ){
                return "Please select a role";
            }else if($role==="Admin"||$role==="Volunteer"){
                return true;
            }
            return "Unknown role";
        }

        public function verifyCredentials($userID,$password,$email,$role){
            $validUserID = $this->validateUserID($userID,$role);
            $validEmail = $this->validateEmail($email);
            $validRole = $this->validateRole($role);
            $validPassword = $this->validatePassword($password);

            $invalidInputs = array();
            if($validRole!==true){
                $invalidInputs['role'] = $validRole;
            }
            if($validEmail!==true){
                $invalidInputs['email'] = $validEmail;
            }
            if($validUserID!==true){
                $invalidInputs['userID'] = $validUserID;
            }
            if($validPassword!==true){
                $invalidInputs['password'] = $validPassword;
            }
            return $invalidInputs;        
        }
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $registerController = new VerifyRegistration();
        $result = $registerController->createUser($_POST['userID'],$_POST['password'],$_POST['email'],$_POST['role']);
        echo json_encode($result);
    }
?>
