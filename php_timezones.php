<?php
/**
 * PHP Timezones Handler Section
 * Description: Handler Section to process the Timezone Selectors creation automatically
 * Author: Steven Gunarso
 * Version: 1.0.0
 * PHP requires at least: 5.4.0
 * PHP tested with: 5.6.35
 */


/**
 * Create Timezone Selector Function
 *
 * Note: This is a modified codes from the source specified at the "see" section
 *
 * @since 1.0.0
 * @see https://gist.github.com/Xeoncross/1204255
 * 
 * @uses Class DateDifferences                  Date differential comparison class 
 * @uses DateDifferences::output_calculations   Calculation Output Function from Date Differences Class
 */
function create_timezone_selector( $element_name = "timezone", $posted_data = array() ) {

    $regions = array(
        'Australia'     =>  DateTimeZone::AUSTRALIA,
        'Africa'        =>  DateTimeZone::AFRICA,
        'America'       =>  DateTimeZone::AMERICA,
        'Asia'          =>  DateTimeZone::ASIA,
        'Europe'        =>  DateTimeZone::EUROPE
    );

    $posted_value = "";
    # Handle the posted data to retain posted values
    if( !empty($posted_data[$element_name]) && strlen($posted_data[$element_name]) > 0 ) {
        $posted_value = $posted_data[$element_name];
    }


    # Tidying the DateTimeZone Identifiers
    $timezones = array();
    foreach ($regions as $name => $mask)
    {
        $zones = DateTimeZone::listIdentifiers($mask);
        foreach($zones as $timezone)
        {
            $timezones[$name][$timezone] = substr($timezone, strlen($name) + 1);
        }
    }


    # Construct the timezone selector
    echo "<select id='timezone' name='" . $element_name . "'>";
    foreach($timezones as $region => $list) {
        echo "<optgroup label='" . $region . "'>";

        foreach($list as $timezone => $name) {

            $selected = " ";

            if( $posted_value == $timezone ) {
                $selected = " selected='selected' ";
            }

            echo "<option" . $selected . "value='" . $timezone . "'>" . $name . "</option>";
        }
        echo "</optgroup>";
    }
    echo "</select>";
}
?>