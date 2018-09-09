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
	private $first_date, $second_date, $first_timezone, $second_timezone;
	private $interval_conversion;

	/**
	 * Class constructor. Called when an object of this class is instantiated.
	 * 
	 * @since	1.0.0
	 * @param	string	$first_date				First date formatted in "human-friendly" string
	 * @param	string	$second_date			Second date formatted in "human-friendly" string
	 * @param	string	$interval_conversion	Conversion metric - Possible Values: seconds, minutes, hours, days, years
	 * @param	string	$first_timezone			First Timezone to be used
	 * @param	string	$second_timezone		Second Timezone to be used
	 */
	public function __construct($first_date, $second_date, $interval_conversion, 
		$first_timezone = "Australia/Melbourne", $second_timezone = "Australia/Melbourne") {

		$this->first_date = $first_date;
		$this->second_date = $second_date;
		$this->interval_conversion = $interval_conversion;
		$this->first_timezone = $first_timezone;
		$this->second_timezone = $second_timezone;
	}

	/**
	 * First Challenge: Find how many days of difference between the dates
	 *
	 * @since	1.0.0
	 * @return	int			The date difference in number of days 
	 * @uses	DateTime 			Since PHP 5.2
	 * @uses	DateTime::format 	Since PHP 5.2.1
	 * @uses	DateTimeZone 		Since PHP 5.2.0
	 * @uses	abs  				Since PHP 4
	 * @uses	intval  			Since PHP 4
 	 * @used-by self::output_calculations()
	 **/
	private function first_challenge() {
		$first_date = new DateTime($this->first_date, new DateTimeZone($this->first_timezone));
		$first_date_seconds = $first_date->format('U');

		$second_date = new DateTime($this->second_date, new DateTimeZone($this->second_timezone));
		$second_date_seconds = $second_date->format('U');

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
	 *
	 * @since	1.0.0
	 * @return	int					The number of weekdays 
	 * @uses	strtotime 			Since PHP 4
	 * @uses	DateTime 			Since PHP 5.2
	 * @uses	DateTime::format 	Since PHP 5.2.1
	 * @uses	DateTime::modify 	Since PHP 5.2.0
	 * @uses	DateTimeZone 		Since PHP 5.2.0
	 * @uses	DateInterval   		Since PHP 5.3
	 * @uses	DatePeriod  		Since PHP 5.3
	 * @uses	DateTime::format 	Since PHP 5.2.1 
 	 * @used-by self::output_calculations()
	 **/
	private function second_challenge() {
		
		# Instantiate the DateTime objects
		$first_date = new DateTime($this->first_date, new DateTimeZone($this->first_timezone));
		$second_date = new DateTime($this->second_date, new DateTimeZone($this->second_timezone));

		# In this case, we need to ensure that the second date object is always the "Later" date compared to first date object
		# Initiate the swap
		if( $first_date->format('U') > $second_date->format('U') ) {
			$temp = $first_date;
			$first_date = $second_date;
			$second_date = $temp;
		}

        # Date Interval class is utilised to allows a for loop of the range
        $interval = new DateInterval('P1D');

        # Close a weakness on the code where the Date Interval not taking the "time" differences into account 
        $time_diff = $second_date->format('U') - $first_date->format('U');
        $time_diff = $time_diff % (3600 * 24);

        if( $time_diff ) {
        	$second_date->modify("-1 day");
        }

        # Generate a Date Range based on the dates and interval
        $date_range = new DatePeriod($first_date, $interval, $second_date);

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
	 * Third Challenge: Find how many complete weeks between the dates
	 * 
	 * Note: I am unsure what "complete weeks" means in this case.
	 * I understand that it could mean any 7 days interval between dates or "Monday to Sunday" sets.
	 * 
	 * Assumptions: The simpler definition of "complete weeks" is the correct one (7 days interval).
	 *
	 * @since	1.0.0
	 * @return	int			The date difference in number of days 
	 * @uses	DateTime 			Since PHP 5.2
	 * @uses	DateTime::format 	Since PHP 5.2.1
	 * @uses	DateTimeZone 		Since PHP 5.2.0
	 * @uses	abs  		Since PHP 4
	 * @uses	intval  	Since PHP 4
 	 * @used-by self::output_calculations()
	 **/
	private function third_challenge() {
		$first_date = new DateTime($this->first_date, new DateTimeZone($this->first_timezone));
		$first_date_seconds = $first_date->format('U');

		$second_date = new DateTime($this->second_date, new DateTimeZone($this->second_timezone));
		$second_date_seconds = $second_date->format('U');

		# Abs is used here because it because first date and second date are not "chronological"
		# Therefore the second date might be in the "past" in comparison to first date
		$difference = abs($first_date_seconds - $second_date_seconds);

		# convert back the differences in seconds to days
		$week_difference = intval( $difference / 3600 / 24 / 7);

		return $week_difference;
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

	/**
	 * Getter Function for Interval Conversion
	 *
	 * @since	1.0.0
	 * @return	string		The Interval Conversion value
	 **/
	public function get_interval_conversion() {
		return $this->interval_conversion;
	}

	/**
	 * Setter Function for Interval Conversion.
	 *
	 * @since	1.0.0
	 * @param	string	$second_date		Interval Conversion String
	 **/
	public function set_interval_conversion($interval_conversion) {
		$this->interval_conversion = $interval_conversion;
	}

	/**
	 * Getter Function for First Timezone
	 *
	 * @since	1.0.0
	 * @return	string		The timezone string
	 **/
	public function get_first_timezone() {
		return $this->first_timezone;
	}

	/**
	 * Setter Function for First Timezone.
	 *
	 * @since	1.0.0
	 * @param	string	$first_timezone		The timezone string
	 **/
	public function set_first_timezone($first_timezone) {
		$this->first_timezone = $first_timezone;
	}

	/**
	 * Getter Function for Second Timezone
	 *
	 * @since	1.0.0
	 * @return	string		The timezone string
	 **/
	public function get_second_timezone() {
		return $this->second_timezone;
	}

	/**
	 * Setter Function for Second Timezone.
	 *
	 * @since	1.0.0
	 * @param	string	$first_timezone		The timezone string
	 **/
	public function set_second_timezone($second_timezone) {
		$this->second_timezone = $second_timezone;
	}

	/**
	 * Calculation output function used to output the 3 calculations into the front-end.
	 * 
	 * Note: This function is utilised to provide a single point of input-output on the Fourth Challenge (conversions) 
	 *
	 * @since	1.0.0
	 * @uses	self::first_challenge()
	 * @uses	self::second_challenge()
	 * @uses	self::third_challenge()
	 * @uses	self::convert_calculation_result()
	 * 
	 **/
	public function output_calculations() {
		# First challenge
		echo "First Challenge: The difference is " . $this->convert_calculation_result($this->first_challenge()) . 
			" " . (!empty($this->interval_conversion) ? $this->interval_conversion : "days") . "<br/>";

		# Second challenge
		echo "Second Challenge: The number of weekdays is " . $this->convert_calculation_result($this->second_challenge()) . 
			" " . (!empty($this->interval_conversion) ? $this->interval_conversion : "days") . "<br/>";

		# Third challenge
		echo "Third Challenge: The number of full weeks is " . $this->convert_calculation_result($this->third_challenge(), "weeks") . 
			" " . (!empty($this->interval_conversion) ? $this->interval_conversion : "weeks") . "<br/>";
	}

	/**
	 * Fourth Challenge - Calculation conversion function.
	 *
	 * @since	1.0.0
	 * @param	int	$result					Interval Calculations Results
	 * @param	string	$original_metric	String of Metric used within the calculation
	 * @return	int							The conversion result
 	 * @used-by self::convert_calculation_result()
	 *
	 **/
	public function convert_calculation_result($result, $original_metric = "days") {
		# Only convert when the original calculation metric is not the same as the conversion interval metric
		if( $this->interval_conversion == "" || $original_metric == $this->interval_conversion ) {
			return $result;
		}

		# convert the results to number of days - especially important for results from Third Challenge
		if( $original_metric == "weeks") {
			$result = $result * 7;
		}

		if( $this->interval_conversion == "seconds" ) {
			$result = $result * 24 * 3600;
		}
		else if( $this->interval_conversion == "minutes" ) {
			$result = $result * 24 * 60;
		}
		else if( $this->interval_conversion == "hours" ) {
			$result = $result * 24;
		}
		else if( $this->interval_conversion == "years" ) {
			# For the sake of simplicity, we will ignore leap years for now
			$result = intval($result / 365);
		}

		return $result;
	}
}
?>