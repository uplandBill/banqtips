<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to BanqTips DB.");
  $db_selected = mysql_select_db($dbname);

  $unitId    = $_GET['unitId'];

  if ($userId == "") {
     echo "Please Logon";
  } else {
  	if ($unitId == "") {
       echo "Missing Parameters";
    } else {
       echo "<div class='listarea'>";
       echo "<p>Unit: <span id='unitId'>$unitId</span></p>";
       echo "<table border='1'>";
       echo "<tr><th>WeekEnding</th><th>Events</th><th>funcGrats</th><th>EmpCnts</th><th>FuncEmps</th><th>EmpGrats</th></tr>";
       //                      0         1                        2                        3            4             5     
       $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat, c.weekStatus";
       $getSQL = $getSQL ." from wkendCal c, units u ";
       $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId";
       $result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
       $rows   = mysql_num_rows($result);
       while($recs   = mysql_fetch_array($result, MYSQL_NUM)) {
          $wkendDate  = $recs[1];
          $wkEndForm  = $recs[2];
          $unitName   = $recs[3];
          $csvFormat  = $recs[4];
          $weekStatus = $recs[5];
          $Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
          echo "<tr><td>$wkendDate</td>";
          $eventCnt = 0;
          $funcGrats = 0;
          $funcEmpCnts = 0;
          $funcEmps = 0;
          $funcEmpGrats = 0;
          $today = date("F d, Y");
          $getSQL2 = "Select eventNum from events e where e.unitId= '$unitId' and e.wkendDate = '$wkendDate'";
          $result2 = mysql_query($getSQL2) or die('select weekend dat failed: ' . mysql_error());
          while ($recs2   = mysql_fetch_array($result2, MYSQL_NUM)) {
          	 $eventNum = $recs2[0];
          	 $eventCnt++;
             
             $getSQL3 = "Select count(*) from funcGrats e2";
             $getSQL3 = $getSQL3 ." where e2.unitId= '$unitId' and e2.eventNum = $eventNum";
             $result3 = mysql_query($getSQL3) or die('select weekend dat failed: ' . mysql_error());
             $recs3   = mysql_fetch_array($result3, MYSQL_NUM);
             $funcGrats = $funcGrats + $recs3[0];
             
             $getSQL3 = "Select count(*) from funcEmpCnts e2";
             $getSQL3 = $getSQL3 ." where e2.unitId= '$unitId' and e2.eventNum = $eventNum";
             $result3 = mysql_query($getSQL3) or die('select weekend dat failed: ' . mysql_error());
             $recs3   = mysql_fetch_array($result3, MYSQL_NUM);
             $funcEmpCnts = $funcEmpCnts + $recs3[0];
             
             $getSQL3 = "Select count(*) from funcEmps e2";
             $getSQL3 = $getSQL3 ." where e2.unitId= '$unitId' and e2.eventNum = $eventNum";
             $result3 = mysql_query($getSQL3) or die('select weekend dat failed: ' . mysql_error());
             $recs3   = mysql_fetch_array($result3, MYSQL_NUM);
             $funcEmps = $funcEmps + $recs3[0];
             
             $getSQL3 = "Select count(*) from funcEmpGrats e2";
             $getSQL3 = $getSQL3 ." where e2.unitId= '$unitId' and e2.eventNum = $eventNum";
             $result3 = mysql_query($getSQL3) or die('select weekend dat failed: ' . mysql_error());
             $recs3   = mysql_fetch_array($result3, MYSQL_NUM);
             $funcEmpGrats = $funcEmpGrats + $recs3[0];
          }
          echo "<td>$eventCnt</td><td>$funcGrats</td><td>$funcEmpCnts</td><td>$funcEmps</td><td>$funcEmpGrats</td></tr>";
       }
    }
  }
?>