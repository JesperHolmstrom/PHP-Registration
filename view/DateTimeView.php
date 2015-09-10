<?php

class DateTimeView {


	public function show() {

		$timeString = date('l') . ", the " . date('j') . 'th of ' . date('F') . " " . date('o') . ", The time is " . date('H:i:s'); //Save the current time to $timeString

		return '<p>' . $timeString . '</p>';
	}
}