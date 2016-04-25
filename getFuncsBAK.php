<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $currWk = "Select wkendDate from wkendCal where unitId = '$unitId' and weekStatus = 'O'";
  $result = mysql_query($currWk) or die('select curr week list failed: ' . mysql_error());
  $week = mysql_fetch_array($result, MYSQL_NUM);
  $wkendDate = $week[0];
  
  $recList = "Select f.unitId, f.eventNum, f.funcDate, f.roomNum, r.roomDescr, f.funcType, t.funcDescr from events f, rooms r, funcTypes t where f.unitId='$unitId' and f.wkendDate = '$wkendDate' and r.unitId = f.unitId and r.roomNum = f.roomNum and t.unitId = f.unitId and t.funcType = f.funcType order by f.funcNumWk";
  $result = mysql_query($recList) or die('select events list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "<table id='eventsList'>";
  $rowcl=1;
  echo "<tr><th>Event Num</th>";
  echo "<th>Func Date</th>";
  echo "<th>Room Name</th>";
  echo "<th>Function Type</th>";
  echo "</tr>";
  while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
  	$json = '{"func":"formFunc","unitId":"'.$unitId.'","eventNum":"'.$recs[1].'"'.'};';
        echo "<tr>";
        echo "<td>$recs[0]</td>";
        echo "<td class='row$rowcl' id='$recs[1]'  name='$recs[1]'>".'<a onclick="loadFunc(' ."'$unitId'," .$recs[1]. ")" .'" href="javascript:void(0)">' .$recs[1]. '</a></td>';
        echo "<td>$recs[4]</td>";
        echo "<td>$recs[6]</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>