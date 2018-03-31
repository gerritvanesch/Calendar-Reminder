<?php
	require("../2.3.5/connect.php");
	$create = mysql_query("CREATE DATABASE `reminder_calendar`");
	$create = mysql_select_db('reminder_calendar');
	$create = mysql_query("CREATE TABLE `reminders` (`id` int(11) not null auto_increment,`user` varchar(50) not null,`date` date not null,`time` time not null,`description` text not null,`complete` varchar(3) not null,PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
	$create = mysql_query("CREATE TABLE `users` (`id` int(11) not null auto_increment, `username` varchar(50) not null, `password` varchar(100) not null, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
	
	if (!$create) {
		echo "Failed!! " . mysql_error();	
	} else {
		echo "Setup successful";	
	}
?>