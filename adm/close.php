<?php
	session_start();
	if($_SESSION['user']) {} else {
		header("location: ../../index.php");
	}
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) {
			die('merde (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}
		$id = $_GET['id'];
		$user = $_SESSION['user'];
		mysqli_query($link, "UPDATE reports SET status='closed by $user' WHERE id=$id");
		header("location: ../site/home.php");
	}
?>