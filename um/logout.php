<?php
	session_start();
	session_destroy(); //detruit la session
	header("location: ../index.php");
?>