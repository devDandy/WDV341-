<?php 



	if(isset($_POST['submit'])) {
		$to = "dschnd@gmail.com";
		$visitor_name = $_POST['recipientName'];
		$visitor_email = $_POST['recipientEmail'];
		$subject = "Contact Form from: $visitor_name";
		$visitor_reason = $_POST['contactReason'];
		$visitor_comment = $_POST['recipientComment'];
		$mailingList = $_POST['mailingList'];
		$moreInformation = $_POST['moreInformation'];

		// $message = "Name: $visitor_name\nEmail: $visitor_email\nContact Reason: $visitor_reason\nMailing List?: $mailingList\n More Information? $moreInformation\nComment: $visitor_comment";

		$headers = "From: $visitor_email \r\n"; //strip_tags(
		$headers .= "Reply-To: $visitor_email \r\n"; //strip_tags(
		$headers .= "CC:  $visitor_email \r\n"; // strip_tags(
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


		$mailBody = '<html><body>'; // Styling Email
		$mailBody .= '<h1>PHP Email Project</h1>';
		$mailBody .= '<table rules="all" style="border-color: #666;" cellpadding="10">'; // Table Styles 
		$mailBody .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . $visitor_name . "</td></tr>"; // Visitor Name  strip_tags(
		$mailBody .= "<tr><td><strong>Email:</strong> </td><td>" . $visitor_email . "</td></tr>"; //Visitor Email strip_tags(
		$mailBody .= "<tr><td><strong>Contact Reason:</strong> </td><td>" . $visitor_reason . "</td></tr>"; // Contact Reason strip_tags(
		$mailBody .= "<tr><td><strong>Comments:</strong> </td><td>" . $visitor_comment . "</td></tr>"; //Contact Message  ST
		$mailBody .= "<tr><td><strong>Mailing List:</strong> </td><td>" . $mailingList . "</td></tr>"; // Mailing List !!!
		$mailBody .= "<tr><td><strong>More Information:</strong> </td><td>" . $moreInformation . "</td></tr>"; // More Information !!!
		$mailBody .= "</table>";
		$mailBody .= "</body></html>";




           mail($to, $subject, $mailBody, $headers);
    }


	if(isset($_POST['submit'])) {
		
	}





	// if (isset($_POST['submit'])) {
	//   $confirmationRecipent = $_POST['recipientEmail'];
	//   $confirmationSubject = "Confirmation Email from Contact Form";
	//   $confirmationMessage= "Thank you for contacting us!\n We have received your e-mail!";

	//   mail($confirmationRecipent,$confirmationSubject,$confirmationMessage);
	// }
	?>



<!DOCTYPE html>
<html>
<head>
	<title><?php echo "Hello World!"?> Contact Form Processing</title>
</head>
<body>
<h1>Let's see if this works</h1>


<?php echo $_POST['recipientName']; ?><br>
<?php echo $_POST['recipientEmail']?><br>
<?php echo $_POST['contactReason']?><br>
<?php echo $_POST['recipientComment']?><br>
<?php echo $_POST['mailingList']?><br>
<?php echo $_POST['moreInformation']?><br>
</body>
</html>