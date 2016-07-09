<?php
session_start();
$_SESSION['userId']="";
$_SESSION['userStat']="";
$_SESSION['userType']="";
$_SESSION['db']="";

session_destroy();

//header('Location: index.html');
 header("Location: http://localhost:81/index.html", true);

//echo "<br><br><p>You have been logged out</p>
//<p><a href='index.html' title='Logout'>Click here to login.<br></a>";

?>
