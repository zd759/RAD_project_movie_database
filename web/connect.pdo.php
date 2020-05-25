<?php	  
    // Web Programming
    // Name: Alan Pedersen
    // ID: P225139
    // Date: 3/04/2020
    // Project 
    // script to create a connection to the database

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "movie_db";

// Create connection using PDO
try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname", 
        $username, $password
    );

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully<br>";
        

}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}
    
?>
