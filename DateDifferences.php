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
	 * @return	int		The date difference in number of days 
	 * @uses	strtotime 
	 * @uses	abs 
	 * @uses	intval 
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