<?php


    $event_name = "";
    $event_description = "";
    $event_presenter = "";
    $event_date = "";
    $event_time = "";

    $event_name_error = "";
    $event_description_error = "";
    $event_presenter_error = "";
    $event_date_error = "";
    $event_time_error = "";
    $validForm = false;

    if (isset($_POST["submit"])) {

        $event_name = $_POST["event_name"];
        $event_description = $_POST["event_description"];
        $event_presenter = $_POST["event_presenter"];
        $event_date = $_POST["event_date"];
        $event_time = $_POST["event_time"];

        $event_name_error = $_POST["event_name_error"];
        $event_description_error = $_POST["event_description_error"];
        $event_presenter_error = $_POST["event_presenter_error"];
        $event_date_error = $_POST["event_date_error"];
        $event_time_error = $_POST["event_time_error"];



            function validateEventName($inEventName) {
                global $validForm, $event_name_error;        //Use the GLOBAL Version of these variables instead of making them local
                $event_name_error = "";
                
                if($inEventName == "") {
                    $validForm = false;
                    $event_name_error = "Name is required";
                }
            }//end validateName()

            function validatePresenter($inPresenter) {
                global $validForm, $event_presenter_error;

                $event_presenter_error = "";

                if($inPresenter == "") {
                    $validForm = false;
                    $event_presenter_error = "Presenter is required";
                }
            }

            function validateDate($inDate) {
                global $validForm, $event_date_error;

                $event_date_error = "";
                if ($inDate == "") {
                     $validForm = false;
                     $event_date_error = "Date is required";
                 } 
            }

            function validateTime($inTime) {
                global $validForm, $event_time_error;

                $event_time_error = "";
                if ($inTime == "") {
                    $validForm = false;
                    $event_time_error = "Time is required.";
                }
            }

            function validateDescription($inDescription) {
                global $validForm, $event_description_error;

                $event_description_error = "";

                if ($inDescription == "") {
                    $validForm = false;
                    $event_description_error = "Description is required";
                } 
            }
            function reCAPTCHA() {
                global $validForm, $recaptchaError;

                $recaptchaError = "";

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
                    $recaptchaError = "Please make sure you click the CAPTCHA box.";
                    $validForm = false;
                } else {
                    $validForm = true;
                }
            }

            $validForm = true;      //switch for keeping track of any form validation errors

            validateEventName($event_name);
            validatePresenter($event_presenter);
            validateDate($event_date);
            validateTime($event_time);
            validateDescription($event_description);
            // reCAPTCHA();

            if($validForm) {
                echo "<script>alert('All good')</script>";  

            try {
                
                require 'connectPDO.php';  //CONNECT to the database
                
                //mysql DATE stores data in a YYYY-MM-DD format
                $todaysDate = date("Y-m-d");        //use today's date as the default input to the date( )
                
                //Create the SQL command string
                $sql = "INSERT INTO wdv341_event (";
                $sql .= "event_name, ";
                $sql .= "event_description, ";
                $sql .= "event_presenter, ";
                $sql .= "event_date, ";
                $sql .= "event_time ";
                $sql .= ") VALUES (:event_name, :event_description, :event_presenter, :event_date, :event_time)";
                
                //PREPARE the SQL statement
                $stmt = $conn->prepare($sql);
                
                //BIND the values to the input parameters of the prepared statement
                $stmt->bindParam(':event_name', $event_name); // Assign :firstname to $presenter_first_name
                $stmt->bindParam(':event_presenter', $event_presenter);        
                $stmt->bindParam(':event_date', $event_date);     
                $stmt->bindParam(':event_time', $event_time);     
                $stmt->bindParam(':event_description', $event_description);
                
                //EXECUTE the prepared statement
                $stmt->execute();   
                
                $message = "The Event has been registered.";
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
	<title>Events Form Page</title>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="https://resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <link rel="stylesheet" type="text/css" href="timepicker/jquery.timepicker.min.css">
      <script src="timepicker/jquery.timepicker.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
    $(document).ready(function(){

        $( function() {
            $( "#datepicker" ).datepicker();
          } );
        });

        $( function() {
            $('#timePicker').timepicker();
          } );
        
    </script>

</head>
<body>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Event Name:</label> <br>
        <input type="text" name="event_name" maxlength="25"><span class="error" name="event_name_error"><?php echo $event_name_error; ?> </span><br>
        
        <label>Event Presenter:</label><br>
        <input type="text" name="event_presenter" maxlength="25"><span class="error" name="event_presenter_error"><?php echo $event_presenter_error; ?></span><br>
        
        <label>Event Date:</label> <br>
        <input type="text" name="event_date" id="datepicker"><span class="error" name="event_date_error"><?php echo $event_date_error; ?></span><br>
        
        <label>Event Time:</label> <br>
        <input id="timePicker" type="timepicker" class="time" name="event_time" ><span class="error" name="event_time_error"><?php echo $event_time_error; ?></span><br>

        <label>Event Description:</label><br>
        <textarea cols="50" rows="4" name="event_description" maxlength="500"></textarea><span class="error" name="event_description_error"><?php echo $event_description_error; ?></span><br>

        <label for="Google reCAPTCHA" class="PrimaryContact">
                <span class="contactPageError recaptcha"><?php echo $recaptchaError; ?></span>
                <div class="g-recaptcha" data-sitekey="6Lef7jYUAAAAAPTFGJ0z3REnq6B3FynQiFiqn9RK"></div>
                <br>
         </label>



        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">
	</form>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>