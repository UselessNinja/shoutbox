<?php
	session_start();
	$username = "";
	$password = "";
	$username = $_POST['username'];
	$password = $_POST['password'];
	if ($username != "") {
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) {
			die('merde (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
		}
		$query = mysqli_query($link, "SELECT * from users WHERE username='$username'");
		$exists = mysqli_num_rows($query);
		$table_user = "";
		$table_password = "";
		if($exists > 0) {
			while($row = mysqli_fetch_assoc($query)) {
				$table_user = $row['username'];
				$table_password = $row['password'];
				$rights = $row['rights'];
			}
			if(($username == $table_user) && (password_verify($password, $table_password))) {
				if (password_verify($password, $table_password)) {
					$_SESSION['user'] = $username;
					$_SESSION['rights'] = $rights;
					header("location: ../site/home.php");
				}
			} else {
				Print '<script>alert("Wrong Password or Username");</script>';
				Print '<script>window.location.assign("login.php");</script>';
			}
		} else {
			Print '<script>alert("Wrong Password or Username");</script>';
			Print '<script>window.location.assign("login.php");</script>';
		}
	}
?>