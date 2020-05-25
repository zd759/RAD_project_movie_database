
<?php
    // Web Programming
    // Name: Alan Pedersen
    // ID: P225139
    // Date: 3/04/2020
    // Project 
    // script to list rating values
    // return list for selection in form

// use the connection to the database
require "connect.pdo.php";

// build the SQL command to list rating values
try {
    $sql = $conn->prepare("SELECT RatingCode FROM tblLibRating");

    // submit the SQL command
    $sql->execute();

    // initialise the variables
    $selected = "";
    $unselected = "";

    // add the 'any' option to the list
    echo '<option value="any"> any </option>';

    // output each rating from the table
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        // has the form been posted and this value selected
        if (isset($_POST["rating"]) 
            && (array_search($row["RatingCode"], $_POST["rating"]) !== false)
        ) {
            $selected = $selected . '<option value="' . $row["RatingCode"] . 
              '" selected >' . $row["RatingCode"] . "</option>";

        } else {
            $unselected = $unselected . '<option value="' . $row["RatingCode"] . 
            '" >' . $row["RatingCode"] . "</option>";

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
