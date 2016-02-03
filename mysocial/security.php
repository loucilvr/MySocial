<?php
function sanitize_input($s)	{
    global $mysqli;
    $s = strip_tags($s);
    $s = mysqli_real_escape_string($mysqli, $s);
    return $s;
}

// This function authorizes a username/password combination
function database_user_login($username, $password)	{
    global $mysqli;
    $username = sanitize_input($username);
    $password = sanitize_input($password);
    $userID = database_get_userID($username);

	$q = "SELECT password FROM users WHERE userID='$userID'";
    $result = mysqli_query($mysqli, $q);
    $row = mysqli_fetch_array($result);
    $datapass = $row['password'];

    // If the database password and the passed in password are the same
    // the user is verified.  Otherwise, return 0.
    if (validate_password($password, $datapass))
    {
        set_user_logged_in($userID);
    }
    else
    {
        set_user_logged_out();
        $userID = 0;
    }

    return $userID;
}

//
//  The following functions handle sessions
//  which allow users to log in and log out 
//  via cookies
//

function set_user_logged_out()	{
    session_destroy();
}

function get_user_logged_in()	{
	if (empty($_SESSION["user"]))	{
		return 0;
	}
	else	{
        return $_SESSION["user"];
	}
}

function set_user_logged_in($userID)	{
	$_SESSION["user"] = $userID;
}

//
//  The following functions are wrappers
//  for password_hash and password_verify
//  in case it is decided to change the password
//  hashing scheme in the future
//

function create_hash($password) {
	return password_hash($password, PASSWORD_BCRYPT);
}

function validate_password($password, $hash)	{
    return password_verify($password,$hash);
}

?>
