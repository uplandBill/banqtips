<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to BanqTips DB.");   
  $db_selected = mysql_select_db($dbname);
 
  $unitId = $_GET['unitId'];

  if ($userId == "") {
     echo "Please Logon";
  } else {
  	if ($unitId == "") {
       echo "Missing Parameters";
    } else {
       echo "<div class='listarea'>";
       echo "<p>Unit: <span id='unitId'>$unitId</span></p>";
       //                      0         1                        2                        3            4
       $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u ";
       $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
       $result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
       $rows   = mysql_num_rows($result);
       $recs   = mysql_fetch_array($result, MYSQL_NUM);
       $wkendDate = $recs[1];
       $wkEndForm = $recs[2];
       $unitName  = $recs[3];
       $csvFormat = $recs[4];
       if ($rows > 0){
          $Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
          $today = date("F d, Y");
          echo "<p id='currWeekStat'>Status: Currently Open for Week Ending: $wkendDate</p>";
          $disabClose = "";
       } else {       
          echo "<p id='currWeekStat'>Status: There is not a Week Ending Open for processing</p>";
          $disabClose = "disabled";
       }
       echo '<input id= "wkendClose"  value="Close Week"    type="button" '. $disabClose .'/><br/>';
       echo '<input id= "wkendOpen"   value="(Re)Open New Week" type="button" />';
       echo "<input type='text' size = '10' name='openCloseDate'    id='openCloseDate'    value='' class='tcal tcalInput'/><br/>";
       echo "<span id='weekResult'></span>";
       echo "<div class='hidden' id='hiddenData3'></div>";
       echo "</div>";
       echo "<div class='weekEndList' id='weekEndList'>";
       echo "</div>";
    }
  }
?>