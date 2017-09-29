<?php 
	$inMonth = $_POST["month"];
	$inDay = $_POST["day"];
	$inYear = $_POST["year"];
	$inRandonText = $_POST["randonText"];
	$inNumbersFormat = $_POST["numbersFormat"];
	$inCurrencyFormat = $_POST["currencyFormat"];

	function formatUSAdate($month, $day, $year) {
		$USAdate = date("m/d/Y");
		return $USAdate;
	}
	function formartIntDate($month, $day, $year) {
		$intDate = date("d/m/Y");
		return $intDate;
	}
	function randomText($text){
		$dmacc = "dmacc";
		$textConvert = strtolower(trim($text));
		$pos = strpos($textConvert,$dmacc);
		if($pos === false){
			$result = "<em>No</em>";
		}else{
			$result = "<em>Yes</em>";
		}
		return ("Converted to no leading or trailing white spaces & turned to all lowercase:<br><strong>" .$textConvert. "</strong><br>Character count:  <strong>". strlen($textConvert) ."</strong><br>DMACC substring found:  ". $result);
	}

	function formatNumbers($numbers) {
		$formatNumbers = number_format($numbers);
		return $formatNumbers;
	}
	function formatCurrency($numbers) {
		$formatNumbers = "$ " . number_format($numbers, 2);
		return $formatNumbers;
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Functions </title>
	<link href="https://fonts.googleapis.com/css?family=Droid+Sans|Raleway" rel="stylesheet">
	<style>
	body {
	background-color: #333E48;
	}

.container {
	width: 100%;
	height: auto;
	margin: 2em auto;
    border-radius: 5px;
    background-color: #ECEFF1;
    border:5px dashed #333E48;
    text-align: center;
}

input[type=button] {
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

input[type=button]:hover {
    background-color: #FF404E;
}

h1 {
	font-family: 'Raleway', sans-serif;
} 

.formatRequest {
	font-size: 1.3em;
	font-family: 'Raleway', sans-serif;
}
.formatAnswer {
	font-size: 1.3em;
	color: #009688;
	font-family: 'Droid Sans', sans-serif;

}

	</style>
</head>
<body>
<div class="container">
	<h1>PHP Functions Results</h1>
		<p class="formatRequest">USA Date Format:  (mm/dd/yyyy)</p>

		<p class="formatAnswer"><?php echo formatUSAdate($inMonth,$inDay,$inYear);  ?></p>

		<p class="formatRequest">International Date Format: (dd/mm/yyyy)</p>

		<p class="formatAnswer"><?php echo formartIntDate($inMonth,$inDay,$inYear);  ?></p>

		<p class="formatRequest">Input Text:</p>

		<p class="formatAnswer"><?php echo randomText($inRandonText); ?></p>

		<p class="formatRequest">Number Format:(e.g 100,000)</p>

		<p class="formatAnswer"><?php echo formatNumbers($inNumbersFormat); ?></p>

		<p class="formatRequest">USA Currency Format: (e.g $10.50)</p>

		<p class="formatAnswer"><?php echo formatCurrency($inCurrencyFormat); ?></p>
	<input type="button" name="submit" value="View PHP">
	<a href="phpFunctions.html"><input type="button" name="Reset" value="Back to HTML"></a>
</div>
</body>
</html>