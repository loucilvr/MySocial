<?php
require_once("connect.php");
global $mysqli;

$id = $_GET['id'];
$id = intval($id);
$q = "SELECT picture FROM users WHERE userID = '$id'";
$r = mysqli_query($mysqli, $q);
$row = mysqli_fetch_array($r);
header("Content-type: image");
echo $row['picture'];
mysql_close();

?>
