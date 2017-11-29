<?php 
    error_reporting(E_ERROR | E_PARSE);
    include "Email.php";

    $visitor_name = '';
    $visitor_email = '';
    $visitor_reason = '';
    $visitor_comment = '';
    $honeypot = "";
    $visitor_name_error = '';
    $visitor_email_error = '';
    $visitor_reason_error = '';
    $visitor_comment_error = '';

    $validForm = false;

  if(isset($_POST['submit'])) {
    $visitor_name = test_input($_POST['recipientName']);
    $visitor_email = test_input($_POST['recipientEmail']);
    $visitor_reason = test_input($_POST['contactReason']);
    $visitor_comment = test_input($_POST['recipientComment']);
    $mailingList = test_input($_POST['mailingList']);
    $moreInformation = test_input($_POST['moreInformation']);
    $honeypot = $_POST['hiddenField'];

    $visitor_name_error = $_POST['visitor_name_error'];
    $visitor_email_error = $_POST['visitor_email_error'];
    $visitor_reason_error = $_POST['visitor_reason_error'];
    $visitor_comment_error = $_POST['visitor_comment_error'];

        function validateName($inName) {
            global $validForm, $visitor_name_error; // global variables
            $visitor_name_error = "";
            
            if($inName == "") {
              $validForm = false;
              $visitor_name_error = "Name cannot be left blank or have spaces";
            }
        }//end validateName()

      function validateEmail($inEmail) {

            global $validForm, $visitor_email_error; // global variables

            $visitor_email_error = "";

            if (empty($inEmail)) {
                $validForm = false;
          $visitor_email_error = "Email is required.";
                } else {
                    if (!filter_var($inEmail, FILTER_VALIDATE_EMAIL)) {
                        $validForm = false;
                        $visitor_email_error = "Invalid email format.";
                    }
                }
        }

      function validatePreference ($inPreference) {
        global $validForm, $visitor_reason_error;

        $visitor_reason_error = "";

        if (empty($inPreference)) {
          $validForm = false;
          $visitor_reason_error = "Please select your contact preference.";
        }
      }

      function validateComment($inComment) {
        global $validForm, $visitor_comment_error, $visitor_reason;

        $visitor_comment_error = "";

        if ($visitor_reason == "other" || $visitor_reason == "default" && empty($inComment)) {
        
        $validForm = false;
        $visitor_comment_error = "Please write a message.";
        } 
      }

      function validateHoneyPot($inHoney) {
        if (!empty($inHoney)) {
          $validForm = false;
        }
      }

      $validForm = true; 

      validateName($visitor_name);
      validateEmail($visitor_email);
      validatePreference($visitor_reason);
      validateComment($visitor_comment);
      validateHoneyPot($honeypot);


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

        $message = "<h1>Form has been submitted!</h1>";
        $message = "<div id='confirmationModal'>
                          <div class='confirmationModalContent'>
                          <span class='closeSuccessModal'>&times;</span>
                              <h1>Success!</h1>
                                  <p>Your message has been sent!</p>
              <ul class='list-group'>
                <li class='list-group-item'><strong>Name: </strong> $visitor_name </li>
                <li class='list-group-item'><strong>Email Address: </strong> $visitor_email</li>
                <li class='list-group-item'><strong>Contact Preference: </strong> $visitor_reason</li>
                <li class='list-group-item'><strong>Message: $visitor_comment</strong></li>
                <li class='list-group-item'><strong>Mailing List: $mailingList</strong></li>
                <li class='list-group-item'><strong>More Information?: $moreInformation</strong></li>
                <li class='list-group-item'><strong>Time Sent: $timestamp</strong></li>
              </ul>
              <br>
              <p>
                  <a href='https://github.com/devDandy/WDV341-/tree/master/contactform'><button>View PHP</button></a>
              </p>
              <br>
                          </div>
                      </div>";
        }else {

        }
      }

      
 


     function test_input($data) { // Checks htmlspecialchars
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
  ?>


<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Contact Form Processing</title>
<link href="https://fonts.googleapis.com/css?family=Berkshire+Swash|Poppins" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

  <style>
    * {
      box-sizing: border-box;
    }
    body {
      background: #13232f;
    }
    p {
      font-family: 'Poppins', sans-serif;
    }

    .container {
      margin: 5em auto;
      width: 75%;
    }

    form {
      margin: auto;
      width: 75%;
      padding: 25px;
      border-radius: 10px;
      color: white; 

    }
    .formHeader {
      background: #1ab188;
      padding: 15px 20px;
      border-radius: 4px;
      font-family: 'Berkshire Swash', cursive;
      text-align: center;
      text-shadow: 5px 1px #13232f;

    }
    input[type="text"],input[type="email"] {
      width: 100% !important;
      background-color: #1ab188;
      color: #FFF9C4;
      padding: 14px 20px;
      border: none;
      border-radius: 4px;
      font-family: 'Raleway', sans-serif;
      font-size: 16px;
      font-weight: bold;
    }

    input[type="text"]:focus,input[type="email"]:focus {
      background: #21ddaa;
      border:5px solid black;
      color: black;
    }

    select {
      width: 50%;
      background-color: #1ab188;
      color: #FFF9C4;
      padding: 13px 19px;
      border: none;
      border-radius: 4px;
      font-family: 'Raleway', sans-serif;
      font-size: 16px;
      font-weight: bold;
    }
    textarea {
      width: 100%;
      background-color: #1ab188;
      color: #FFF9C4;
      padding: 14px 20px;
      border: none;
      border-radius: 4px;
      font-family: 'Raleway', sans-serif;
      font-size: 16px;
      font-weight: bold;
    }




    #submitForm, #resetForm {
      width: 25%;
      background-color: #1ab188;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      font-family: 'Raleway', sans-serif;
      font-weight: bold;
      cursor: pointer;
    }
    .viewPHPButton {
        width: 25%;
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
    .error {
      float: right;
      color: red;
    }

    label {
      display: block;
    }
#confirmationModal {
  position: fixed;
  /* Stay in place */
  z-index: 1000;
  /* Sit on top */
  padding-top: 100px;
  /* Location of the box */
  left: 0;
  top: 0;
  width: 100%;
  /* Full width */
  height: 100%;
  /* Full height */
  overflow: auto;
  /* Enable scroll if needed */
  background-color: black;
  /* Fallback color */
  background-color: rgba(0, 0, 0, 0.4);
  /* Black w/ opacity */ }

.confirmationModalContent {
  background-color: #3D5AFE;
  color: white;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%; }
  .confirmationModalContent h1, .confirmationModalContent p {
    text-align: center !important; }
  .confirmationModalContent ul li {
    color: black; }
  .confirmationModalContent button {
    display: inline-block;
    text-align: center;
    background: inherit;
    padding: 10px;
    border: 2px solid white;
    border-radius: 50px;
    color: white;
    outline: 0; }
    .confirmationModalContent button:hover {
      background: #536DFE;
      cursor: pointer; }

.closeSuccessModal {
  color: #EEFF41;
  float: right;
  font-size: 28px;
  font-weight: bold; }
  .closeSuccessModal:hover, .closeSuccessModal:focus {
    color: #EEFF41;
    opacity: 0.8;
    text-decoration: none;
    cursor: pointer; }


  </style>
</head>

<body>
  <div class="container">
    <div>
      <?php echo $message ?>
    </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="contactForm" method="POST" >
<div class="innerFormContainer">
<h1 class="formHeader">Programming Project - Contact Form</h1>
  <p>
    <label for="recipientName">Your Name:<span class="error" name="visitor_name_error"><?php echo $visitor_name_error ?></span><br>
      <input type="text" name="recipientName" id="recipientName">
    </label>
  </p>
  <p>
    <label for="recipientEmail">Your Email:<span class="error" name="visitor_email_error"><?php echo $visitor_email_error ?></span><br> 
      <input type="email" name="recipientEmail" id="recipientEmail">
    </label>
  </p>
  <p>Reason for contact:<span class="error" name="visitor_reason_error"><?php echo $visitor_reason_error ?></span><br>
    <label>
      <select name="contactReason" id="contactReason">
        <option value="default ">Please Select a Reason</option>
        <option value="product ">Product Problem</option>
        <option value="return ">Return a Product</option>
        <option value="billing ">Billing Question</option>
        <option value="technical ">Report a Website Problem</option>
        <option value="other ">Other</option>
      </select>
    </label>
  </p>
  <p>
    <label for="recipientComment">Comments:<span class="error" name="visitor_comment_error"><?php echo $visitor_comment_error ?></span><br>
      <textarea name="recipientComment" id="recipientComment" cols="45" rows="5"></textarea>
    </label>
  </p>
  <p>
    <label for="mailingList">
      <input type="checkbox" name="mailingList" id="mailingList" value="Yes" checked>
      Please put me on your mailing list.</label>
  </p>
  <p>
    <label for="moreInformation">
      <input type="checkbox" name="moreInformation" id="moreInformation" value="Yes" checked>
      Send me more information</label>
  about your products.  </p>
  <p>
    <input type="hidden" name="hiddenField" id="hiddenField" value="application-id:US447">
  </p>
  <p>
    <input type="submit" name="submit" id="submitForm" value="Submit">
    <input type="reset" name="reset" id="resetForm" value="Reset">
  </p>
</div> 
<!-- innerformcontainer -->
</form>

  </div>
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
