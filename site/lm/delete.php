<?php
	session_start();
	if($_SESSION['user']) {} else {
		header("location: ../../index.php"); //vérifie si une connection à été établie
	}
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) { //connection à la database
			die('merde (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}
		$id = $_GET['id'];
		mysqli_query($link, "DELETE FROM list WHERE id='$id'"); //détruit le message correspondant à l'id de la page
		header("location: ../home.php");
	}
?>