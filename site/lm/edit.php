<html>
	<head>
		<title>10.1.1.88/site/lm/edit.php</title>
	</head>
	<?php
		session_start();
		if($_SESSION['user']) {} else {
			header("location: ../../index.php");
		}
		$user = $_SESSION['user'];
		$id_status = false;
	?>
	<body>
		<h2>EDIT</h2>
		<p>Hello <?php Print "$user"?>.</p>
		<a href="../../um/logout.php">LOGOUT</a><br/><br/>
		<a href="../home.php">← BACK</a>
		<h2 align="center">Selected Message</h2>
		<table border="1px" width="100%">
			<tr>
				<th>N≗</th>
				<th>Message</th>
				<th>Post Time</th>
				<th>Last Edit</th>
				<th>Public ?</th>
			</tr>
			<?php
				if(!empty($_GET['id'])) {
					$id = $_GET['id'];
					$_SESSION['id'] = $id;
					$id_exists = true;
					$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
					if (!$link) {
						die('merde (' . mysqli_connect_errno() . ') '
						. mysqli_connect_error());
					}
					$query = mysqli_query($link, "SELECT * FROM list WHERE ID='$id'");
					$count = 0;
					$count = mysqli_num_rows($query);
					if ($count > 0) {
						while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
							Print "<tr>";
								Print '<td align="center">'. $row['id'] . "</td>";
								Print '<td align="center">'. $row['details'] . "</td>";
								Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted'] . "</td>";
								Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
								Print '<td align="center">'. $row['public'] . "</td>";
							Print "</tr>";
						}	
					} else {
						$id_exists = false;
					}
				}
			?>
		</table>
		<br/>
		<?php
			if ($id_exists) {
				Print '
					<form action="edit.php" method="POST">
						New message:<br/> <textarea rows="4" cols="50" name="details" required="required"></textarea><br/>
						Public ?: <input type="checkbox" name="public[]" value="yes"/><br/>
						<input type="submit" value="update"/>
					</form>
				';
			} else {
				Print '<h2 align="centre">No data to edit</h2>';
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
		$details = mysqli_real_escape_string($link, $_POST['details']);
		$public = "no";
		$id = $_SESSION['id'];
		$time = strftime("%X");
		$date = strftime("%B %d, %Y");
		foreach($_POST['public'] as $list) {
			if($list != NULL) {
				$public = "yes";
			}
		}
		Print "$details - $public - $date - $time - $id";
		mysqli_query($link, "UPDATE list SET details='$details', public='$public', date_edited='$date', time_edited='$time' WHERE id='$id'");
		header("location: ../home.php");
	}
?>