<?php
/**
 * Date Difference Class
 * Description: Provide interval / differences measurement between 2 supplied dates.
 * Author: Steven Gunarso
 * Version: 1.0.0
 * PHP requires at least: 5.4.0
 * PHP tested with: 5.6.35 
 * @used-by difference_processing.php
 */
class DateDifferences {
	private $first_date, $second_date;

	/**
	 * Class constructor. Called when an object of this class is instantiated.
	 * 
	 * @since	1.0.0
	 */
	public function __construct($first_date, $second_date) {
		$this->first_date = $first_date;
		$this->second_date = $second_date;
	}

	/**
	 * First Challenge: Find how many days of difference between the dates
	 *
	 * @since	1.0.0
	 * @return	int			The date difference in number of days 
	 * @uses	strtotime 	Since PHP 4
	 * @uses	abs  		Since PHP 4
	 * @uses	intval  	Since PHP 4
	 **/
	public function first_challenge() {
		$first_date_seconds = strtotime($this->first_date);
		$second_date_seconds = strtotime($this->second_date);

		# Abs is used here because it because first date and second date are not "chronological"
		# Therefore the second date might be in the "past" in comparison to first date
		$difference = abs($first_date_seconds - $second_date_seconds);

		# convert back the differences in seconds to days
		$day_difference = intval( $difference / 3600 / 24);

		return $day_difference;
	}

	/**
	 * Second Challenge: Find how many weekdays (working days) between the dates 
	 *
	 * @since	1.0.0
	 * @return	int					The number of weekdays 
	 * @uses	strtotime 			Since PHP 4
	 * @uses	DateTime   			Since PHP 5.2
	 * @uses	DateInterval   		Since PHP 5.3
	 * @uses	DatePeriod  		Since PHP 5.3
	 * @uses	DateTime::format 	Since PHP 5.2.1 
	 **/
	public function second_challenge() {
		
		# Instantiate the DateTime objects
		# In this case, we need to ensure that the second date object is always the "Later" date compared to first date object
		if( strtotime($this->first_date) < strtotime($this->second_date) ) {
			$first_date_object = new DateTime($this->first_date);
	        $second_date_object = new DateTime($this->second_date);
		}
		else {
			$first_date_object = new DateTime($this->second_date);
	        $second_date_object = new DateTime($this->first_date);
		}

        # Date Interval class is utilised to allows a for loop of the range
        $interval = new DateInterval('P1D');

        # Generate a Date Range based on the dates and interval
        $date_range = new DatePeriod($first_date_object, $interval, $second_date_object);

        # Finally, count the weekdays between the interval
        # $date->format("N") will return the day as numbers, e.g. Monday is 1, Sunday is 7
        $total_days = 0;
        foreach ($date_range as $date) {

         	if ( $date->format("N") >= 1 && $date->format("N") < 6 ) {
                $total_days++; 
          	}
        }
        
        return $total_days;
	}

	/**
	 * Getter Function for First Date
	 *
	 * @since	1.0.0
	 * @return	string		The human-friendly date format stored within the first_date variable
	 **/
	public function get_first_date() {
		return $this->first_date;
	}

	/**
	 * Setter Function for First Date.
	 *
	 * @since	1.0.0
	 * @param	string	$first_date		Human-Friendly format of date in a string
	 **/
	public function set_first_date($first_date) {
		$this->first_date = $first_date;
	}

	/**
	 * Getter Function for Second Date
	 *
	 * @since	1.0.0
	 * @return	string		The human-friendly date format stored within the second_date variable
	 **/
	public function get_second_date() {
		return $this->second_date;
	}

	/**
	 * Setter Function for Second Date.
	 *
	 * @since	1.0.0
	 * @param	string	$second_date		Human-Friendly format of date in a string
	 **/
	public function set_second_date($second_date) {
		$this->second_date = $second_date;
	}
}
?>