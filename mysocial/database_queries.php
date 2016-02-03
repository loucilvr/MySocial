<?php
include("connect.php");
include("security.php");



// NOTE: You can write a new function like this function 
// to get other fields from the database for this userID

function database_get_username($userID)	{
    global $mysqli;
    
    $userID = sanitize_input($userID);
    $q = "SELECT username FROM users WHERE userID='$userID'";
    
    $data = mysqli_query($mysqli, $q);
    $row = mysqli_fetch_array($data);
    
    $result = $row['username'];
    return $result;
}

// NOTE: You will want to change the function name from "database_get_username"
// to something like "database_get_newfield" where newfield is the name of your new field.
// You will need to change the SQL query so that it selects newfield.

function database_get_phone($userID)	{
    global $mysqli;
    
    $userID = sanitize_input($userID);
    $q = "SELECT phone FROM users WHERE userID='$userID'";
    
    $data = mysqli_query($mysqli, $q);
    $row = mysqli_fetch_array($data);
    
    $result = $row['phone'];
    return $result;
}



// NOTE: In this function, you can add more fields to be inserted into the database
// For example: database_add_user($username, $password, $picture, $newfield)
function database_add_user($username, $password, $picture, $phone)	{
    global $mysqli;
    // Sanitize the variables you passed in
    $username = sanitize_input($username);
    $password = sanitize_input($password);
	
    // NOTE: Add another variable to be sanitized here:
    $phone = sanitize_input($phone);
    
	// Hash the password so that it is not stored in the database as plain text
	$password = create_hash($password);
	// Process the picture for putting it in the database
	$picture = process_picture($picture);

	// NOTE: modify this query to also include the newfield
	// Insert the new user into the database
	$q1 = "INSERT INTO users (username, password, picture, phone)";
	$q2 = "VALUES ('$username','$password','$picture', '$phone')";
	
	$q = $q1 . $q2;
	$userID = 0;
    
    if (isUsernameTaken($username) == false)	{
        // Add the user to the database
    	mysqli_query($mysqli, $q);
        // Set this userID as logged in
        $userID = mysqli_insert_id($mysqli);
        set_user_logged_in($userID, $password);
    }
    
    return $userID;
}



//
// Below there are many more database functions; you can study these more outside of the assignment
//

// This function checks to see if a username is already in the users table
function isUsernameTaken($username)	{
    global $mysqli;
    // Check to see that name is not taken
	$q = "SELECT count(*) FROM users WHERE username='$username'";
    $result = mysqli_query($mysqli, $q);
    $row = mysqli_fetch_array($result);
    $num_users = $row[0];
    if ($num_users > 0) {
        return true;
    }
	else	{
        return false;
    }
}

// This function will mutually and automatically friend two people
function add_friend($userID, $friendID)	{
    global $mysqli;
    
    $userID = sanitize_input($userID);
    $friendID = sanitize_input($friendID);

    mysqli_query($mysqli, "INSERT INTO friends (userID, friendID) VALUES ('$userID', '$friendID')");
    mysqli_query($mysqli, "INSERT INTO friends (userID, friendID) VALUES ('$friendID', '$userID')");
}

// This gets all of the friendIDs for a userID
function database_get_friends($userID)	{
    global $mysqli;
    // Get all of the friends for this user
    $friends = array();
	$q = "SELECT DISTINCT friendID FROM friends WHERE userID = '$userID'";
    $result = mysqli_query($mysqli, $q);
    $i = 0;
    while ($row = mysqli_fetch_array($result))       {
        $friends[$i] = $row['friendID'];
        $i = $i + 1;
    }
	return $friends;
}

function database_show_friend_posts($userID)	{
    global $mysqli;
	// Print out the most recent post from each friend

	// Get all of the friends for this user
	$friends = database_get_friends($userID);
	array_push($friends, $userID); // Also show this user's posts
	$s = "";
	// Print the most recent post from each friend
	for ($i = 0; $i < sizeof($friends); $i++)	{
		$uID = $friends[$i];
		$q = "SELECT users.username, posts.message, posts.timestamp FROM users, posts "; 
		$q = $q . "WHERE posts.userID='$uID' AND users.userID='$uID' ";
		$q = $q . "ORDER BY posts.timestamp DESC LIMIT 2";

		$result = mysqli_query($mysqli, $q);
		while($row = mysqli_fetch_row($result))	{
			if ($row[0] != "")
				$s = $s . "<h1><a href='user.php?userID=$uID'> " . $row[0] . "</a> </h1>". $row[2]. " &nbsp; &nbsp;" . $row[1] . "<br /><br />";
		}
	}
	echo $s;
}

/* $posts = "<strong>" . $posts . $timestamp . ": </strong> <br>" . $message . "<br />"; */


// This shows all of the users in a bunch of floating divs
function database_show_users()	{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT userID, username, picture FROM users ORDER BY userID");
    while($row = mysqli_fetch_array($result))	{
    	$userID = $row['userID'];
    	$username = $row['username'];
    	$picture = $row['picture'];
    
    	echo "<div id = 'user'>\n";
        echo "<a href = 'user.php?userID=" . $userID . "'>\n";
    	echo "<img width = '120' height = '100' src = 'show_picture.php?id=$userID'><br />\n";
    	echo $username;
    	echo "</a></div>\n";
    }
}

// Get the userID for a particular username
function database_get_userID($username)	{
    global $mysqli;
	$username = sanitize_input($username);
	$q = "SELECT userID FROM users WHERE username = '$username'";
    $result = mysqli_query($mysqli, $q);
    $row = mysqli_fetch_array($result);
    $userID = $row['userID'];
    return $userID;
}

// Add a post for a userID
function database_add_user_post($userID, $message) {
    global $mysqli;
	// Sanitize the variables $userID and $message
	
	$userID = sanitize_input($userID);
	$message = sanitize_input($message);
	// Insert the data (userID, message) into the posts table
	$q = "INSERT INTO posts (userID,message,timestamp) VALUES ('$userID','$message',NOW())";
	mysqli_query($mysqli, $q);
}

// Get all of the posts for a userID
function database_get_user_posts($userID)	{
    global $mysqli;
	$userID = sanitize_input($userID);
	
    $posts = "";
	$q = "SELECT message,timestamp FROM posts WHERE userID='$userID' ORDER BY timestamp DESC";
	$result = mysqli_query($mysqli, $q);
	while($row = mysqli_fetch_array($result))
	{
		$message = stripslashes($row['message']);
        $timestamp = "<b>" . $row['timestamp'] . "</b>";
		$posts = $posts . $timestamp . ":<br>" . $message . "<br /><br />";
	}
    return $posts;
}

// This function opens the picture that was uploaded and prepares it for the database
function process_picture($pic)	{
	$data = "";
	if(filesize($pic) > 0)	{
		$data = imagecreatefromstring(file_get_contents($pic));
	}
	else	{
		// There was not a picture uploaded, use a default picture.
		$default_image = "images/default.png";
		$data = imagecreatefromstring(file_get_contents($default_image));
	}
	$newdata = resize_image($data,150,150);
	ob_start();
	imagejpeg($newdata);
	$contents = ob_get_contents();
	ob_end_clean();
	$newdata = addslashes($contents);
	return $newdata;
}

// This function resizes images and crops them down
function resize_image($data,$width,$height) {
	$w = imagesx($data);
	$h = imagesy($data);
	$ratio = min($width/$w, $height/$h);
	$width = $w * $ratio; $height = $h * $ratio;
	$newimg = imagecreatetruecolor($width,$height);
	imagecopyresampled($newimg, $data, 0,0,0,0,$width,$height,$w,$h);
	return $newimg;
}

?>
