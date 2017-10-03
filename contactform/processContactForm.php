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


	if(isset($_POST['submit'])) { // Confirmation Message
		$to = $visitor_email; 
		$subject = "Confirmation Message - devDandy!";
		$message ="Thank you for submitting your form from devDandy!\nWe have received your email.";

		mail($to,$subject,$message);
	}

	?>



<!DOCTYPE html>
<html>
<head>
	<title>Contact Form Processing</title>
	<link href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Poppins" rel="stylesheet">
	<style>
    * {
      box-sizing: border-box;
    }
    body {
      background: #13232f;
    }
    p {
    	text-align: center;
    }

    .container {
      margin: 5em auto;
      width: 75%;
    }

    section {
      margin: auto;
      width: 50%;
      padding: 25px;
      border-radius: 10px;
      color: white; 

    }
    .formHeader {
      background: #1ab188;
      padding: 15px 20px;
      border-radius: 4px;
      font-family: 'Berkshire Swash', cursive;
      font-size: 3.5em;
      text-align: center;
      text-shadow: 5px 1px #13232f;
      color: white;

    }

button {
	display: inline-block;
    width: 75%;
    background-color: #FF404E;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    font-family: 'Raleway', sans-serif;
    font-weight: bold;
    font-size: 1.5em;
    cursor: pointer;
}
	</style>
</head>
<body>
	  <div class="container">
		<section>
			<h1 class="formHeader">Form has been submitted!</h1>
				<p>
					<a href="https://github.com/devDandy/WDV341-/tree/master/contactform"><button>View PHP</button></a>
					<a href="https://devdandy.com/homework/wdv341/contactForm/contactFormProject.html"><button>View Back to Contact Form</button></a>
				</p>
		</section>
	</div>
</body>
</html>