<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
  $recList = "Select e.funcNumWk, e.eventNum, e.wkendDate, e.funcDate, e.roomNum, r.roomDescr, e.funcType, f.funcDescr from events e, wkendCal c, rooms r, funcTypes f where c.unitId='$unitId' and c.weekStatus = 'O' and e.unitId = c.unitId and e.wkendDate = c.wkendDate and r.unitId = e.unitId and r.roomNum = e.roomNum  and f.unitId = e.unitId and f.funcType = e.funcType order by funcNumWk";
  $result = mysql_query($recList) or die('select events list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "<table id='eventList'>";
  $rowcl=1;
  while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
  	$json = '{"func":"formDept","unitId":"'.$unitId.'","deptId":"'.$recs[0].'","effdt":"'.$recs[1].'"};';
        echo "<tr><td class='row$rowcl' id='$recs[0]'  name='$recs[0]'>";
        echo '<a onclick="getRec(' . "'formEvents','?unitId=" .$unitId. '&eventNum=' .$recs[0]. "','todoform')" .'" href="javascript:void(0)">' .$recs[0]. '</a></td>';
        echo "<td>$recs[2]</td>";
        echo "<td>$recs[3]</td>";
        echo "<td>$recs[5]</td>";
        echo "<td>$recs[7]</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>