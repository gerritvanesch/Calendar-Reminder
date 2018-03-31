<?php
	if (!isset($_GET['in'])) {
?>
	<form action="./?in=true" method="post">
    	New user? <input type="checkbox" name="new" /><br /><br />
        Username: <input type="text" name="userName" /><br />
        Password: <input type="password" name="passWord" /><br /><br />
        <button type="submit">Log in</button>
    </form>
<?php
	} else {
		require("./connect.php");
		$user = $_POST['userName'];
		$pass = $_POST['passWord'];
		
		if (isset($_POST['new'])) {
			$user = addslashes(stripslashes($user));
			$pass = md5(addslashes(stripslashes($pass)));
			$load = mysql_query("SELECT COUNT(*) AS num FROM users WHERE `username`='$user'");
			if ($obj = mysql_fetch_object($load)) {
				$num = $obj->num;	
			}
			if ($num > 0) {
				echo "Error: Username already in use<br />";
				die("<a href='./'>Try again</a>");	
			}
			$load = mysql_query("INSERT INTO users (`username`,`password`) VALUES ('$user','$pass')");
			
			// create session
			session_start();
			$_SESSION['in'] = "TRUE";
			$_SESSION['user'] = $user;
			
			header("location: ./cal.php");
		} else {
			$user = addslashes(stripslashes($user));
			$pass = md5(addslashes(stripslashes($pass)));
			$load = mysql_query("SELECT COUNT(*) AS num FROM users WHERE `username`='$user' AND `password`='$pass'");
			if ($obj = mysql_fetch_object($load)) {
				$num = $obj->num;	
			}
			if ($num == 1) {
				// create session
				session_start();
				$_SESSION['in'] = "TRUE";
				$_SESSION['user'] = $user;
				
				header("location: ./cal.php");
			} else {
				echo "Wrong username or password<br />";
				echo "<a href='./'>Try again</a>";	
			}
		}
	}
?>