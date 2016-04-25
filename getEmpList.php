<?php
  session_start();
  include("db.php5");

  // Prevent caching.
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
  echo" </style>";
  echo '<script type="text/javascript" src="scripts/sortable.js"></script>';
  echo '<script  type="text/javascript">';
  echo "function set_sort() {var t = new SortableTable(document.getElementById('empsList'), 100);};";
  echo "</script>";
  echo "</head><body onload='set_sort()'>";

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
  $recList = "Select e.emplid, e.effdt, e.name, e.deptid, d.deptDescr, e.payGrp, e.locId, e.emplStatus, e.eeType, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.barTipPercent from employees e, employeeTypes t, depts d where e.unitId='$unitId' and t.unitId = e.unitId and t.eeType = e.eeType and d.deptId = e.deptId and d.unitId = e.unitId and e.effdt = (select max(effdt) from employees e2 where e2.emplid = e.emplid) order by e.emplStatus, e.name";
  $result = mysql_query($recList) or die('select events list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "<table id='empsList'>";
  $rowcl=1;
  echo "<thead><tr><td class='char'>Emplid</td>";
  echo "<td class='char'>Effdt</td>";
  echo "<td class='char'>Employee</td>";
  echo "<td class='char'>Dept</td>";
  echo "<td class='char'>Dept Name</td>";
  echo "<td class='char'>Pay Group</td>";
  echo "<td class='char'>Location</td>";
  echo "<td class='char'>Status</td>";
  echo "<td class='char'>Position</td>";
  echo "<td class='char'>Base</td>";
//  echo "<td>Food%</td>";
//  echo "<td>Bar%</td>";
  echo "</tr></thead>";
  while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
  	$json = '{"func":"formEmps","unitId":"'.$unitId.'","deptId":"'.$recs[0].'","effdt":"'.$recs[1].'"};';
        echo "<tr>";
        echo "<td class='char'>$recs[0]</td>";
        echo "<td class='char'>$recs[1]</td>";
        echo "<td class='char'>$recs[2]</td>";
        echo "<td class='char'>$recs[3]</td>";
        echo "<td class='char'>$recs[4]</td>";
        echo "<td class='char'>$recs[5]</td>";
        echo "<td class='char'>$recs[6]</td>";
        echo "<td class='char'>$recs[7]</td>";
        echo "<td class='char'>$recs[9]</td>";
        echo "<td class='char'>$recs[10]</td>";
//        echo "<td>$recs[11]</td>";
//        echo "<td>$recs[12]</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>