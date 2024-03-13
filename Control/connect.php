<?php
    /**
     * OpenCon
     * 
     * This function starts the connection to the local server mySQL database
     * Our web application currently uses mySQL for all our databases
     */
    function OpenCon()
    {
    $server_name = "localhost";
    $username = "root";
    $password = ""; // default pw is blank
    $database_name = "database";


    $conn = mysqli_connect($server_name,$username,$password,$database_name) or die("Connect failed: %s\n". $conn -> error);


    return $conn;
    }

    /**
     * CloseCon
     * 
     * This function closes the connection to the local server mySQL database
     * Our web application currently uses mySQL for all our databases
     * 
     * @param mixed $conn   Existing open connection
     */
    function CloseCon($conn)
    {
    $conn -> close();
    }

?>
