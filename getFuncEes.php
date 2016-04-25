<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $eelist = "Select name, eeTypeDescr from employees e, employeeTypes t where e.unitId='337W0' and t.unitId = e.unitId and t.eeType = e.eeType order by eeTypeDescr, name";
  $result = $db->query($eelist);
  $rows = $result->num_rows;
  echo "<table>";
  $rowcl=1;
  while ($ee = $result->fetch_row()) {
  	if ($ee[1] == "Captain")
  	   echo "<tr><td class='row$rowcl multiVal picked'>$ee[0]: $ee[1]</td></tr>";
  	else
  	   echo "<tr><td class='row$rowcl multiVal'>$ee[0]: $ee[1]</td></tr>";
  	$rowcl = 3 - $rowcl;
  }
 
?>
