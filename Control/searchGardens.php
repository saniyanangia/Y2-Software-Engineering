<?php
    // display all gardens
    
    /**
     * searchGardens
     * 
     * Returns information of all community gardens stored in the database.
     *
     * @return void
     */
    function searchGardens(){
        include 'conn.php';
        $conn = OpenCon();

        mysqli_select_db($conn,'database');
        $query = "SELECT * FROM `Admin`";
        $result = mysqli_query($conn,$query);
        echo "<center><table class = 'table'>";
        while($row = mysqli_fetch_array($result)){ 
            echo "<center><tr><td>";
                echo $row['gardenID'] . "</td><td>" . $row['region'] . "</td><td>" . $row['gardenLocation'] . "</td><td>"
                . "<form action = 'gardenPage.php' method = 'POST'>
                <input type='hidden' name='gardenID' value='",$row["gardenID"],"'/>
                <button type='submit' name='View' value='",$row["gardenID"],"'>View </button/>
                </form>";
                echo "</td></tr>";
        }
        echo "</table>";
        CloseCon($conn);
    }
    
    /**
     * filterGardens
     * 
     * Filters all community gardens and narrows down the list of community gardens displayed on the page.
     * This function takes in the inputs of selected region filters using a region array to display gardens in those region.
     * It also helps to filter and search for a specific garden using the garden ID input by user in the search bar.
     * All information is echo-ed out immediately in the table format to the user interface boundary PHP file.
     *
     * @param  String $regions       Array of selected region filters
     * @param  String $gardenID      Garden ID entered in search bar
     * @return void
     */
    function filterGardens($regions,$gardenID){
        if ($regions == NULL && $gardenID == NULL){
            searchGardens(); // call searchGardens to display all gardens if no filter applied
            return;
        }
        include 'conn.php';

        $conn = OpenCon();

        mysqli_select_db($conn,'database');

        $i = 0;
        if($regions[0] != NULL || $gardenID != NULL){
            echo "<center><table class = 'table'>";
        }
        if ($gardenID != NULL){
            $query = "SELECT * FROM `Admin` WHERE gardenID LIKE '$gardenID'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_array($result);
            if ($row){
                echo "<center><tr><td>";
                    echo $row['gardenID'] . "</td><td>" . $row['region'] . "</td><td>" . $row['gardenLocation'] . "</td><td>" 
                    . "<form action = 'gardenPage.php' method = 'POST'>
                    <input type='hidden' name='gardenID' value='",$row["gardenID"],"'/>
                    <button type='submit' name='View' value='",$row["gardenID"],"'>View </button/>
                    </form>";
                    echo "</td></tr>"; 
            }
            
            else{
                echo "No garden with ID: $gardenID";
            }
        }

        else{
            while ($i < sizeof($regions)){
                $region = $regions[$i];
                $query = "SELECT * FROM `Admin` WHERE region LIKE '$region'";
                $result = mysqli_query($conn,$query);
    
                while($row = mysqli_fetch_array($result)){  
                    echo "<center><tr><td>";
                    echo $row['gardenID'] . "</td><td>" . $row['region'] . "</td><td>" . $row['gardenLocation'] . "</td><td>"
                    . "<form action = 'gardenPage.php' method = 'POST'>
                    <input type='hidden' name='gardenID' value='",$row["gardenID"],"'/>
                    <button type='submit' name='View' value='",$row["gardenID"],"'>View </button/>
                    </form>";
                    echo "</td></tr>"; 
                } 
                $i += 1;
            }
        }

        if($regions[0] != NULL || $gardenID != NULL){
            echo "</table>";
        }

        CloseCon($conn);
    }
        
        /**
         * retrieveGarden
         * 
         * This function retrieves garden information when a user searches for a particular garden using garden ID.
         * It echos out the garden information in a table format
         *
         * @param  String $gardenID      Garden ID being searched for by user
         */
        function retrieveGarden($gardenID){
            include 'conn.php';
            $conn = OpenCon();
            
            mysqli_select_db($conn,'database');
                
            $query = "SELECT * FROM `Admin` WHERE gardenID LIKE '$gardenID'";
            $result = mysqli_query($conn,$query);
            
            while($row = mysqli_fetch_array($result)){
                echo "<center><tr><td><h4>";
                echo "<p style='font-size: 20px;text-align: center;width:800px '>{$row['region']}<br>{$row['gardenLocation']}<p>" . "<br></td><td>" . "<p style='font-size: 20px;text-align: center;width:800px '><br><b><u>Admin Details</u></b><p>" . "</td><td>" . "<p style='font-size: 20px;text-align: center;width:800px '>Name: {$row['adminName']}<br>Contact Number: {$row['contactNumber']}<br>Email: {$row['emailAddress']}<br>Preferred Contact: {$row['preferredContact']}<br><p>" . "</td><td></h4>";
                }
                
            CloseCon($conn);
            return;
        }
?>
