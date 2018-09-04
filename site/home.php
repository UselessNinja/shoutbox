<html>
	<?php
		session_start();
		if($_SESSION['user']) {} else {
			header("location: ../index.php"); //vérifie si l'user est connecté sinon redirige l'user vers l'index
		}
		$user = $_SESSION['user'];
		$rights = $_SESSION['rights'];
	?>
	<head>
		<title><?php Print $user?>'s home</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
	</head>
	<body>
		<h2>MY MESSAGES</h2>
		<p>Hello <?php Print "$user"?>.</p>
		<a href="../um/logout.php">LOGOUT</a><br/><br/>
		<form action="lm/add.php" method="POST">
			Your Message:<br/>
			<textarea rows="4" cols="50" name="details" required="required"></textarea><br/>
        		Public ? <input type="checkbox" name="public[]" value="yes"/><br/>
        		<input type="submit" value="POST"/>
		</form>
		<h2 align="center">Past messages</h2>
		<table border="1px" width="100%">
			<tr>
				<th>N≗</th>
				<th>Message</th>
				<th>Author</th>
				<th>Post Time</th>
				<th>Last Edit</th>
				<th>EDIT</th>
				<th>DELETE</th>
				<th>Public ?</th>
			</tr>
			<?php
				$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
				if (!$link) { //connection à la db
					die('merde (' . mysqli_connect_errno() . ') '
					. mysqli_connect_error());
				}
				$query = mysqli_query($link, "SELECT * FROM list");
				while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					if ($user == $row['author'] || $rights == 1) {//affiche les messages de l'utilisateur / tout les messages si l'user est un admin
						Print "<tr>";
							Print '<td align="center">'. $row['id'] . "</td>";
							Print '<td align="center">'. $row['details'] . "</td>";
							Print '<td align="center">'. $row['author'] . "</td>";
							Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted'] . "</td>";
							Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
							Print '<td align="center"><a href="lm/edit.php?id='. $row['id'] .'">EDIT</a></td>';
							Print '<td align="center"><a href="#" onclick="delet('.$row['id'].')">DELETE</a></td>';
							Print '<td align="center">'. $row['public'] . "</td>";
						Print "</tr>";
					}
				}
			?>
		</table>
		<script>
			function delet(id) {
				var r = confirm("Are you sure you want to delete this message ?");
				if (r == true) {
					window.location.assign("lm/delete.php?id=" + id);
				}
			}
		</script>
	</body>
</html>
<?php
	if ($_SESSION['rights'] == 1) { //affichages des reports si l'user est un admin
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) {
			die('merde (' . mysqli_connect_errno() . ') '
				. mysqli_connect_error());
		}
		Print '<h2 align="center">list of reports</h2>';
		$query = mysqli_query($link, "SELECT * FROM reports");
		Print '<table border="1px" width="100%">';
			Print "<tr>";
				Print '<th>id</th>';
				Print '<th>reason</th>';
				Print '<th>id_reported_message</th>';
				Print '<th>status</th>';
				Print '<th>change status?</th>';
				Print '<th>Delete</th>';
			Print "<tr/>";
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				Print "<tr>";
					Print '<td align="center">'. $row['id'] . "</td>";
					Print '<td align="center">'. $row['reason'] . "</td>";
					Print '<td align="center">'. $row['reported_message'] . "</td>";
					Print '<td align="center">'. $row['status'] . "</td>";
					if ($row['status'] == 'open')
						Print '<td align="center"><a href="../adm/close.php?id='. $row['id'] .'">CLOSE</a></td>';
					else
						Print '<td align="center"><a href="../adm/open.php?id='. $row['id'] .'">OPEN</a></td>';
					Print '<td align="center"><a href="../adm/delete.php?id='. $row['id'] .'">DELETE</a></td>';
				Print "<tr/>";
			}
		Print "</table>";
	}
?>