<?php include("top.php"); ?>

<!-- This is the user form page, which allows you to either login or -->
<!-- create a new user.  go down to the New User form to add another field -->    
    
<center>   
<div id = "form" style="padding-top:3%">
<br><br><br>
Login
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
New User
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
</body>

</div>
</body>
</html>

