<?php
	session_start();
	$username = "";
	$password = "";
	$username = $_POST['username'];
	$password = $_POST['password'];
	if ($username != "") { //empèche les F5
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) { //connection à la db
			die('merde (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
		}
		$query = mysqli_query($link, "SELECT * from users WHERE username='$username'");
		$exists = mysqli_num_rows($query);
		$table_user = "";
		$table_password = "";
		if($exists > 0) { //verifié si il y a des utilisateurs déjà inscrits
			while($row = mysqli_fetch_assoc($query)) {
				$table_user = $row['username'];
				$table_password = $row['password'];
				$rights = $row['rights'];
			}
			if(($username == $table_user) && (password_verify($password, $table_password))) {
				if (password_verify($password, $table_password)) {// verifie si la combinaison username/password est correcte
					$_SESSION['user'] = $username;//créer la session User avec les droits rights
					$_SESSION['rights'] = $rights;//0 si user 1 si admin
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