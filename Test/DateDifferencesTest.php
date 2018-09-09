<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../DateDifferences.php';

final class DateDifferencesTest extends TestCase {

   	# Initialise test values
   	private $first_date = "2018-08-31T01:01";
   	private $second_date = "2018-08-03T01:00";
   	private $interval_conversion = "";
   	private $first_timezone = "Australia/Melbourne";
   	private $second_timezone = "Australia/Melbourne";

   	public function testFirstChallenge(): void {

   		# Use "Reflection" Class because the function is private
   		$first_challenge = self::getMethod('first_challenge');
		$date_diff = new DateDifferences($this->first_date, $this->second_date, $this->interval_conversion, 
			$this->first_timezone, $this->second_timezone);
		
		$result = $first_challenge->invokeArgs($date_diff, array());

		$this->assertEquals($result, 28);
	}

   	public function testSecondChallenge(): void {

   		$second_challenge = self::getMethod('second_challenge');
		
		$date_diff = new DateDifferences($this->first_date, $this->second_date, $this->interval_conversion, 
			$this->first_timezone, $this->second_timezone);

		$result = $second_challenge->invokeArgs($date_diff, array());

		$this->assertEquals($result, 20);
	}

   	public function testThirdChallenge(): void {

   		$third_challenge = self::getMethod('third_challenge');
		
		$date_diff = new DateDifferences($this->first_date, $this->second_date, $this->interval_conversion, 
			$this->first_timezone, $this->second_timezone);

		$result = $third_challenge->invokeArgs($date_diff, array());

		$this->assertEquals($result, 4);
	}

   	public function testFirstChallengeConvertSeconds(): void {

   		$first_challenge = self::getMethod('first_challenge');
   		$convert_calculation_result = self::getMethod('convert_calculation_result');
		
		$date_diff = new DateDifferences($this->first_date, $this->second_date, "seconds", 
			$this->first_timezone, $this->second_timezone);

		$result = $first_challenge->invokeArgs($date_diff, array());
		$result = $convert_calculation_result->invokeArgs($date_diff, array($result));

		$this->assertEquals($result, 2419200);
	}

   	public function testSecondChallengeConvertMinutes(): void {

   		$second_challenge = self::getMethod('second_challenge');
   		$convert_calculation_result = self::getMethod('convert_calculation_result');
		
		$date_diff = new DateDifferences($this->first_date, $this->second_date, "minutes", 
			$this->first_timezone, $this->second_timezone);

		$result = $second_challenge->invokeArgs($date_diff, array());
		$result = $convert_calculation_result->invokeArgs($date_diff, array($result));

		$this->assertEquals($result, 28800);
	}

   	public function testThirdChallengeConvertHours(): void {

   		$third_challenge = self::getMethod('third_challenge');
   		$convert_calculation_result = self::getMethod('convert_calculation_result');
		
		$date_diff = new DateDifferences($this->first_date, $this->second_date, "hours", 
			$this->first_timezone, $this->second_timezone);

		$result = $third_challenge->invokeArgs($date_diff, array());
		$result = $convert_calculation_result->invokeArgs($date_diff, array($result, "weeks"));

		$this->assertEquals($result, 672);
	}

   	public function testFirstChallengeDifferentTimezones(): void {

   		$first_challenge = self::getMethod('first_challenge');
   		$convert_calculation_result = self::getMethod('convert_calculation_result');
		
		$date_diff = new DateDifferences("2018-08-01T10:02", "2018-08-02T16:01", NULL, 
			"Australia/Melbourne", "America/Detroit");

		$result = $first_challenge->invokeArgs($date_diff, array());
		$result = $convert_calculation_result->invokeArgs($date_diff, array($result));

		$this->assertEquals($result, 1);
	}

   	public function testSecondChallengeDifferentTimezonesConvertHours(): void {

   		$first_challenge = self::getMethod('first_challenge');
   		$convert_calculation_result = self::getMethod('convert_calculation_result');
		
		$date_diff = new DateDifferences("2018-08-01T10:02", "2018-08-02T16:01", "hours", 
			"Australia/Melbourne", "America/Detroit");

		$result = $first_challenge->invokeArgs($date_diff, array());
		$result = $convert_calculation_result->invokeArgs($date_diff, array($result));

		$this->assertEquals($result, 24);
	}

   	protected static function getMethod($name) {
   		# Reflection Class is required for testing private methods
  		$class = new ReflectionClass('DateDifferences');
  		$method = $class->getMethod($name);
  		$method->setAccessible(true);

  		return $method;
	}
}
?>