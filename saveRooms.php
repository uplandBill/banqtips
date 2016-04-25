<?php
  session_start();
  include("db.php5");

  $unitId    = $_GET['unitId'];
  $roomNum1  = $_GET['deptId'];
  $roomNum   = $_POST['roomNum'];
  $roomDescr = $_POST['roomDescr'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $newtodo  = "replace into rooms (unitId, roomNum, roomDescr) values ('$unitId', '$roomNum', '$roomDescr')";
  $uploadres = mysql_query($newtodo) or die('room update failed: ' . mysql_error());
  
  echo "Saved: $roomNum-$roomDescr";
?>