
<!--
    Web Programming
    Name: Alan Pedersen
    ID: P225139
    Date: 13/03/2020
    Project code
    Create the Top 10 chart
-->

<?php
    // set the font & path 
    $font = "C:\\Windows\\Fonts\\arial.ttf";

try {
    // connect to the database
    include "connect.pdo.php";

    // create the sql commands 
    $sqlCommand = "SELECT * FROM vwGetTop10records ";

    // prepare the SQL command to list movies
    $sql = $conn->prepare($sqlCommand);

    // run the SQL command
    $sql->execute();

    // get the results from the query
    $number_list = $sql->fetchAll();

}
catch(PDOException $e)
{
    echo "Database error: " . $e->getMessage();
}

    // chart layout variables
    // page size
    $page_width = 640;
    $page_height = 480;
    // origin position for the chart area
    $chart_origin_x = 50;
    $chart_origin_y = 60;
    // chart size
    $chart_width = 500;
    $chart_height = 380;
    // chart area
    $chart_bound_x = $chart_origin_x + $chart_width;
    $chart_bound_y = $chart_origin_y + $chart_height;


    // bar controls
    $bar_width = 40;
    $bar_gap = 10;
    $bar_first_pos = 5 + $chart_origin_x;
    $bar_max_value = 0;
    $bar_max_height = $chart_height - $bar_gap;

    // dump the array of values
    // var_dump($number_list);

// find the highest value in the array
for ( $i = 0; $i < 10; $i++) {
    $val = $number_list[$i]['SearchCount'];
    $bar_max_value = max($bar_max_value, $val);
}

    // calculate the spacing between the grid lines
    // around 5 grid lines should be drawn
    // calculate the data units between each grid line
    $grid_spacing_data_units = round($bar_max_value/5);
    // calculate the pixel gap between the grid lines
    $grid_spacing_plot_units 
        = $bar_max_height / ($bar_max_value/$grid_spacing_data_units);
    // calculate the position of the first grid line
    $grid_first = $chart_bound_y - $grid_spacing_plot_units;

    // create the base for the chart
    $chart = imagecreate($page_width, $page_height);
    
    $backgroundColour = imagecolorallocate($chart, 222, 235, 247);
    imagefill($chart, 0, 0, $backgroundColour);

    // add the colours to the image
    $white = imagecolorallocate($chart, 0xFF, 0xFF, 0xFF);
    $black = imagecolorallocate($chart, 0, 0, 0);
    $red = imagecolorallocate($chart, 0xFF, 0x00, 0x00);

    // draw the chart plotting area
    imagefilledrectangle(
        $chart, $chart_origin_x, $chart_origin_y, 
        $chart_bound_x, $chart_bound_y, $white
    );

    // loop through the array adding the bars
    for ( $i = 0; $i < 10; $i++) {
        // calculate the location for the bar
        $bar_orig_x = $bar_first_pos + ( $bar_gap * $i) + ( $bar_width * $i);
        $bar_height = (float) $number_list[$i]['SearchCount'] 
            / (float) $bar_max_value;
        $bar_orig_y = $chart_bound_y - ( $bar_height * $bar_max_height);
        $bar_bound_x = $bar_orig_x + $bar_width;
        $bar_bound_y = $chart_bound_y;
        // var_dump( 
        //     $bar_orig_x, $bar_orig_y, $bar_bound_x, 
        //     $bar_bound_y, $bar_height, $bar_max_value
        // );
        // add the bar
        imagefilledrectangle(
            $chart, $bar_orig_x, $bar_orig_y, 
            $bar_bound_x, $bar_bound_y, $red
        );
        // add a label to the bar with the countvalue
        imagettftext(
            $chart, 10, 90, $bar_orig_x + ($bar_width/2) + 5, $bar_bound_y - 5, 
            $black, $font, $number_list[$i]['Title']
        );

        // set the label for each bar
        imagettftext(
            $chart, 10, 0, $bar_orig_x + 15, $chart_bound_y + 15, 
            $black, $font, $number_list[$i]['SearchCount']
        );

    }    

    // add a boundary to the chart area
    imagerectangle(
        $chart, $chart_origin_x, $chart_origin_y, 
        $chart_bound_x, $chart_bound_y, $black
    );

    // intialist the grid line postion
    $grid_line = $grid_first;
    // initialise the grid value
    $grid_value = $grid_spacing_data_units;
    // working counter
    $counter = 0;
    // draw the grid lines on the chart
    while ( $grid_line > $chart_origin_y) {
        // draw each grid line
        imageline(
            $chart, $chart_origin_x, $grid_line, 
            $chart_bound_x, $grid_line, $black
        );
        // add the grid label
        imagettftext(
            $chart, 10, 0, $chart_origin_x - 15, $grid_line + 5, 
            $black, $font, $grid_value
        );
        // increment the counter
        $counter++;
        // update the grid annotation value
        $grid_line = $grid_first - ( $grid_spacing_plot_units * $counter);
        // update the grid value
        $grid_value = $grid_spacing_data_units + 
            ( $grid_spacing_data_units * $counter);
    }

    // axis titles
    imagettftext(
        $chart, 12, 90, 20, $chart_bound_y - 120, 
        $black, $font, "number of searches"
    );
    imagettftext(
        $chart, 12, 0, 210, $chart_bound_y + 30, 
        $black, $font, "move title & search count"
    );

    // chart title
    imagettftext(
        $chart, 20, 0, $chart_origin_x, $chart_origin_y - 10, 
        $black, $font, "top 10 searched for movies"
    );

    // draw the chart
    imagepng($chart, "tempChart.png", 9);
    imagedestroy($chart);

    echo "<img src='tempChart.png'><p></p>";

?>
