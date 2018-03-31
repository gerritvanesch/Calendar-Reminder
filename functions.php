<?php
	function check_fin($date, $tu) {
		require("./auth.php");
		
		$fin = mysql_query("SELECT COUNT(*) AS num FROM reminders WHERE `user`='$tu' AND `date`='$date' AND `complete`='Yes'");
		if ($obj = mysql_fetch_object($fin)) {
			$fin = $obj->num;	
		}
		$nfin = mysql_query("SELECT COUNT(*) AS num FROM reminders WHERE `user`='$tu' AND `date`='$date' AND `complete`!='Yes'");
		if ($obj = mysql_fetch_object($nfin)) {
			$nfin = $obj->num;	
		}
		
		if ($fin > 0 && $nfin > 0) {
			$re = 'p';	
		} elseif ($fin > 0 && $nfin == 0) {
			$re = 'f';
		} elseif ($fin == 0 && $nfin > 0) {
			$re = 'n';	
		} else {
			$re = 'k';	
		}
		
		return $re;
	}
?>