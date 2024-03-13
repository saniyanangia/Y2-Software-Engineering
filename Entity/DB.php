<?php
    class DB{
        private $conn;
        private $host = "localhost";
        private $username = "root";
        private $password = ""; // default pw is blank
        private $db = "database"; // go to phpmyadmin to check your database name ,, i created one called test

        public function __construct(){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            try {
                $this->conn = new mysqli($this->host,$this->username,$this->password,$this->db);
            } catch (mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
        }

        public function __destruct(){
            if(!empty($this->conn))
                $this->conn->close();
        }

        public function getConn() : mysqli{
            return $this->conn;
        }
    }
?>
