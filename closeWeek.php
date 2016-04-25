<?php

//depricated


  session_start();
  include("db.php5");
  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];
  echo "Close Week for unit $unitId<br/>";

  echo '<form id="closeWeek" name="startWeek">';
  echo "<table width='750'>";

  if ($func == "start") {
     $openWeek = "select wkendDate from wkendCal where unitId = '$unitId' and weekStatus='O'";
     $db_selected = mysql_select_db($dbname);
     $result = mysql_query($openWeek) or die('select open week failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     
     if ($rows == 0){
       	echo "<tr><td>There is no week Open for processing. Go to Start Week function.</td></tr>";
     } else {
        $curWeek  = mysql_fetch_array($result, MYSQL_NUM);
        $curWeDate = $curWeek[0];
       	echo "<tr><td>Click confirm button to close week ending $curWeDate</td></tr>";
        echo '<tr><td><input value="Confirm Close" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"closeWeek.php5?unitId='. $unitId . '&func=confirm","closeWeek")' . "'></td></tr>";
     }
    echo "</table>";
    echo "</form>";
  }
  
  if ($func == "confirm") {
     $openWeek = "select wkendDate from wkendCal where unitId = '$unitId' and weekStatus='O'";
     $db_selected = mysql_select_db($dbname);
     $result = mysql_query($openWeek) or die('select open week failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     
     if ($rows == 0){
       	echo "Someone else beat you to it.  Week is closed.<br/>";
     } else {
        $closeWeek = "update wkendCal set weekStatus='C' where unitId = '$unitId'";
        $db_selected = mysql_select_db($dbname);
        $result = mysql_query($closeWeek) or die('close week failed: ' . mysql_error());
     	echo "<tr><td>The week has been closed.</td>";
     }
    echo "</table>";
    echo "</form>";
     
     }
     
?>