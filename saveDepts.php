<?php
  session_start();
  include("db.php5");

  $unitId    = $_GET['unitId'];
  $deptId1   = $_GET['deptId'];
  $deptId    = $_POST['deptId'];
  $effdt     = $_POST['effdt'];
  $effStatus = $_POST['effStatus'];
  $deptDescr = $_POST['deptDescr'];
  $dud       = $_POST['dud'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $newtodo  = "replace into depts (unitId, deptId, effdt, effStatus, deptDescr, dud) values ('$unitId', '$deptId', '$effdt', '$effStatus', '$deptDescr', '$dud')";
  $uploadres = mysql_query($newtodo) or die('dept update failed: ' . mysql_error());
  
  echo "Saved: $deptId-$effdt";
?>