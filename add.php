<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<title>Add reminder</title>
</head>

<body>
<?php
	require("./auth.php");
	require("./connect.php");

	$day = $_GET['d'];
	$month = $_GET['m'];
	$year = $_GET['y'];
	@$in = $_GET['in'];
	
	if (!$in) {	
		echo "<form action='./add.php?in=true&d=" . $day . "&m=" . $month . "&y=" . $year . "' method='post'>";
		
		/*if ($day < 10 && $day > 0) {
			$day = '0' . $day;	
		}
		if ($month < 10 && $month > 0) {
			$month = '0' . $month;	
		}*/
		$date = $year . '-' . $month . '-' . $day;
		
        $load = mysql_query("SELECT * FROM reminders WHERE `user`='$tu' AND `date`='$date'");
		
		echo '<a href="./done.php?d=' . $day . '&m=' . $month . '&y=' . $year . '">View completed</a><br />';
		
		$ids = "";
        while ($row = mysql_fetch_array($load)) {
			$id = $row['id'];
            $time = $row['time'];
			$desc = $row['description'];
			$complete = $row['complete'];
			
			if ($complete != "Yes") {
				// If not complete - will tell which to skip on update statement
				echo "<div id='reminder'><input type='checkbox' name='$id' /><b>$time:</b> $desc</div>";
				$ids = $ids . "//" . $id;
			}
        }
		if (!$ids) {
			// no records
		} else {
			echo "<input hidden name='ids' value='$ids' />";
			echo "<input hidden name='tot' value='$id' />";	
		}
?>
            Add a reminder: <input type="text" name="add" /><br /><br />
            <input type="submit" value="Add and Update" />
        </form>
        <br /><br />   
<?php
		echo '<a href="./cal.php?fmonth=' . $month . '&fyear=' . $year . '">Back to calendar</a>';
	} else {
		// get all the separate ids
		$ids = explode("//",$_POST['ids']);
		// get the total num of ids
		$no = $_POST['tot'];
		$i = 0;
		while ($i < $no) {
			// run through all the ids
			@$num = $ids[$i + 1];
			@$current = $_POST[$num];
			if (!$current) {
				// If not there then checkbox in question not checked
			} else {
				// If it is there then the checkbox in question was checked
				mysql_query("UPDATE reminders SET `complete`='Yes' WHERE `id`='$num'");
			}
			$i++;
		}
		
		$new = $_POST['add'];
		if (!$new) {
			// Nothing typed in: don't add any records	
		} else {
			// Add a reminder
			/*if ($day < 10 && $day > 0) {
				$day = '0' . $day;	
			}
			if ($month < 10 && $month > 0) {
				$month = '0' . $month;	
			}*/
			$date = $year . '-' . $month . '-' . $day;
			$time = date("h:i:s", time());
			$desc = addslashes(stripslashes($new));
			$ins = mysql_query("INSERT INTO reminders (`user`,`date`,`time`,`description`) VALUES ('$tu','$date','$time','$desc')");
		}
		
		// locate back to page
		header("location: ./add.php?d=$day&m=$month&y=$year");
	}
?>
</body>
</html>