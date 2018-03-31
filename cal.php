<?php
	require("./auth.php");
	require("./connect.php");
	require("./functions.php");
	
	@$fmonth = $_GET['fmonth'];
	@$fyear = $_GET['fyear'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reminders</title>
<link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

<body>
<?php
	// Get date and time array from server
	$today_date = time();
	
	// Separate the date into parts
	$day = date('d', $today_date);
	$month = date('m', $today_date);
	$year = date('Y', $today_date);
	
	// if date is being forced to the previous or next month
	if ($fmonth) {
		$month = $fmonth;
		$year = $fyear;
	}
	
	// So it doesn't show it's today if it isn't
	if ($month != date('m', time()) || $year != date('Y', time())) {
		$day = 32;
	}
	
	// get timestamp of the first day of the month
	$first_day = mktime(0,0,0,$month,1,$year);
	
	// Name of the month
	$title = date('F', $first_day);
	
	// The day of the week that the first day of the month falls on - 3 letter format
	$day_of_week = date('D', $first_day);
	
	// Figure out what the variables for the numbers of the next and previous month and year should contain
	if ($month == 12) {
		$nmonth = 1;
		$nyear = $year + 1;
		$pmonth = 11;
		$pyear = $year;
	} elseif ($month == 1) {
		$nmonth = $month + 1;
		$nyear = $year;
		$pmonth = 12;
		$pyear = $year - 1;
	} else {
		$nmonth = $month + 1;
		$nyear = $year;
		$pmonth = $month - 1;
		$pyear = $year;
	}
	
	// Find out how many days the previous month has
	$days_last_month = cal_days_in_month(0,$pmonth,$pyear);
	// Find out how many days the current month has
	$days_in_month = cal_days_in_month(0,$month,$year);
	// We don't have to find out how many days next month has
	
	// Find out what number to put in first (grey)
	switch($day_of_week) {
		case "Sun": $blank = 0; break;
		case "Mon": $blank = 1; $grey_num = $days_last_month; break;
		case "Tue": $blank = 2; $grey_num = $days_last_month - 1; break;
		case "Wed": $blank = 3; $grey_num = $days_last_month - 2; break;
		case "Thu": $blank = 4; $grey_num = $days_last_month - 3; break;
		case "Fri": $blank = 5; $grey_num = $days_last_month - 4; break;
		case "Sat":	$blank = 6; $grey_num = $days_last_month - 5; break;
	}
	
	echo "<table border='0' cellpadding='0' cellspacing='0' width='294px'>";
	echo "<tr><th colspan='1'><a style='text-decoration: none;' href='./cal.php?fmonth=" . $pmonth . "&fyear=" . $pyear . "'><<</a></th><th colspan='5'> " . $title . " " . $year . " </th><th colspan='1'><a style='text-decoration: none;' href='./cal.php?fmonth=" . $nmonth . "&fyear=" . $nyear . "'>>></a></th></tr>";
	echo "<tr><td width='42px' class='weekend'>S</td><td width='42px'>M</td><td width='42px'>T</td><td width='42px'>W</td><td width='42px'>T</td><td width='42px'>F</td><td width='42px' class='weekend'>S</td></tr>";
	
	$day_count = 1;
	while ($blank > 0) {
		if ($day_count == 1 || $day_count == 7) {
			echo '<td class="weekend grey">' . $grey_num . '</td>';
		} else {
			echo '<td class="grey">' . $grey_num .  '</td>';	
		}
		
		$blank--;
		$day_count++;
		$grey_num++;
	}
	
	$day_num = 1;
	while ($day_num <= $days_in_month) {
		if ($day_count == 1 || $day_count == 7) {
			if ($day_num == $day) {
				$re = check_fin($year . "-" . $month . "-" . $day_num, $tu);
				if ($re) {
					echo '<td class="weekend today ' . $re . '"><a href="./add.php?d=' . $day_num . '&m=' . $month . '&y=' . $year . '">' . $day_num . '</a></td>';
				}
			} else {
				$re = check_fin($year . "-" . $month . "-" . $day_num, $tu);
				if ($re) {
					echo '<td class="weekend ' . $re . '"><a href="./add.php?d=' . $day_num . '&m=' . $month . '&y=' . $year . '">' . $day_num . '</a></td>';
				}
			}
		} else {
			if ($day_num == $day) {
				$re = check_fin($year . "-" . $month . "-" . $day_num, $tu);
				if ($re) {
					echo '<td class="today ' . $re . '"><a href="./add.php?d=' . $day_num . '&m=' . $month . '&y=' . $year . '">' . $day_num . '</a></td>';
				}
			} else {
				$re = check_fin($year . "-" . $month . "-" . $day_num, $tu);
				if ($re) {
					echo '<td class="' . $re . '"><a href="./add.php?d=' . $day_num . '&m=' . $month . '&y=' . $year . '">' . $day_num . '</a></td>';
				}
			}
		}
		
		$day_num++;
		$day_count++;
		
		if ($day_count > 7) {
			echo '</tr><tr>';
			$day_count = 1;
		}
	}
	
	$grey_num = 1;
	
	while ($day_count > 1 && $day_count <= 7) {
		if ($day_count == 1 || $day_count == 7) {
			echo '<td class="weekend grey">' . $grey_num . '</td>';
		} else {
			echo '<td class="grey">' . $grey_num . '</td>';	
		}
		$day_count++;
		$grey_num++;
	}
	
	echo '</tr></table>';
?>
<br />
<p>A red border means none are finished<br />
A blue border means some are finished<br />
A green border means all are finished<br />
A grey border means there are none</p>
</body>
</html>