<?php
    class Admin{
        private $gardenID;
        private $gardenPassword;
        private $emailAddress;
        private $gardenLocation;
        private $region;
        private $adminName;
        private $contactNumber;
        private $preferredContact;

        public function __construct(){
            $get_args = func_get_args();
            $num_args = func_num_args();

            if (method_exists($this, $method = '__construct'.$num_args)) {
                call_user_func_array(array($this, $method), $get_args);
            }
        }

        public function __construct5($gardenID,$gardenPassword,$emailAddress,$gardenLocation,$region) {
            $this->gardenID = $gardenID;
            $this->gardenPassword = $gardenPassword;
            $this->emailAddress = $emailAddress;
            $this->gardenLocation = $gardenLocation;
            $this->region = $region;
        }

        public function getGardenID(){
            return $this->gardenID;
        }

        public function getGardenPassword(){
            return $this->gardenPassword;
        }

        public function getGardenLocation(){
            return $this->gardenLocation;
        }

        public function getGardenRegion(){
            return $this->region;
        }

        public function getEmailAddress(){
            return $this->emailAddress;
        }

        public function setEmailAddress($emailAddress){
            $this->emailAddress = $emailAddress;
        }

        public function getAdminName(){
            return $this->adminName;
        }

        public function setAdminName($adminName){
            $this->adminName = $adminName;
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
    }
?>
