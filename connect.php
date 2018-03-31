<?php
	require("connection_info.php");

	$con = mysql_connect($host,$user,$pass);
	if (!$con) {
		die("Connection failed");	
	}
	mysql_select_db("reminder_calendar");
?>