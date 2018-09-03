<html>
	<head>
		<title>10.1.1.88</title>
	</head>
	<body>
		<h2 align="center">Useless' shoutbox</h2>
		<a href="um/login.php"> LOGIN IN</a></br>
		<a href="um/register.php"> REGISTER AN ACCOUNT</a>
	</body>
	<br/>
	<br/>
	<table width="100%" border="1px">
		<tr>
			<th>Message</th>
			<th>Author</th>
			<th>Time Posted</th>
			<th>Last Edit</th>
			<th>Report ?</th>
		</tr>
		<?php
			$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
			if (!$link) {
				die('merde (' . mysqli_connect_errno() . ') '
					. mysqli_connect_error());
			}
			$query = mysqli_query($link, "SELECT * from list WHERE public='yes'");
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				Print "<tr>";
					Print '<td align="center">'. $row['details'] . "</td>";
					Print '<td align="center">'. $row['author'] . "</td>";
					Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted'] . "</td>";
					Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
					if ($row['author'] != 'admin')
						Print '<td align="center"><a href="adm/report.php?id='. $row['id'] .'">Report</a></td>';
				Print "</tr>";	
			}
		?>
	</table>
	<footer>
		<a href="site/contact.php"><p align="right">Contact</p></a>
	</footer>
</html>