<?php
	//Get the Event data from the server.

	try {
		include 'connectPDO.php';
		$stmt = $conn->prepare("SELECT 
			event_name, 
			event_description, 
			event_presenter, 
			event_day, 
			event_time, 
			DATE_FORMAT(event_day, '%m-%d-%Y') AS event_day, 
			TIME_FORMAT(event_time, '%h:%i %p') AS event_time 
			FROM wdv341_events 
			ORDER BY event_day");
		$stmt->execute();

	} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WDV341 Intro PHP  - Display Events Example</title>
    <style>
	    body {
	    	background: #7FDBFF;
	    }

    	h1, h2, h3 {
    		text-align: center;
    	}

		.eventBlock{
			width: 75%;
			margin: 0 auto;
			background: white;
			border-radius: 5px;
		}

		
		.displayEvent{
			font-size:18px;	
			text-align: center;
			border-bottom: 2px solid black;
		}
		
		.displayDescription {
			float: right;
			margin-right: 15px;
		}
		a {
			text-align: center;
		}
		button {
			margin: 0 auto;
			background: #FFDC00;
			padding: 16px;
			border: none;
			border-radius: 5px;
			color: black;
			font-weight: bold;

		}
	</style>
</head>

<body>
	<div class="container">
    <h1>WDV341 Intro PHP</h1>
    <h2>Example Code - Display Events as formatted output blocks</h2>   
    <h3> <?php echo $stmt->rowCount(); ?> Events are available today.</h3>
    <a href=""><button>View PHP</button></a>
<?php
	//Display each row as formatted output
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	//Turn each row of the result into an associative array 
  	{
		//For each row you have in the array create a block of formatted text
?>
	<p>
        <div class="eventBlock">	
            <div class="displayEvent">
            	<span ><strong><?php echo $row["event_name"]; ?></strong></span>
            </div>
            	<div class="displayDescription">Description:<br> <strong><?php echo $row["event_description"]; ?></strong></div>
            <div>
            	Presenter: <strong><?php echo $row["event_presenter"]; ?></strong>
            </div>
            <div>
            	<span class="displayTime">Time: <strong><?php echo $row["event_time"]; ?></strong></span>
            </div>
            <div>
            	<span class="displayDate">Date: <strong><?php echo $row["event_day"]; ?></strong></span>
            </div>
        </div>
    </p>

<?php
  	}//close while loop
	$conn = null;	//Close the database connection	
?>
</div>	
</body>
</html>