
<?php
    // Web Programming
    // Name: Alan Pedersen
    // ID: P225139
    // Date: 3/04/2020
    // Project 
    // script to list get the min and max year values
    // set limits in input elements

// use the connection to the database
require "connect.pdo.php";

// build the SQL command to get the minimum and maximum years
try {
    $sql = $conn->prepare(
        "SELECT MIN(Year) as minYear, 
           MAX(Year) as maxYear FROM tblDataMovies"
    );

    // submit the SQL command
    $sql->execute();

    // get the values
    $result = $sql->fetch();

    // get the min and max values
    $min = $result['minYear'];
    $max = $result['maxYear'];

    // set the min and max values
    echo 'min="' . $min . '" max="' . $max . '"';

}
catch(PDOException $e)
{
    echo "Database error: " . $e->getMessage();
}

// close the connection
$conn = null;

?>
