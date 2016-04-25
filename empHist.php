<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];
  $emplid = $_GET['emplid'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

    echo "Complete History";
    
    //                    0        1       2         3         4           5           6          7         8              9             10              11                12           13
     $query = "Select e.emplid, e.effdt, e.name, e.deptid, d.deptDescr, e.locId, e.emplStatus, e.eeType, e.emplClass, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.barTipPercent, e.payGrp from employees e, employeeTypes t, depts d where e.unitId='$unitId' and e.emplid = '$emplid' and t.eeType = e.eeType and d.deptId = e.deptId order by e.effdt desc";
     $result = mysql_query($query) or die('Get Employee History failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     
     echo "<table><tr class='empHistHead'><th>Effdt</th><th>Status</th><th>Dept</th><th>Pay Group</th></tr>";
     while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
     	 echo "<tr class='empHistLine'>";
     	 echo "<td>$line[1]</td>";
     	 echo "<td>$line[6]</td>";
     	 echo "<td>$line[4]</td>";
     	 echo "<td>$line[13]</td>";
     	 echo "</tr>";
     }

?>