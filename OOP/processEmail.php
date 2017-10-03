<?php

	include 'Email.php';
	$contactEmail = new Email("");  //instantiate
	
	$contactEmail->setRecipient("yourname@email.com");
	$contactEmail->setSender("yourname@email.com");
	$contactEmail->setSubject("Class Time");
	$contactEmail->setMessage("Hello world! This is some text to see if the text wrap is working! Here is some more text, but wait there's more! Actually no that's about it");
	$emailStatus = $contactEmail->sendMail(); //create and send email
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>WDV341 Intro PHP</title>
</head>

<body>
	<h1>WDV341 Intro PHP</h1>
	<h2>PHP OOP Email Class Test</h2>
	
	<p>Recipient Email Address: <?php echo $contactEmail->getRecipient(); ?></p>
	<p>Sender Email Address: <?php echo $contactEmail->getSender(); ?></p>
	<p>Subject: <?php echo $contactEmail->getSubject(); ?></p>
	<p>Message: <?php echo $contactEmail->getMessage(); ?></p>
	
	
	<?php
	if ($emailStatus) {
		?>
				<h3>Your email has been sent!</h3>
	<?php			
			}else{
	?>			
				<h3>There was an error sending your email!</h3>
	<?php			
			}
	?>
	
</body>
</html>