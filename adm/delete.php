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
		mysqli_query($link, "DELETE FROM reports WHERE id='$id'");
		header("location: ../site/home.php");
	}
?>