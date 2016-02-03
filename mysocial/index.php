<?php include("top.php"); ?>

    

<?php 
if ($userID == 0) {
?>    
<div id = "form">
 <center>
<br>You are not logged in!
<br><br>
<span style='color:#04B4AE; font-weight:bold;'>Login</span><br>
<form action="user_process.php" method="post" enctype="multipart/form-data">

<label for="username">Username:</label>
<input type="text" name="username" id="username" autocomplete="off" />
<br>

<label for="password">Password:</label>
<input type="password" name="password" id="password" autocomplete="off" />
<br>

<input type="submit" name="submit" value="Login!" />
</form>
<br><br>
<span style='color:#04B4AE; font-weight:bold;'>Become a part of our community!</span><br><br>
<form name="userform" action="newuser_process.php" method="post" enctype="multipart/form-data">
    
<label for="username">Username:</label>
<input type="text" name="username" id="username" autocomplete="off"/>
<br>

<label for="password">Password:</label>
<input type="password" name="password" id="password" autocomplete="off"/>
<br>
    
<label for="file">Choose a Picture:</label>
<input type="file" name="file" id="file" /> 
<br />

<!-- NOTE: Add another field to collect for the new user here -->
<label for="phone">Phone Number:</label>
<input type="text" name="phone" id="phone" autocomplete="off"/>
<br>      
    
<input type="submit" name="submit" value="Create User!" />
</form>
</div>
</center>    


<?php } 

// If there is a logged in user, show status updates from your friends
else { ?>
<div id = "container">
<center><h1>Home</h1></center>
<br>

<div id = "friend_post_container">

<?php

// Show Friend Statuses
// 0 means that there is not a logged in user

	
	echo("<h2>News Feed</h2>");
	echo("<div id = 'posts'>");
	database_show_friend_posts($userID);
	echo("</div>");
?>
    
</div>

<div id = "user_container">
<h2>Connect with other members!</h2>
<?php
// Show all of the users on the website
database_show_users();
      
 } ?>
</div> 
