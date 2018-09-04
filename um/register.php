<html>
	<head>
		<title>10.1.1.88/register.php</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
	</head>
	<body>
		<h2>REGISTER A NEW ACCOUNT</h2>
		<a href="../index.php">← BACK</a><br/><br/>
		<form action="register.php" method="POST">
			USERNAME: <input type="text" name="username" required="required"/><br/>
			PASSWORD: <input type="password" name="password" required="required"/><br/>
			CONFIRM PASSWORD: <input type="password" name="confirmation" required="required"/><br/><br/>
			<input type="submit" value="REGISTER"/>
		</form>
	</body>
</html>
<?php
	$username = "";
	$password = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirmation = $_POST['confirmation'];
	}
	if ($username != "" && $password == $confirmation) {
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		$bool = true;
		if (!$link) { //connection à la db
			die('merde (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
		}
		$query = mysqli_query($link, "SELECT * FROM users");
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT); //chiffre le mdp
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$tusers = $row['username'];
			if($username == $tusers) { //vérifie si l'username est déjà prit
				$bool = false;
				Print '<script>alert("Username already taken!");</script>';
				Print '<script>window.location.assign("register.php)";</script>';
			}
		}
		if($bool) {
			mysqli_query($link, "INSERT INTO users (username, password, rights) VALUES ('$username', '$password', 0)"); //inscrit l'username et mdp chiffré dans la db
			Print '<script>alert("Registration done!");</script>';
			header("location: login.php");
		}
	} else {
		Print '<script>window.location.assign("register.php)";</script>';
	}
?>