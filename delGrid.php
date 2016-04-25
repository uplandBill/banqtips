<?php
  session_start();
  include("db.php5");

  $unitId   = $_GET['unitId'];

  $eventNum = $_POST['eventNum'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);
  
  if ($unitId=="" || $eventNum=="")
     echo "Failed Delete: $unitId / $eventNum";
  else {
     $gridSave = "delete from funcEmps where unitId = '$unitId' and eventNum = $eventNum";
     $result = mysql_query($gridSave) or die("grid delete failed for: $unitId - $eventNum" . mysql_error());
     echo "GridDeleted";
  }

?>