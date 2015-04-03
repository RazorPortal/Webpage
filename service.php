<?php
        //create connection
        $con = mysqli_connect("localhost", "root", "tu3xooGh", "razorportal");

        //check connection
        if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        //selects ALL from table
        $sql = "select * from schedule;";

        //check if there are results
        if ($result = mysqli_query($con, $sql)) {
                //if so, create a results array and a temp one
                //to hold data
                $resultArray = array();
                $tempArray = array();

                //loop through each row in result set
                while ($row = $result->fetch_object()) {
                        //add each row into results array
                        $tempArray = $row;
                        array_push($resultArray, $tempArray);
                }

                //encode array to JSON and output the results
                echo json_encode($resultArray);
        }

        //close connections
        mysqli_close($con);
?>
