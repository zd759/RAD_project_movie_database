
<?php
    // Web Programming
    // Name: Alan Pedersen
    // ID: P225139
    // Date: 3/04/2020
    // Project 
    // script to list movies meeting search criteria
    // return list as an HTML table
    // use the connection to the database

// check if the form has been posted
if (isset($_POST['search'])) {
    try {
        // connect to the database
        include "connect.pdo.php";

        // testing flag
        $testingFlag = false;

        // construct the select conditions
        // initialise the strings
        $filter = "";
        $searchTitle = "";
        $searchYear = "";
        $searchGenre = "";
        $searchRating = "";
        $sortOrder = "";
        
        // clean the title search string
        $searchTitle = cleanInput($_POST["title"]);
        // if we have a value make the search string
        if (strlen($searchTitle) > 0) {
            $filter = "WHERE Title like '%" . $searchTitle . "%'";
        }

        // echo the filter
        if ($testingFlag) { 
            echo "filter title: " . $filter . "<br>";
        }

        // clean the year values
        $searchYearFrom = cleanInput($_POST["yearFrom"]);
        $searchYearTo = cleanInput($_POST["yearTo"]);

        // test for both values
        if (strlen($searchYearFrom) > 0 and strlen($searchYearTo) > 0) {
            // test relative values of years
            if ($searchYearTo >= $searchYearFrom) {
                // search between from and to years
                $searchYear = "( Year >= " . $searchYearFrom . 
                " AND Year <= " . $searchYearTo . ")";
                 
            } else {
                // if from > to reverse search
                // search >= to <= from
                $searchYear = "( Year >= " . $searchYearFrom . 
                " OR Year <= " . $searchYearTo . ")";

            }

        } elseif (strlen($searchYearFrom) > 0 ) {
            // from value only
            $searchYear = "Year >= " . $searchYearFrom;

        } elseif (strlen($searchYearTo) > 0 ) {
            // to value only
            $searchYear = "Year <= " . $searchYearTo;

        }

        // add the year search if required
        $filter = buildFilter($filter, $searchYear);

        // echo the filter
        if ($testingFlag) { 
            echo "filter date: " . $filter . "<br>";
        }

        // genre filter
        if (isset($_POST["genre"])) {
            // count of number of genres
            $genreCount = 0;
            // initialise the list of values
            $searchGenre = buildInList("GenreCode", $_POST["genre"]);

        }

        // add the genre search if required
        $filter = buildFilter($filter, $searchGenre);

        // echo the filter
        if ($testingFlag) { 
            echo "filter genre: " . $filter . "<br>";
        }

        // rating filter
        if (isset($_POST["rating"])) {
            // count of number of ratings
            $ratingCount = 0;
            // initialise the list of values
            $searchRating = buildInList("RatingCode", $_POST["rating"]);

        }

        // add the rating search if required
        $filter = buildFilter($filter, $searchRating);

        // echo the filter
        if ($testingFlag) { 
            echo "filter rating: " . $filter . "<br>";
        }

        // set the sort order
        if (isset($_POST["sortBy"])) {
            // set the sort command string
            $sortOrder = " ORDER BY " . cleanInput($_POST["sortBy"]);
        } else {
            // just in case nothing is set
            $sortOrder = " ORDER BY Title";

        }

        // create the sql commands 
        $sqlCommand = "SELECT * FROM vwMovieList " . $filter . $sortOrder;

        // echo the command
        if ($testingFlag) { 
            echo "sql: " . $sqlCommand . "<br>";
        }

        // prepare the SQL command to list movies
        $sql = $conn->prepare($sqlCommand);

        // run the SQL command
        $sql->execute();

        // count the number of rows
        $numRecs = $sql->rowCount();
        if ($testingFlag) { 
            echo "num recs: " . $numRecs . "<br>";
        }

        // test for returned records
        if ($numRecs > 0) {
            // output the table header
            echo '<table class="table table-striped" id="movieTable">';
            echo "<tr><th>Title</th><th>Studio</th><th>Price</th>";
            echo "<th>Rating</th><th>Year</th><th>Genre</th></tr>";
            // output data of each row
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>" . 
                "<td>" . $row['Title'] . "</td>" .
                "<td>" . $row['StudioName'] . "</td>" .
                "<td>" . $row['RecRetPrice'] . "</td>" .
                "<td>" . $row['RatingCode'] . "</td>" .
                "<td>" . $row['Year'] . "</td>" .
                "<td>" . $row['GenreCode'] . "</td>" .
                "</tr>";
            }
            // finish the table
            echo "</table>";
        } else {
            // output the table header
            echo '<table class="table table-striped" id="movieTable">';
            echo "<tr><th>Title</th><th>Studio</th><th>Price</th>";
            echo "<th>Rating</th><th>Year</th><th>Genre</th></tr>";
            // finish the table
            echo "</table>";

            echo '<div>';
            echo "<H2>sorry no movies were found matching the search criteria</H2>";
            echo "</div>";

        }

        // update the search count records
        // create the sql commands to add any required records
        $sqlCommand = "INSERT INTO tbldatasearchcount (IDcount, SearchCount) " .
                      "SELECT IDmovie, NoRecs " .
                      "FROM vwnewcountrecords " . 
                      $filter;

        // run the SQL command
        $numRecs = $conn->exec($sqlCommand);

        // create the query to uppdate the search count
        $sqlCommand = "UPDATE vwMovieList " .  
                      "SET SearchCount = SearchCount + 1 " .
                      $filter;

        // run the SQL command
        $numRecs = $conn->exec($sqlCommand);

        // close the connection
        $conn = null;

    }
    catch(PDOException $e)
    {
        echo "Database error: " . $e->getMessage();
    }
}

// clean up input data
function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace("'", "''", $data);
    return $data;
}

// add a new search term to the filter string
function buildFilter( $filter, $newTerm)
{
    // add the new search term if required
    if (strlen($newTerm) > 0) {
        // add the new search search to the filter string
        if (strlen($filter) > 0) {
            // add the new termto the existing search criteria
            $filter = $filter . " AND " . $newTerm;
        } else {
            // make a new search string
            $filter = "WHERE " . $newTerm;

        }
    }
    
    return $filter;

}

// make the list of value for the IN filter
function buildInList($field, $inList)
{
    // count of number of values
    $count = 0;
    // initialise the any flag
    $anyFound = false;
    // initialise the list of values
    $searchList = $field . " IN ( ";

    // loop through values list
    foreach ($inList as $li) {
        // clean the value
        $value = cleanInput($li);

        // test for 'any' value
        if ($value == "any") {
            $anyFound = true;
            break;
        }

        // add each value
        // test for the second and subsequent values
        if ($count > 0) {
            // subsequent values add a comma to seperate the list items
            $searchList = $searchList . ",";

        }

        // add the value
        $searchList = $searchList . "'" . $value . "'";

        // increment the counter
        $count++;

    }

    // test for any value selected
    if ($anyFound) {
        $searchList = "";
    } else {
        // finish the search string
        $searchList = $searchList . ")";
    }

    // return the finshed string
    return $searchList;

}


?>
