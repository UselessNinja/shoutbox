<?php
	session_start();
	if($_SESSION['user']) {} else { //vérifie si l'utilisateur est connecté
		header("location: ../../index.php");
	}
	$user = $_SESSION['user'];
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$time = strftime("%X");
		$date = strftime("%B %d, %Y");
		$decision = "no";
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) {//connection à la db
			die('merde (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}
		$details = mysqli_real_escape_string($link, $_POST['details']);
		foreach($_POST['public'] as $each_check) {
			if($each_check != NULL) {
				$decision = "yes"; //vérifie si l'état de la checkbox
			}
		}
		mysqli_query($link, "INSERT INTO list (details, date_posted, time_posted, date_edited, time_edited, public, author) VALUES ('$details', '$date', '$time', '', '', '$decision', '$user')"); //création du message
		header("location: ../home.php");	
	} else {
		header("location: ../home.php");
	}
?>
