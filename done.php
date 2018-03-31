<?php
	require("./connect.php");
	require("./auth.php");

	$d = $_GET['d'];
	$m = $_GET['m'];
	$y = $_GET['y'];
	@$in = $_GET['in'];
	if (!$in) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<title>View completed reminders</title>
</head>

<body>
<?php
		$date = $y . '-' . $m . '-' . $d;
		$load = mysql_query("SELECT * FROM reminders WHERE `complete`='Yes' AND `user`='$tu' AND `date`='$date'");
		while ($row = mysql_fetch_array($load)) {
			$id = $row['id'];
			$time = $row['time'];
			$desc = $row['description'];
			
			echo "<div id='reminder'><b>$time:</b> $desc <a href='./done.php?in=true&d=" . $d . "&m=" . $m . "&y=" . $y . "&undo=" . $id . "'>Undo</a></div>";
		}
		
		echo '<br /><br /><a href="./add.php?d=' . $d . '&m=' . $m . '&y=' . $y . '">Back</a>';
	} else {
		$id = $_GET['undo'];
		$undo = mysql_query("UPDATE reminders SET `complete`='' WHERE `id`='$id'");
		header("location: ./done.php?d=$d&m=$m&y=$y");
	}
?>