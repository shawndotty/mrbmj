<?php
use Carbon\Carbon;

if (! function_exists('datesInterval')) {
    function datesInterval($start, $end, $withEnd = 0) {
	        return $end->diff($start)->days + $withEnd; //return how many days overlap
	}
}

if (! function_exists('hasDatesOverlap')) {
    function hasDatesOverlap($start_one,$end_one,$start_two,$end_two) {
	   if($start_one <= $end_two && $end_one >= $start_two) { //If the dates overlap
	        return datesInterval(max($start_one,$start_two),min($end_one,$end_two), 1); //return how many days overlap
	   }
	   return 0; //Return 0 if there is no overlap
	}
}

if (! function_exists('buildDatesRange')) {
    function buildDatesRange($start_date, $end_date) {

    	$datesRange = [];
    	$datesInterval = datesInterval($start_date, $end_date);
    	$datesRange[] = $start_date;
    	
    	for ($i=1; $i <= $datesInterval ; $i++) { 
    		$new_date = $start_date->copy()->addDays($i);
    		$datesRange[] = $new_date;
    	}

    	return $datesRange;
	}
}

