<html>
	<head>
		<title>10.1.1.88/site/contact</title>
	</head>
	<body>
		<h2 align="center">CONTACT</h2>
		<a href="../index.php">← BACK</a>
	</body>
	<form action="contact.php" name="contactform" method="POST">
		<table>	
			<tr>
				<td>
					<label for="first_name">First Name :</label>
				</td>
				<td>
					<input type="text" name="first_name" maxlenght="50" size="30"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="last_name">Last Name :</label>
				</td>
				<td>
					<input type="text" name="last_name" maxlenght="50" size="30"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="email">Email Address :</label>
				</td>
				<td>
					<input type="text" name="email" maxlenght="50" size="30"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="message">Your Message :</label>
				</td>
				<td>
					<textarea name="message" maxlength="1000" cols="32" rows="6"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="SEND E-MAIL">
				</td>
			</tr>
		</table>
	</form>
</html>
<?php
	if (isset($_POST['email'])) {
		$email_to = ".@..fr";
		$email_subject = "Shoutbox - ". $_POST['last_name']." ". $first_name = $_POST['first_name'];
		function died($error) {
			echo "We are very sorry, but there were error(s) found with the form you submitted. ";
			echo "These errors appear below.<br /><br />";
			echo $error."<br /><br />";
			echo "Please go back and fix these errors.<br /><br />";
			die();
		}
		if (!isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
			died('Sorry it does not work retry');
		}
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$link = mysqli_connect('localhost', 'root', 'a', 'logindb');
		if (!$link) {
			die('merde (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
		$message = mysqli_real_escape_string($link, $_POST['message']);
		$error_message = "";
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if (!preg_match($email_exp, $email))
			$error_message .= 'The Email Address you entered is wrong<br/>';
		$string_exp = "/^[A-Za-z .'-]+$/";
		if(!preg_match($string_exp,$first_name))
			$error_message .= 'The First Name you entered does not appear to be valid.<br />';
		if(!preg_match($string_exp,$last_name))
			$error_message .= 'The Last Name you entered does not appear to be valid.<br />';
		if(strlen($error_message) > 0)
			died($error_message);
		$email_message = "Form details below. \n\n";
		function clean_string($string) {
			$bad = array("content-type","bcc:","to:","cc:","href");
			return str_replace($bad,"",$string);
		}
		$email_message .= "First Name: ".clean_string($first_name)."\n";
		$email_message .= "Last Name: ".clean_string($last_name)."\n";
		$email_message .= "Email: ".clean_string($email)."\n";
		$email_message .= "Message: ".clean_string($message)."\n";
		$headers = 'From: '.$email."\r\n".
		'Reply-To: '.$email."\r\n" . 'X-Mailer: PHP/' . phpversion();
		@mail($email_to, $email_subject, $email_message, $headers);  
?>
	<h2>Thank you for contacting us. We will be in touch with you very soon.</h2>
<?php
	}
?>