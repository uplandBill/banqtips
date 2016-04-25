<?php
  session_start();
  include("db.php5");

// Not sure this is needed.  This was built to send dept data (formatted HTML) to the employee edit page when the dept was changed.
 
  $unitId = $_GET['unitId'];
  $deptId = $_GET['deptId'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
  
  $recList = "Select d.deptId, d.effdt, d.deptDescr, d.dud from depts d where d.unitId='$unitId' and d.deptId = '$deptId' and d.effdt = (select max(effdt) from depts sd where sd.unitId = d.unitId and sd.deptId = d.deptId)";
  $result = mysql_query($recList) or die('select dept list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  $recs = mysql_fetch_array($result, MYSQL_NUM);
  
  $json = '{"func":"formDepts.php5","keys":{"unitId":"'.$unitId.'","deptId":"'.$recs[0].'","effdt":"'.$recs[1].'"},"func2":"formDeptEvents"}';

  echo "<table id='tabdeptInfo'>";
  echo "<tr><td id='$recs[0]'  name='$recs[0]'>";
  echo "<a href='javascript:void(0)' id='deptEdit' json='" .$json. "'> $recs[0]</a></td>";
//  echo '<a onclick="getRec(' . "'formDepts','?unitId=" .$unitId. '&deptId=' .$recs[0]. '&effdt=' .$recs[1]. "','todoform')" .'" href="javascript:void(0)">' .$recs[0]. '</a></td>';
  echo "<td>$recs[2]</td></tr>";
  echo "<td>$recs[3]</td></tr>";
  echo "</table>";
?>