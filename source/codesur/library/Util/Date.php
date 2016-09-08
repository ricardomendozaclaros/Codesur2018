<?php
class Util_Date {

	static function diff($dformat, $endDate, $beginDate) {

		$date_parts1 = explode($dformat, $beginDate);
		$date_parts2 = explode($dformat, $endDate);
		$start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);

		return $end_date - $start_date;
	}

	static function age($birthday) {

		list($year,$month,$day) = explode("-",$birthday);
		$year_diff = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff = date("d") - $day;
		if ($month_diff < 0) $year_diff--;
		elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		return $year_diff;
	}
	function normal_to_mysql($fecha)
	{
		$mifecha=array();
    	ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];    
    	return $lafecha;
	}
	
	function mysql_to_normal($fecha)
	{
		$mifecha=array();
    	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    	return $lafecha;
	} 

}