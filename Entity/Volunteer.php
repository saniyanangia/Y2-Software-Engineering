<?php
    class Volunteer{
        private $username;
        private $password;
        private $emailAddress;
        private $contactNumber;
        private $preferredContact;
        private $gardeningSkill;
        private $gardeningInterest;
        private $gardeningExperience;

        public function __construct(){
            $get_args = func_get_args();
            $num_args = func_num_args();

            if (method_exists($this, $method = '__construct'.$num_args)) {
                call_user_func_array(array($this, $method), $get_args);
            }
        }

        public function __construct3($username,$password,$emailAddress) {
            $this->username = $username;
            $this->password = $password;
            $this->emailAddress = $emailAddress;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getEmailAddress(){
            return $this->emailAddress;
        }

        public function setEmailAddress($emailAddress){
            $this->emailAddress = $emailAddress;
        }

        public function getPassword(){
            return $this->password;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function getContactNumber(){
            return $this->contactNumber;
        }

        public function setContactNumber($contactNumber){
            $this->contactNumber = $contactNumber;
        }

        public function getPreferredContact(){
            return $this->preferredContact;
        }

        public function setPreferredContact($preferredContact){
            $this->preferredContact = $preferredContact;
        }

        public function getGardeningSkill(){
            return $this->gardeningSkill;
        }

        public function setGardeningSkill($gardeningSkill){
            $this->gardeningSkill = $gardeningSkill;
        }

        public function getGardeningInterest(){
            return $this->gardeningInterest;
        }

        public function setGardeningInterest($gardeningInterest){
            $this->gardeningInterest = $gardeningInterest;
        }

        public function getGardeningExperience(){
            return $this->gardeningExperience;
        }

        public function setGardeningExperience($gardeningExperience){
            $this->gardeningExperience = $gardeningExperience;
        }
    }
?>
