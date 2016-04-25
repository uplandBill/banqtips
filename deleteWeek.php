<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to BanqTips DB.");   
  $db_selected = mysql_select_db($dbname);
 
  $unitId    = $_GET['unitId'];
  $wkendDate = $_GET['wkendDate'];

  if ($userId == "") {
     echo "Please Logon";
  } else {
  	if ($unitId == "" || $wkendDate=="") {
       echo "Missing Parameters";
    } else {
       echo "<div class='listarea'>";
       if (substr($wkendDate,4,1) == "-")
          $wkendDate = $wkendDate;
       else
          if (substr($wkendDate,2,1) == "/")
             $wkendDate = substr($wkendDate,6,4) ."-". substr($wkendDate,0,2) ."-". substr($wkendDate,3,2);
          else
             $wkendDate = substr($wkendDate,0,4) ."-". substr($wkendDate,4,2) ."-". substr($wkendDate,6,2);
       echo "<p>Unit: <span id='unitId'>$unitId</span></p>";
       echo "<p>Week Ending: <span id='wkendDate'>$wkendDate</span>";
       include("comGetWkend.php5");  //Get Weekend rec for given week ending date, $wkendDate
       if ($rows > 0){
          $Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
          $today = date("F d, Y");
          echo "<span id='currWeekStat'>Status: $weekStatus</span>";
          
          $getSQL = "Select count(*) from events e where e.unitId= '$unitId' and e.wkendDate = '$wkendDate'";
          $result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
          $recs   = mysql_fetch_array($result, MYSQL_NUM);
          echo "  Number of events: $recs[0]</p>";
          
          $evSQL = "Select e.eventNum, e.funcNumWk, e.funcDate from events e where e.unitId= '$unitId' and e.wkendDate = '$wkendDate'";
          $evSQL = $evSQL ." order by e.eventNum";
          $evRes = mysql_query($evSQL) or die('get weekends failed: ' . mysql_error());
          echo "<table border='1'>";
          echo "<tr><th>Event Num</th><th>Func Num</th><th>Func Date</th><th>Grats</th><th>Employees</th><th>Emp Cnts</th><th>Emp Grats</th><th>Result</th></tr>";
          $cnt = 0;
          while ($evRec   = mysql_fetch_array($evRes, MYSQL_NUM)) {
          	 $eventNum  = $evRec[0];
          	 $funcNumWk = $evRec[1];
          	 $funcDate  = $evRec[2];
          	 echo "<tr>";
             $cnt++;
             echo "<td>$eventNum</td><td>$funcNumWk</td><td>$funcDate</td>";
          	 
             $fgSQL = "Select count(*) from funcGrats fg where fg.unitId= '$unitId' and fg.eventNum = $eventNum";
             $fgRes = mysql_query($fgSQL) or die('select wfunc emps dat failed: ' . mysql_error());
             $fgRec = mysql_fetch_array($fgRes, MYSQL_NUM);
             echo "<td>$fgRec[0]";
             if ($fgRec[0] > 0) {
                $fgSQL = "Delete from funcGrats where unitId='$unitId' and eventNum = $eventNum";
                $fgRes = mysql_query($fgSQL) or die(" Err:" . mysql_error());
             }
             echo "</td>";
             
             $feSQL = "Select count(*) from funcEmps fe where fe.unitId= '$unitId' and fe.eventNum = $eventNum";
             $feRes = mysql_query($feSQL) or die('select wfunc emps dat failed: ' . mysql_error());
             $feRec = mysql_fetch_array($feRes, MYSQL_NUM);
             echo "<td>$feRec[0]";
             if ($feRec[0] > 0) {
                $feSQL = "Delete from funcEmps where unitId='$unitId' and eventNum = $eventNum";
                $feRes = mysql_query($feSQL) or die(" Err:" . mysql_error());
             }
             echo "</td>";
             
             $ecSQL = "Select count(*) from funcEmpCnts ec where ec.unitId= '$unitId' and ec.eventNum = $eventNum";
             $ecRes = mysql_query($ecSQL) or die('select weekend func cnts failed: ' . mysql_error());
             $ecRec = mysql_fetch_array($ecRes, MYSQL_NUM);
             echo "<td>$ecRec[0]";
             if ($ecRec[0] > 0) {
                $ecSQL = "Delete from funcEmpCnts where unitId='$unitId' and eventNum = $eventNum";
                $ecRes = mysql_query($ecSQL) or die(" Err:" . mysql_error());
             }
             echo "</td>";
          
             $egSQL = "Select count(*) from funcEmpGrats eg where eg.unitId= '$unitId' and eg.eventNum = $eventNum";
             $egRes = mysql_query($egSQL) or die('select emp grats failed: ' . mysql_error());
             $egRec = mysql_fetch_array($egRes, MYSQL_NUM);
             echo "<td>$egRec[0]";
             if ($egRec[0] > 0) {
                $egSQL = "Delete from funcEmpGrats where unitId='$unitId' and eventNum = $eventNum";
                $egRes = mysql_query($egSQL) or die(" Err:" . mysql_error());
             }
             echo "</td>";

             echo "<td>Deleted</td>";
             echo "</tr>";
          }
          echo "</table>";
          $evSQL = "Delete from events where unitId= '$unitId' and wkendDate = '$wkendDate'";
          $evRes = mysql_query($evSQL) or die(" Events Del Err:" . mysql_error());
          
          $evSQL = "Delete from wkendCal where unitId= '$unitId' and wkendDate = '$wkendDate'";
          $evRes = mysql_query($evSQL) or die(" Week End Del Err:" . mysql_error());
          echo "</div>";
       } else {       
          echo "<span id='currWeekStat'>Status: There was no week found.</span></p>";
       }
    }
  }
?>