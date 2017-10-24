<?php 
	session_start();

		include "Email.php";
		

		$inFullName="";
		$inEmail="";
		$inContactReason= "";
		$inMessage = "";

		$fullNameError="";
		$emailError="";
		$contactReasonError = "";
		$messageError ="";

		$validForm = false;

		if(isset($_POST["submit"])) {

			$inFullName= test_input($_POST["inFullName"]);
			$inEmail= test_input($_POST["inEmail"]);
			$inContactReason= $_POST["inContactReason"];
			$inMessage = test_input($_POST["inMessage"]);

			$fullNameError=$_POST["fullNameError"];
			$emailError=$_POST["emailError"];
			$contactReasonError = $_POST["contactReasonError"];
			$messageError =$_POST["messageError"];


	    	function validateName($inName) {
		        global $validForm, $fullNameError; // global variables
		        $fullNameError = "";
		        
		        if($inName == "") {
		          $validForm = false;
		          $fullNameError = "Name cannot be left blank or have spaces";
		        }
	    	}//end validateName()
		

			function validateEmail($inEmail) {

		        global $validForm, $emailError; // global variables

		        $emailError = "";

		        if (empty($inEmail)) {
		            $validForm = false;
					$emailError = "Email is required.";
		            } else {
		                if (!filter_var($inEmail, FILTER_VALIDATE_EMAIL)) {
		                    $validForm = false;
		                    $emailError = "Invalid email format.";
		                }
		            }
				}

			function validatePreference ($inPreference) {
				global $validForm, $contactReasonError;

				$contactReasonError = "";

				if (empty($inPreference)) {
					$validForm = false;
					$contactReasonError = "Please select your contact preference.";
				}
			}

			function validateMessage($inMessage) {
				global $validForm, $messageError;

				$messageError = "";

				if ($_POST["inContactReason"] == "other" && empty($inMessage)) {
				
				$validForm = false;
				$messageError = "Please write a message.";
				} 
			}

			function validateHoneyPot($inHoney) {
				if (!empty(honeyPot)) {
					$validForm = false;
				}
			}



			$validForm = true;

			validateName($inFullName);
			validateEmail($inEmail);
			validatePreference($inContactReason);
			validateMessage($inMessage);




			if ($validForm) {

				// EMAIL TO CLIENT 

				$timestamp = date('F j, Y, g:i a');
				$contactEmail = new Email("");  //instantiate
				
				$contactEmail->setRecipient("djschneider1@dmacc.edu");
				$contactEmail->setSender($inEmail);
				$contactEmail->setSubject("Contact Page Programming Project");
				$contactEmail->setMessage("From: $inFullName  Email: $inEmail  Contact Preference: $inContactReason Message: $inMessage ");
				$emailStatus = $contactEmail->sendMail(); //create and send email

				//CONFIRMATION EMAIL

				$contactEmail = new Email("");  //instantiate
				
				$contactEmail->setRecipient($inEmail);
				$contactEmail->setSender("djschneider1@dmacc.edu");
				$contactEmail->setSubject("Confirmation");
				$contactEmail->setMessage("Your contact form from: Programming Project PHP Contact Page with Validation has been sent. Thank you for contacting us. Date: $timestamp ");
				$emailStatus = $contactEmail->sendMail(); //create and send email


				//Triggers modal
	            echo"
	                    <div id='confirmationModal'>
	                        <div class='confirmationModalContent'>
	                        <span class='closeSuccessModal'>&times;</span>
	                            <h1>Success!</h1>
	                                <p>Your message has been sent!</p>
							<ul class='list-group'>
							  <li class='list-group-item'><strong>Name:</strong> $inFullName </li>
							  <li class='list-group-item'><strong>Email Address:</strong> $inEmail</li>
							  <li class='list-group-item'><strong>Contact Preference:</strong> $inContactReason</li>
							  <li class='list-group-item'><strong>Message:$message</strong></li>
							  <li class='list-group-item'><strong>Time Sent: $timestamp</strong></li>
							</ul>

	                        </div>
	                    </div>";

				// 
			} else {
	            echo"
	                    <div id='confirmationModal'>
	                        <div class='confirmationModalContent'>
	                        <span class='closeSuccessModal'>&times;</span>
	                            <h1>Whoops! Something went wrong</h1>
	                                <p>The form you sent has some errors. Sorry for the inconvenience.</p>
	                        </div>
	                    </div>";
	            }

	}

		 function test_input($data) { // Checks htmlspecialchars
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
		 }
?>





<!doctype html>
<html lang="en">
  <head>
	<title>Programming Project: PHP Contact Page with Validation</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="main.css">

  </head>
  <body>
  <header>
  	  	<h1 class="display-3 websiteTitle">Dynamic Dave's Dynamite</h1>
		<ul class="nav nav-tabs">
		  <li class="nav-item">
		    <a class="nav-link active" href="#">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="#">About</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="#">View PHP</a>
		  </li>
		</ul>
  </header>



	<div class="formContainer">
		<h1 class="display-4">Contact Us</h1>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label for="name">Full Name:<br>

				<input type="text" name="inFullName"><span class="error" name="fullNameError"><?php echo $fullNameError; ?></span>

			</label>
			<br>
			<label for="emailAddress">Email Address:<br>	

				<input type="text" name="inEmail"><span class="error" name="emailError"><?php echo $emailError; ?></span>

			</label>
			<br>
			<label for="contactReason">Contact Reason:

				<span class="error" name="contactReasonError"><?php echo $contactReasonError; ?></span><br>
				  <input type="radio" name="inContactReason" value="technicalIssues">Technical Issues<br>
				  <input type="radio" name="inContactReason" value="billingIssues">Billing Issues<br>
				  <input type="radio" name="inContactReason" value="other"> Other<br>

			</label>
			<br>
			<label for="Message">

				Message: <span class="error" name="messageError"><?php echo $messageError; ?></span><br>
				<textarea rows="4" cols="50" name="inMessage"></textarea>

			</label>

			  <input type="hidden" name="honeyPot">

			<br>
			<div class="userButtons">
				<input type="submit" name="submit" value="Submit">
				<input type="reset" name="reset" value="Reset">
			</div>
		</form>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        // Get the modal
        var modal = document.getElementById('confirmationModal');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("closeSuccessModal")[0];
        // Modal closes when user hits "x"
        span.onclick = function() {
            modal.style.display = "none";
        }
    // Modal closes when user hits anywhere else of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

  </body>
</html>