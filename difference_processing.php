<?php
/**
 * PHP Processing Section
 * Description: Handle the POST from the index.phtml and utilise the DateDifferences class to perform the differential function
 * Author: Steven Gunarso
 * Version: 1.0.0
 * PHP requires at least: 5.4.0
 * PHP tested with: 5.6.35
 * @uses Class DateDifferences 	Date differential comparison class 
 */

include("DateDifferences.php");

# assign POST into variable
if( !empty($_POST["first_date"]) ) {
	$first_date = $_POST["first_date"];
}

if( !empty($_POST["second_date"]) ) {
	$second_date = $_POST["second_date"];
}

# Stop processing if one of the required dates is missing 
if( empty($first_date) OR empty($second_date) ) {
	die("Please fill both date parameters!");
}

# Initialise the Date Differences class
$date_diff = new DateDifferences($first_date, $second_date);
?>