<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
//                       0        1         2            3        4
  $recList = "Select d.deptId, d.effdt, d.effStatus, t.descr, d.deptDescr, d.dud from depts d, translates t where d.unitId='$unitId' and d.effdt = (select max(effdt) from depts sd where sd.unitId = d.unitId and sd.deptId = d.deptId) and t.unitId = d.unitId and t.fieldName = 'effStatus' and t.fieldvalue = d.effStatus and t.effdt = (select max(effdt) from translates t2 where t2.unitId = t.unitId and t2.fieldName = t.fieldName and t2.fieldValue = t.FieldValue) order by deptDescr, deptId";
  $result = mysql_query($recList) or die('select dept list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "<table id='empsList'>";
  echo "<thead><th>Dept Id</th><th>Eff Date</th><th>Status</th><th>Dept Name</th><th>DUD</th></thead>";
  $rowcl=1;
  $keys=array();
  while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
  	$json = '{"func":"formDepts.php","keys":{"unitId":"'.$unitId.'","deptId":"'.$recs[0].'","effdt":"'.$recs[1].'"},"func2":"formDeptEvents"}';
        echo "<tr>";
        echo "<td class='row$rowcl' id='$recs[0]'  name='$recs[0]'>";
        echo "<a href='javascript:void(0)' json='" .$json. "'> $recs[0]</a>";
//        echo "<a href='javascript:void(0)' onclick='doform();'  json='" .$json. "'> date</a>";
//        echo '<a onclick="getRec(' . "'formDepts','?unitId=" .$unitId. '&deptId=' .$recs[0]. '&effdt=' .$recs[1]. "','todoform')" .'" href="javascript:void(0)" json="' .'{}'. '">' .$recs[0]. '</a></td>';
        echo "<td>$recs[1]</td>";
        echo "<td>$recs[3]</td>";
        echo "<td>$recs[4]</td>";
        echo "<td>$recs[5]</td>";
//        echo "<td>$json</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>