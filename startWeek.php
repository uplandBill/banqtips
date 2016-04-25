<?php
  session_start();
  include("db.php5");
  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");   
  $db_selected = mysql_select_db($dbname);
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];
  echo "Start Week for unit $unitId.<br/>";

  echo '<form id="startWeek" name="startWeek">';
  echo "<table width='750'>";

  if ($func == "start") {
     $openWeek = "select 'Y' from wkendCal where unitId = '$unitId' and weekStatus='O'";
     $db_selected = mysql_select_db($dbname);
     $result = mysql_query($openWeek) or die('select open week failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     if ($rows > 0){
        echo "<tr><td>A new week cannot be started unitl last week is closed.</td></tr></table>";
     } else {
        $nextWe="select ";
        echo "<tr><td>Enter the Week Ending Date for the new week being started</td>";
        echo "<td><input type='text' name='wkendDate' class='tcal tcalInput' value=''/></td></tr>";
        echo "</table>";
        echo "</form>";
        echo '<input value="Start the Week" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"startWeek.php5?unitId='. $unitId . '&func=entered","startWeek")' . "'>";
    }
  }
  
  if ($func == "entered") {
     $wkendDate = $_POST[wkendDate];
     if ($wkendDate == "") {
        echo "<tr><td>Please select a weekending date.</td></tr>";
        echo "<td><input type='text' name='wkendDate' class='tcal tcalInput' value=''/></td></tr>";
        echo "</table>";
        echo "</form>";
        echo '<input value="Start the Week" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"startWeek.php5?unitId='. $unitId . '&func=entered","startWeek")' . "'>";
     } else {
        $getWeDay = "select wkendDay from units where unitId = '$unitId'";
        $result = mysql_query($getWeDay) or die('select weekend day failed: ' . mysql_error());
        $weData = mysql_fetch_array($result, MYSQL_NUM);
        $wkendDay = $weData[0];
        $enteredWeDay = date('l', strtotime($wkendDate));
        echo "New Weekending date is $wkendDate let's validate $enteredWeDay<br/>";
        if ($wkendDay <> $enteredWeDay) {
           echo "Date does match day for weekend.<br/>";
        } else {
           //check for dupes
           //check for historical
           //check for gaps     select max + 7 = date entered else error
           $wdate = date('Y-m-d',strtotime($wkendDate));
           $exWeek = "Select weekStatus from wkendCal Where unitId = '$unitId' and wkendDate='$wdate'";
           $result = mysql_query($exWeek) or die('select weekend day failed: ' . mysql_error());
           $curWeek  = mysql_fetch_array($result, MYSQL_NUM);
           $curStatus = $curWeek[0];
           if ($curStatus == 'O') {
              echo "This week is already in Open status.<br/>";
           } else {
              if ($curStatus == 'C') {
                 echo "This week has already been completed.  Use re-open week function.<br/>";
              } else {
                 $insWeek = "Insert into wkendCal (unitId, wkendDate, weekStatus, firstFuncNum, lastFuncNum) values ('$unitId','$wdate','O',0,0)";
                 $result = mysql_query($insWeek) or die('insert weekend day failed: ' . mysql_error());
                 echo "Date is confirmed.<br/>";
              }
           }
           
        }
     }
     echo "</table>";
  }
     
?>