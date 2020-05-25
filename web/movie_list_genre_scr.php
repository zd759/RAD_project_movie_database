
<?php
    // Web Programming
    // Name: Alan Pedersen
    // ID: P225139
    // Date: 3/04/2020
    // Project 
    // script to list genre values
    // return list for selection in form

// use the connection to the database
require "connect.pdo.php";

// build the SQL command to list genre values
try {
    $sql = $conn->prepare("SELECT GenreCode FROM tblLibGenre");

    // submit the SQL command
    $sql->execute();

    // initialise the variables
    $selected = "";
    $unselected = "";

    // add the 'any' option to the list
    echo '<option value="any"> any </option>';

    // output the genre records
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        // has the form been posted and this value selected
        if (isset($_POST["genre"]) 
            && (array_search($row["GenreCode"], $_POST["genre"]) !== false)
        ) {
            $selected = $selected . '<option value="' . $row["GenreCode"] . 
            '" selected >' . $row["GenreCode"] . "</option>";
                    
        } else {
            $unselected = $unselected . '<option value="' . $row["GenreCode"] . 
            '" >' . $row["GenreCode"] . "</option>";

        }

    }

    // first add the selected items
    echo $selected;
    // then the unselected items
    echo $unselected;

}
catch(PDOException $e)
{
    echo "Database error: " . $e->getMessage();
}

// close the connection
$conn = null;

?>
