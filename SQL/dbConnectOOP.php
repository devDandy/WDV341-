<?php
//	This file contains the PHP coding to connect to my class database called gullydsm_dmacc.
//
//	Include this file in any page that needs to access the database.
//  Use the following settings to connect to the dmacc database
//

$hostname = "localhost";			
$username = "devdan37_dan";		//database/username from control panel
$password = "SuperSmoothCookies33435";		//database password	from control panel for the 
$database = "devdan37_wdv341";		//name of database/username from control panel

//Create connection object to the MySQL database server

$link = new mysqli($hostname, $username, $password, $database);


//Check connection with DEVELOPMENT exception handling

if($link->connect_error)
{
	die("Connection Failed: " . $link->connect_error);	
}
else
{
	//echo "Connected Successfully";
}

?>