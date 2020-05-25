<!DOCTYPE html>
<html lang="en">
<!--
    Web Programming
    Name: Alan Pedersen
    ID: P225139
    Date: 3/04/2020
    Project 
    Movie Search Page
-->

<head>
    <meta charset="UTF-8">
    <title>Movie Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- import compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- import jQuery library -->
    <script src="jquery.min.js"></script>
    <!-- import compiled JavaScript -->
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="demo.css">

</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <H1 class="col-md-3">SMT Movie Rental</H1>
            <ul class="nav navbar-nav col-md-9">
                <li class="active"><a href="SearchMovies.php">search form</a></li>
                <li><a href="Top10.php">top 10 movies</a></li>
            </ul>
        </div>
    </nav>
    <section class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <form  name="searchForm"  autocomplete="off"  
                   action="SearchMovies.php" method="post">
                <div class="col-md-4">
                    <h1>Movie Search</h1>
                    <div class="form-group row">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" size="25"
                        value="<?php if (isset($_POST["title"])) echo $_POST["title"];?>" 
                        title="enter part of a title to search for">
                    </div>

                    <div class="form-group row">
                        <label for="yearFrom">Year From: </label>
                        <input type="number" name="yearFrom" id="yearFrom" 
                               maxlength="4" size="4"
                               <?php require 'movie_year_limits_scr.php'; ?>
                               title="first year in search range"
                               value="<?php if (isset($_POST["yearFrom"])) 
                                      echo $_POST["yearFrom"];?>">

                        <label for="yearTo">Year To: </label>
                        <input type="number" name="yearTo"  id="yearTo"  
                               maxlength="4" size="4"
                               <?php require 'movie_year_limits_scr.php'; ?>
                               title="last year in search range"
                               value="<?php if (isset($_POST["yearTo"])) 
                                      echo $_POST["yearTo"];?>">
                    </div>
    
                    <input type="submit" value="search movies" name="search">
                    <!-- <input type="reset" value="clear search terms"> -->

                </div>
                <div class="col-md-2">
                    <div class="form-group row">
                        <label for="genre">Genre:</label>
                    </div>
                    <div class="form-group row">
                        <select name="genre[]" id="genre" 
                                size="10" style="width: 150px;"
                                title="select one or more genre values" multiple>
                            <?php require 'movie_list_genre_scr.php'; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group row">
                        <label for="rating">Rating:</label>
                    </div>
                    <div class="form-group row">
                        <select name="rating[]" id="rating" 
                                size="10" style="width: 150px;"
                                title="select one or more ratings" multiple>
                            <?php require 'movie_list_rating_scr.php'; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group row">
                        <label for="sortBy">Sort By:</label>
                    </div>
                    <div class="form-group row">
                        <select list="listSortBy" name="sortBy" 
                                id="sortBy" size="10" style="width: 150px;"
                                title="select value to results sort by">
                            <option value="Title" 
                                <?php if (isset($_POST["sortBy"]) 
                                    && $_POST["sortBy"] == "Title") 
                                    echo "selected";?> 
                                <?php if (!isset($_POST["sortBy"])) 
                                    echo "selected";?>> 
                                Title </option>
                            <option value="StudioName" 
                                <?php if (isset($_POST["sortBy"]) 
                                    && $_POST["sortBy"] == "StudioName") 
                                    echo "selected";?>> 
                                Studio </option>
                            <option value="RecRetPrice" 
                                <?php if (isset($_POST["sortBy"]) 
                                    && $_POST["sortBy"] == "RecRetPrice") 
                                    echo "selected";?>> 
                                Price </option>
                            <option value="RatingCode" 
                                <?php if (isset($_POST["sortBy"]) 
                                    && $_POST["sortBy"] == "RatingCode") 
                                    echo "selected";?>> 
                                Rating </option>
                            <option value="Year" 
                                <?php if (isset($_POST["sortBy"]) 
                                    && $_POST["sortBy"] == "Year") 
                                    echo "selected";?>> 
                                Year </option>
                            <option value="GenreCode" 
                                <?php if (isset($_POST["sortBy"]) 
                                    && $_POST["sortBy"] == "GenreCode") 
                                    echo "selected";?>> 
                                Genre </option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

    </section>
    <section class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <H1>Movie List</H1>
            <?php require 'movie_list_scr.php'; ?>
        </div>
    </section>

</body>

</html>
