<html>
	<head>
		<title>10.1.1.88/adm/report.php</title>
	</head>
	<body>
		<h2 align="center">REPORT</h2>
		<a href="../index.php">← BACK</a><br/><br/>
		<?php
			session_start();
			$id_exists = false;
			if (!empty($_GET['id'])) {
				$id = $_GET['id'];
				$_SESSION['id'] = $id;
				$id_exists = true;
				if ($id_exists) {
					Print '
						<form action="report.php" method="POST">
							Reason:<br/> <textarea rows="4" cols="50" name="reason"></textarea><br/>
							<input type="submit" value="SUBMIT REPORT"/>
						</form>
					';
				}
			} else {
				Print '<h2 align="center">No data to Report</h2>';
			}
		?>

	</body>
</html>
<?php
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) {
			die('merde (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}
		$reason = mysqli_real_escape_string($link, $_POST['reason']);
		$id = $_SESSION['id'];
		mysqli_query($link, "INSERT INTO reports (reason, reported_message, status) VALUES ('$reason', '$id', 'open')");
		header("location: ../index.php");
		session_abort();
	}
?>
