<?php
  session_start();
  include("db.php5");

  $userid    = $_POST['userid'];
  $userName  = $_POST['userName'];
  $pwd       = $_POST['password'];
  $userStat  = $_POST['userStat'];
  $userType  = $_POST['userType'];
  $userMaint = $_POST['userMaint'];
  $email     = $_POST['email'];
  $unitId    = $_POST['unitId'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not connect to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $updSql   = "replace into users (userid, userName, password, userStat, userType, userMaint, email) values ('$userid', '$userName', '$pwd', '$userStat', '$userType', '$userMaint', '$email')";
  $uploadres = mysql_query($updSql) or die('user update failed: ' . mysql_error());
  
  echo "Saved: $userid-$userName";
?>