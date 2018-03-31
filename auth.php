<?php
	@session_start();
	
	if ($_SESSION['in'] == "TRUE") {
		$tu = $_SESSION['user'];
	} else {
		header("location: ./index.php");	
	}
?>