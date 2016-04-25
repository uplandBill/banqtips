<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
  $recList = "Select e.emplid, e.effdt, e.name, e.deptid, d.deptDescr, e.location, e.emplStatus, e.eeType, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.barTipPercent from employees e, employeeTypes t, depts d where e.unitId='$unitId' and t.eeType = e.eeType and d.deptId = e.deptId and e.effdt = (select max(effdt) from employees e2 where e2.emplid = e.emplid) order by e.emplid";
  $result = mysql_query($recList) or die('select events list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "<table id='empsList'>";
  $rowcl=1;
  echo "<tr><th>Emplid</th>";
  echo "<th>Effdt</th>";
  echo "<th>Employee</th>";
  echo "<th>Dept</th>";
  echo "<th>Dept Name</th>";
  echo "<th>Location</th>";
  echo "<th>Status</th>";
  echo "<th>Position</th>";
  echo "<th>Base</th>";
  echo "<th>Food%</th>";
  echo "<th>Bar%</th></tr>";
  while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
  	$json = '{"func":"formEmps","unitId":"'.$unitId.'","deptId":"'.$recs[0].'","effdt":"'.$recs[1].'"};';
        echo "<tr>";
        echo "<td>$recs[0]</td>";
        echo "<td>$recs[1]</td>";
        echo "<td class='row$rowcl' id='$recs[0]'  name='$recs[0]'>".'<a onclick="getRec(' . "'formEmps','?unitId=" .$unitId. '&emplid=' .$recs[0]. "','todoform')" .'" href="javascript:void(0)">' .$recs[2]. '</a></td>';
        echo "<td>$recs[3]</td>";
        echo "<td>$recs[4]</td>";
        echo "<td>$recs[5]</td>";
        echo "<td>$recs[6]</td>";
        echo "<td>$recs[8]</td>";
        echo "<td>$recs[9]</td>";
        echo "<td>$recs[10]</td>";
        echo "<td>$recs[11]</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>