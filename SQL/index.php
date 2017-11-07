<?php 
	
	$cust_email = "";
	$cust_pref1 = "";
	$cust_pref2 = "";
	$cust_pref3 = "";
	$cust_pref4 = "";

	$cust_email_error = "";
	$cust_pref_error = "";
	 $recaptcha_error = "";
		$cust_pref1_error = "";
		$cust_pref2_error = "";
		$cust_pref3_error = "";
		$cust_pref4_error = "";

	$validForm = false;

    if (isset($_POST["submit"])) {
    	$cust_email = $_POST["cust_email"];
		$cust_pref1 = $_POST["cust_pref1"];
		$cust_pref2 = $_POST["cust_pref2"];
		$cust_pref3 = $_POST["cust_pref3"];
		$cust_pref4 = $_POST["cust_pref4"];

		$recaptcha_error= $_POST["recaptcha_error"];
		$cust_email_error = $_POST["cust_email_error"];
		$cust_pref_error = $_POST["cust_pref_error"];

		$cust_pref1_error = $_POST["cust_pref1_error"];
		$cust_pref2_error = $_POST["cust_pref2_error"];
		$cust_pref3_error = $_POST["cust_pref3_error"];
		$cust_pref4_error = $_POST["cust_pref4_error"];


		function validateEmail($inEmail) {
			global $validForm, $cust_email_error;

			$cust_email_error = "";

            if (!filter_var($inEmail, FILTER_VALIDATE_EMAIL)) {
                $validForm = false;
                $cust_email_error = 'Invalid email format.';			
            }
		}

		function validatePreference($inPreference) {
			global $validForm, $cust_pref_error;

			$cust_pref_error = "";
			if (empty($inPreference)) {
				$validForm = false; 
				$cust_pref_error= "Please make sure every button is selected.";
			}
		}

		function validatePreferenceTwo($inPreference, $inPreferenceError) {
			global $validForm;
			$inPreferenceError = "";
			if (empty($inPreference)) {
				$validForm = false; 
				$inPreferenceError = "Please select an option.";
			}
		}
        function reCAPTCHA() {
                global $validForm, $recaptcha_error;

                $recaptcha_error = "";

                function post_captcha($user_response) {
                    $fields_string = '';
                    $fields = array(
                        'secret' => '6Lef7jYUAAAAAIgszZsKt8ViGACk1YsC65road0Y',
                        'response' => $user_response
                    );
                    foreach($fields as $key=>$value)
                    $fields_string .= $key . '=' . $value . '&';
                    $fields_string = rtrim($fields_string, '&');

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

                    $result = curl_exec($ch);
                    curl_close($ch);

                    return json_decode($result, true);
                }
                $res = post_captcha($_POST['g-recaptcha-response']);

                if (!$res['success']) {
                    $recaptcha_error = "Please make sure you click the CAPTCHA box.";
                    $validForm = false;
                } else {
                    $validForm = true;
                }
        }

        $validForm = true;

        validateEmail($cust_email);
        validatePreference($cust_pref1);
        validatePreference($cust_pref2);
        validatePreference($cust_pref3);
        validatePreference($cust_pref4);
		reCAPTCHA();

        // validatePreferenceTwo($cust_pref1, $cust_pref1_error);
        // validatePreferenceTwo($cust_pref2, $cust_pref2_error);
        // validatePreferenceTwo($cust_pref3, $cust_pref3_error);
        // validatePreferenceTwo($cust_pref4, $cust_pref4_error);




        if ($validForm) {


            try {
                
                require 'connectPDO.php';  //CONNECT to the database
                
                //mysql DATE stores data in a YYYY-MM-DD format
                $todaysDate = date("Y-m-d");        //use today's date as the default input to the date( )
                
                //Create the SQL command string
                $sql = "INSERT INTO time_preferences (";
                $sql .= "cust_email, ";
                $sql .= "cust_pref1, ";
                $sql .= "cust_pref2, ";
                $sql .= "cust_pref3, ";
                $sql .= "cust_pref4 ";
                $sql .= ") VALUES (:cust_email, :cust_pref1, :cust_pref2, :cust_pref3, :cust_pref4)";
                
                //PREPARE the SQL statement
                $stmt = $conn->prepare($sql);
                
                //BIND the values to the input parameters of the prepared statement
                $stmt->bindParam(':cust_email', $cust_email); // Assign :firstname to $presenter_first_name
                $stmt->bindParam(':cust_pref1', $cust_pref1);        
                $stmt->bindParam(':cust_pref2', $cust_pref2);     
                $stmt->bindParam(':cust_pref3', $cust_pref3);     
                $stmt->bindParam(':cust_pref4', $cust_pref4);
                
                //EXECUTE the prepared statement
                $stmt->execute();   
                
                $message = "<script>alert('Survey Sent!')</script>";
            }

            catch(PDOException $e)
            {
                $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
    
                error_log($e->getMessage());            //Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
                error_log(var_dump(debug_backtrace()));
            
                //Clean up any variables or connections that have been left hanging by this error.      
            
            }
            echo $message;

        } else {
                echo "<script>alert('Not good!')</script>";  
        }


    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Survey Tool</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<style>

		* {
			font-family: 'Open Sans', sans-serif;
		}
		body {
			background: #001f3f;
		}

		form {
			width: 75%;
			margin: 0 auto;
			background: #7FDBFF;
			text-align: center;
		}
		.error {
			color: red;
			font-weight: bold;
		}

		.btn {
			width: 25%;
			background: #001f3f;
			margin-bottom: 25px;
			padding: 20px;
			border: 0;
			border-radius: 5px;
			color: #7FDBFF;
		}
		.btn:hover {
			cursor: pointer;
		}
		.recaptcha div {
			margin: 0 auto;
			text-align: center;
		}



	</style>
	<script>

		var cust_pref1 = document.getElementsByName('cust_pref1');
		var cust_pref2 = document.getElementsByName('cust_pref2');
		var cust_pref3 = document.getElementsByName('cust_pref3');
		var cust_pref4 = document.getElementsByName('cust_pref4');
		if (cust_pref1 == none) {

		}
	</script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	<h1>Survey</h1>

		<p><label>Email Address</label><br>
        <input type="text" name="cust_email" maxlength="25"><br><span class="error"><?php echo $cust_email_error  ?> </span></p>
        <label>Please rate the following times: <strong>(1 being the best, and 4 being the worst)</strong>:</label>
        <p>Monday/Wednesday- 10:10am-Noon</p><span name="cust_pref1_error"><?php echo $cust_pref1_error ?></span>
          <input type="radio" name="cust_pref1" value="1"> 1<br>
		  <input type="radio" name="cust_pref1" value="2"> 2<br>
		  <input type="radio" name="cust_pref1" value="3"> 3<br>
		  <input type="radio" name="cust_pref1" value="4"> 4<br>
        <p>Tuesday- 6:00pm-9:00pm</p><span name="cust_pref2_error"><?php echo $cust_pref2_error ?></span>
          <input type="radio" name="cust_pref2" value="1"> 1<br>
		  <input type="radio" name="cust_pref2" value="2"> 2<br>
		  <input type="radio" name="cust_pref2" value="3"> 3<br>
		  <input type="radio" name="cust_pref2" value="4"> 4<br>
        <p>Wednesday- 6:00pm-9:00pm</p><span name="cust_pref3_error"><?php echo $cust_pref3_error ?></span>
          <input type="radio" name="cust_pref3" value="1"> 1<br>
		  <input type="radio" name="cust_pref3" value="2"> 2<br>
		  <input type="radio" name="cust_pref3" value="3"> 3<br>
		  <input type="radio" name="cust_pref3" value="4"> 4<br>
        <p>Tuesday/Thursday 10:10am-Noon</p><span name="cust_pref4_error"><?php echo $cust_pref4_error ?></span>
          <input type="radio" name="cust_pref4" value="1"> 1<br>
		  <input type="radio" name="cust_pref4" value="2"> 2<br>
		  <input type="radio" name="cust_pref4" value="3"> 3<br>
		  <input type="radio" name="cust_pref4" value="4"> 4<br>

		  <p class="error"><?php echo $cust_pref_error ?> </p>

        <label for="Google reCAPTCHA" class="recaptcha">
                <div class="g-recaptcha" data-sitekey="6Lef7jYUAAAAAPTFGJ0z3REnq6B3FynQiFiqn9RK"></div>
                <br>
                <span class="error recaptcha"><?php echo $recaptcha_error; ?></span>
         </label>
         <br>
         <input type="submit" name="submit" class="btn" value="Submit">
         <input type="reset" name="reset" class="btn" value="Reset">
        <a href="">
        	<input type="reset" name="reset" class="btn" value="View PHP">
        </a>
	</form>
</body>
</html>