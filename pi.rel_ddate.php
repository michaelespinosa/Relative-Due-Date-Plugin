<?php

$plugin_info       = array(
	'pi_name'        => 'Relative Due Date Class',
	'pi_version'     => '1.0',
	'pi_author'      => 'Michael Espinosa',
	'pi_author_url'  => 'http://twitter.com/michaelespinosa',
	'pi_description' => 'Returns a class based on the given date and current date (Late, soon, on-time).',
	'pi_usage'       => Rel_ddate::usage()
	);

function getWorkingDays($startDate,$endDate,$holidays){
	$days = ($endDate - $startDate) / 86400 + 1;

  $no_full_weeks = floor($days / 7);
  $no_remaining_days = fmod($days, 7);

  $the_first_day_of_week = date("N",$startDate);
  $the_last_day_of_week = date("N",$endDate);

  if ($the_first_day_of_week <= $the_last_day_of_week){
  	if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
      if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
  }
  else{
  	if ($the_first_day_of_week <= 6) {
    	$no_remaining_days = $no_remaining_days - 2;
    }
  }

  $workingDays = $no_full_weeks * 5;
  if ($no_remaining_days > 0 ) {
  	$workingDays += $no_remaining_days;
  }

  foreach($holidays as $holiday) {
  	$time_stamp=strtotime($holiday);

		if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7) $workingDays--;
  }

  return $workingDays;
}

class Rel_ddate
{

	var $TMPL;
	var $return_data  = "";

	function Rel_ddate()
	{
		global $TMPL;
		$this->TMPL =& $TMPL;
		$data = $TMPL->fetch_param('due_date');

		$holidays=array();
		$now = time();
		$due = strtotime($data);
		$days = getWorkingDays($now,$due,$holidays);

		if ($days < 1) {
			$rel_class = "late";
		} else if ($days > 0 && $days < 5) {
			$rel_class = "soon";
		} else {
			$rel_class = "on_time";
		}

		$this->return_data = $rel_class;
	}

	// ----------------------------------------
	//  Plugin Usage
	// ----------------------------------------

	// This function describes how the plugin is used.
	//  Make sure and use output buffering

	function usage()
	{
	ob_start();
	?>

	There's not much to document here. It just returns a class based on the given date and current date (Late - date has past, soon - within 5 days, on-time - more than 5 days)

	<?php
	$buffer = ob_get_contents();

	ob_end_clean();

	return $buffer;
	}

	}

/* End of file pi.auto_acronym.php */
/* Location: ./system/plugins/pi.rel_ddate.php */
