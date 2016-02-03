<?php
include("database_queries.php");

// Get username and password from the form


$username = $_POST["username"];
$password = $_POST["password"];


// NOTE: Add another field to get from the user here:

// Get the phone number
$phone = $_POST["phone"];


// Get the picture file
$picture = $_FILES["file"]["tmp_name"];

// Insert the new user into the database and get the userID
// Send all information about the user to this function:
$userID = database_add_user($username, $password, $picture, $phone);  // NOTE: Add your new field variable here

if ($userID == 0)
{
	// This user could not be made, send the user to an error page
	header('Location: error.php?code=1');
}
else
{
	// Go to the new user's page
	header('Location: user.php?userID=' . $userID);
}
?>

