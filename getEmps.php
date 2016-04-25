<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $recList = "Select e.emplid, e.effdt, e.name, e.deptid, d.deptDescr, e.payGrp, e.locId, e.emplStatus, e.eeType, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.barTipPercent from employees e, employeeTypes t, depts d where e.unitId='$unitId' and t.unitId = e.unitId and t.eeType = e.eeType and d.deptId = e.deptId and d.unitId = e.unitId and e.effdt = (select max(effdt) from employees e2 where e2.emplid = e.emplid) order by e.emplStatus, e.name";
  $result = $db->query($recList);
  $rows = $result->num_rows;
  echo "<table id='empsList'>";
  $rowcl=1;
  echo "<thead><tr><td>Emplid</td>";
  echo "<td>Effdt</td>";
  echo "<td>Employee</td>";
  echo "<td>Dept</td>";
  echo "<td>Dept Name</td>";
  echo "<td>Pay Group</td>";
  echo "<td>Location</td>";
  echo "<td>Status</td>";
  echo "<td>Position</td>";
  echo "<td>Base</td>";
  echo "<td>Food%</td>";
  echo "<td>Bar%</td></tr></thead>";
  while ($recs = $result->fetch_row()) {
  	$json = '{"func":"formEmps","unitId":"'.$unitId.'","deptId":"'.$recs[0].'","effdt":"'.$recs[1].'"};';
        echo "<tr>";
        echo "<td>$recs[0]</td>";
        echo "<td>$recs[1]</td>";
        echo "<td class='row$rowcl' id='$recs[0]'  name='$recs[0]'>".'<a onclick="getRec(' . "'formEmps','unitId=" .$unitId. '&emplid=' .$recs[0]. "','todoform'); " .'" href="javascript:void(0)">' .$recs[2]. '</a></td>';
        echo "<td>$recs[3]</td>";
        echo "<td>$recs[4]</td>";
        echo "<td>$recs[5]</td>";
        echo "<td>$recs[6]</td>";
        echo "<td>$recs[7]</td>";
        echo "<td>$recs[9]</td>";
        echo "<td>$recs[10]</td>";
        echo "<td>$recs[11]</td>";
        echo "<td>$recs[12]</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>
