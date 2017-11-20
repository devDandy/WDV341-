<?php

//The following section of PHP acts as the Controller.  It contains the processing logic
//needed to gather the data from the database table.  Format the data into a presentation
//format that can be viewed on the client's browser.
	try {
		require 'connectPDO.php';

		$stmt = $conn->prepare("SELECT event_id, event_name, event_description, event_presenter, event_date, event_time FROM wdv341_event ORDER BY event_id");
		$stmt->execute();


			$displayMsg = "<table class='infoTable'>";
			$displayMsg .= "<tr><th>";
			$displayMsg .= "Event Name";
			$displayMsg .= "</th>";
			$displayMsg .= "<th>";
			$displayMsg .= "Event Description:";
			$displayMsg .= "</th>";
			$displayMsg .= "<th>";
			$displayMsg .= "Event Presenter";
			$displayMsg .= "</th>";
			$displayMsg .= "<th>";
			$displayMsg .= "Event Date";
			$displayMsg .= "</th>";
			$displayMsg .= "<th>";
			$displayMsg .= "Event Time";
			$displayMsg .= "</th>";
			$displayMsg .= "<th>";
			$displayMsg .= "Update Event";
			$displayMsg .= "</th></tr>";
			

			$displayMsg .= "<ul class='table-data'>";

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$eventID = $row["event_id"];
				$displayMsg .= "<tr><td>";
				$displayMsg .= $row["event_name"];
				$displayMsg .= "</td><td>";
				$displayMsg .= $row["event_description"];
				$displayMsg .= "</td><td>";
				$displayMsg .= $row["event_presenter"];
				$displayMsg .= "</td><td>";
				$displayMsg .= $row["event_date"];
				$displayMsg .= "</td><td>";
				$displayMsg .= $row["event_time"];
				$displayMsg .= "</td><td>";
				$displayMsg .= "<a href=''>
									<img src='img/pencil.png' title='Edit information' alt='Edit information'>
								</a> 
								<a href='deleteEvents.php?event_id=$eventID'>
								<img src='img/delete.png' title='Delete information ' alt='Delete information'>
								</a>";
				$displayMsg .= "</td></tr>";
			}
			$displayMsg .= "</table>";




	}  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
//The following HTML or markup is the VIEW.  This will be sent to the client for display in their browser.
//Notice that we echo the $displayMsg variable which contains the formatted output that we created in the 
//Controller area above.  	
?>
<html>
<head>
	<title>WDV341 SELECT Example</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<style>
		* {
			margin: 0;
			padding: 0;

		}
		body {
			background: #2980b9;  /* fallback for old browsers */
			background: -webkit-linear-gradient(to right, #2c3e50, #2980b9);  /* Chrome 10-25, Safari 5.1-6 */
			background: linear-gradient(to right, #2c3e50, #2980b9); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			font-family: 'Open Sans', sans-serif;
		}

		h1 {
			color: white;
			text-align: center;
		}
		.infoTable {
			background: #2980b9;  /* fallback for old browsers */
			background: -webkit-linear-gradient(to right, #FCA5F1 , #B5FFFF);  /* Chrome 10-25, Safari 5.1-6 */
			background: linear-gradient(to right, #FCA5F1 , #B5FFFF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			margin: 0 auto;
			padding: 20px;
			border-radius: 5px;
			overflow-x: auto !important;
			color: black;
		}

		.tableFormat {
			border-collapse: collapse;
			border-spacing: 0;
		}
		.tableFormat th, td {
			text-align: center;
			padding: 5px;
		}
		 th {
			border-bottom: 2px solid black;
		}



	</style>
</head>
<body>
	<h1>We found the following information.</h1>
	<div id="content">
		<?php echo $displayMsg; ?>
	</div>

</body>
</html>
