<?php
include("database_queries.php");
if (!empty($_GET["logout"]))
{
        set_user_logged_out();
        $userID = 0;
}
else
{
        $userID = get_user_logged_in();
}
?>

<!-- This is the start of the MySocial HTML code for every page-->
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Just+Another+Hand' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css" />   
<title>Welcome to Connect+</title>
</head>

<body>

<div id = "topcontainer">  
<div id = "header" style="padding-top:2%"> 
 <a href = "index.php">Connect+</a>
<!-- NOTE: here you can modify the header text of this website.  Perhaps, add an image --> 




<div id = "navigation">
<?php
		/*if ($userID == 0)
        {
               
                echo("| <a href = 'user_form.php'>LOGIN OR REGISTER</a> ");

                      
     
        }
        */
		
        	if ($userID != 0) {
                $username = database_get_username($userID);
                echo(" <span style = 'font-weight: bold'>Welcome, " . $username . "</span> | ");
                echo("<a href = 'index.php?logout=1'>Logout</a> ");
        
		
        		echo ("| <a href = 'index.php'> Home </a> | ");
				echo("<a href = 'user.php?userID=".$userID."'>Profile</a> | ");
        		}

?>
</div>
</div>
</div>