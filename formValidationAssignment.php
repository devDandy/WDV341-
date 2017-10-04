<?php 

session_start();

$custName = "";
$custSSN = "";
$custPreference = ""; 
$custNameError = "";
$custSSNError = "";
$custPreferenceError = ""; 

  $validForm = false;

  if(isset($_POST["submit"])) {

    //Gets the form values:
    $custName = $_POST["custName"];
    $custSSN = $_POST["custSSN"];
    $custPreference = $_POST["custPreference"];

    //Gets the error values
    $custNameError = $_POST["custNameError"];
    $custSSNError = $_POST["custSSNError"];
    $custPreferenceError = $_POST["custPreferenceError"];

    function validateFirstName($inName) {
        global $validForm, $custNameError; // global variables
        $custNameError = "";
        
        if($inName == "")
        {
          $validForm = false;
          $custNameError = "Name cannot be left blank or have spaces";
        }
      }//end validateName()

    function validateSocialSecurity($inSocialSecurity) {
      global $validForm, $custSSNError; // global variables
      $custSSNError = "";

      if (!is_numeric($inSocialSecurity)) {

        $validForm = false;
        $custSSNError = "Social Security has to be a number";

      } 
      else {
          if (preg_match('[-()]', $inSocialSecurity)) {

            $validForm = false;
            $custSSNError = "Cannot contain hypens '-' or parentheses'()' ";

          }
      }
    }

    function validateCustPreference($inCustPreference) {
      global $validForm, $custPreferenceError; // global variables

      if (empty($inCustPreference)) {
        $validForm = false; 
        $custPreferenceError = "Please select an perference";
      }
    }

    $validForm = true;

    validateFirstName($custName);
    validateSocialSecurity($custSSN);
    validateCustPreference($custPreference);

    if ($validForm) {
      $message = "All good!";
    } else {
      $message = "Something went wrong";
    }

  }

    if(isset($_POST["reset"])) {
      $custName = $_POST["custName"];
      $custSSN = $_POST["custSSN"];
      $custPreference = $_POST["custPreference"];

      //Gets the error values
      $custNameError = $_POST["custNameError"];
      $custSSNError = $_POST["custSSNError"];
      $custPreferenceError = $_POST["custPreferenceError"];

    }
    

?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP - Form Validation Example</title>
<style>

#orderArea	{
	width:600px;
  padding: 20px;
	background-color:#CF9;
}

.error	{
	color:red;
	font-style:italic;	
}

form h1 {
  text-align: center;
}

</style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Form Validation Assignment


</h2>
<div id="orderArea">
  <form id="orderForm" name="orderForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <h3>Customer Registration Form</h3>
  <label for="customerName">
    <p>Name:</p><input type="text" name="custName"> <span  class="error" name="custNameError"><?php echo $custNameError; ?></span>
  </label><br>
  <label for="custSSN">
    <p>Social Security:</p><input type="text" name="custSSN"> <span  class="error" name="custSSNError"><?php echo $custSSNError; ?></span>
  </label><br>
  <label for="custPreference">
    <p>Choose a response:</p> 
        <label>
          <input type="radio" name="custPreference" id="Phone">
          Phone</label>
        <br>
        <label>
          <input type="radio" name="custPreference" id="Email">
          Email</label>
        <br>
        <label>
          <input type="radio" name="custPreference" id="US_Mail">
          US Mail</label><br>
          <span  class="error" name="custPreferenceError"><?php echo $custPreferenceError; ?></span>
    </label>
  <p>
    <input type="submit" name="submit" id="reset" value="Register" />
    <input type="reset" name="reset" id="reset" value="Clear Form" />
  </p>
  <h1><?php echo $message ?></h1>
</form>
</div>

</body>
</html>