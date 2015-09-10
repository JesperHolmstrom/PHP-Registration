<?php

class DateTimeView {


	public function show() {
		$timeString = date('l') . ", the " . date('j') . $this->getSuffix(date('j')) . " of " . date('F') . " " . date('o') . ", The time is " . date('H:i:s'); //Save the current time to $timeString

		return '<p>' . $timeString . '</p>';
	}

	/* Returns the suffix of a specific date */
	public function getSuffix($dayNumber){
		assert($dayNumber > 0 || $dayNumber <= 31); //Make sure no invalid dates are passed to the function
		if($dayNumber == 1 || $dayNumber == 21 || $dayNumber == 31){
			return "st";
		}
		else if($dayNumber == 2 || $dayNumber == 22){
			return "nd";
		}
		else if($dayNumber == 3 || $dayNumber == 23){
			return "rd";
		}
		else{
			return "th";
		}
	}

}