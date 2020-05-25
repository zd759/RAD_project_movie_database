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
                <li><a href="SearchMovies.php">search form</a></li>
                <li class="active"><a href="Top10.php">top 10 movies</a></li>
            </ul>
        </div>
    </nav>
    <section class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <h1>Top 10 Movie Searches</h1>
            <?php require 'movie_top_10_chart_scr.php'; ?>

        </div>
    </section>

</body>

</html>
