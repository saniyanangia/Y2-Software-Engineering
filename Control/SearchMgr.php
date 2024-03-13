<?php 
include 'conn.php'; 
    /**
     * searchResources
     * Takes in a string input of a plant name, and returns any relevant gardening resources pertaining to the user input.
     * 
     * Searches in the searchgarden database by doing a SQL query that checks if the user input matches with any plant's Name (plantName variable).
     * 
     * @param  String $searchInput   User input to search for plants 
     * @return MYSQLI_BOTH $row         a row from the searchGarden database
     */
    function searchResources($searchInput){ 
        $conn = OpenCon();
        $row = [];
        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `searchgarden` WHERE plantName LIKE '$searchInput'";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_array($result);
        CloseCon($conn);
        return $row;
    }
?>