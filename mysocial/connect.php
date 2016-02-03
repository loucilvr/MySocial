<?php
// Connect to the database

// Database connection information
$server = "localhost";
$mysql_username = "mvr12";
$mysql_password = "124mahal67";
$database = "mysocial";

global $mysqli;

// Database Connection Commands
if (!($mysqli = mysqli_connect($server, $mysql_username , $mysql_password, $database)))
{
	// If the connect function did not work
	die("<br>Error: can't connect to database server. Check your connect.php file.");
}

// This starts or resumes a session with the client login
session_start();
?>
