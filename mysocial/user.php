<?php
include("top.php");

// Get the userID to display
$userID = $_GET["userID"];

// NOTE:  Here you can use your new database query function to get
// more fields from the database
$username = database_get_username($userID);
$phone = database_get_phone($userID);

//Get the posts from this userID
$posts = database_get_user_posts($userID);
$loggedInUser = get_user_logged_in();
// See if we should add the friend
if (!empty($_GET["addfriend"])) {
	add_friend($loggedInUser, $userID);
}
?>
<!-- Start the content for this user -->
<div id = "container">
<div id = "picture">
<?php
	echo("<img width='120' height ='130' src='show_picture.php?id=$userID'>");
	if ($loggedInUser != 0)	{
		// Show the add friend link if this user is not the same user that is logged in
		if ($loggedInUser != $userID){
		 echo ("<br /><div id = 'addfriend'><a href = 'user.php?userID=$userID&addfriend=1'> Add Friend </a></div>");
		}
	}
?>
</div>

<div id = "subheader">
<h2>Profile:</h2> <?php echo($username); ?>

<!-- NOTE:  Here you can echo the new database field values, see the php code above echoing the $username -->
<!-- <strong>Phone:</strong>
<?php echo($phone); ?> -->
    
</div>

<br />
<?php
// Make a new post
if ($loggedInUser == $userID)	{
	echo ('<div id = "newpost">
		<form action="post_process.php" method="post" enctype="multipart/form-data">
		<label for="post">What have you been up to?</label><br>
		<input size="70" type="text" name="post" id="post" />
		<input type="submit" name="submit" value="Post!" />
		</form>
        <br><br>
        
         <h2>Posts:</h2> 
		</div>');
}
?>
<div id = "posts_all">
<?php echo($posts); 
	  echo "<br><br><br>";
    ?>
</div>

<br>
<br>
<br>
<br>
<div id = "friend_container">
<h2>My Connections:</h2>
<?php
        $friends = database_get_friends($userID);
        for ($i = 0; $i < sizeof($friends); $i++)	{
		$uid = $friends[$i];
		$username = database_get_username($uid);

		echo "<div id = 'user'>";
		echo "<a href = 'user.php?userID=$uid'>";
		echo "<img width = '100' src = 'show_picture.php?id=$uid'><br />";
		echo $username;
		echo "</a>";
		echo "</div>";
	}

?>
</div>


</div>
</body>
</html>
