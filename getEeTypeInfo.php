<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $eeType = $_GET['eeType'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
  
  //                     0        1           2              3              4              5           6             7             8           9         10              11
  $recList = "Select t.eeType, t.effdt, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.foodNet, t.foodGroup, t.barTipPercent, t.barNet, t.barGroup, t.coversAllowed, t.defHours from employeeTypes t where t.unitId='$unitId' and t.eeType = '$eeType' and t.effdt = (select max(effdt) from employeeTypes st where st.unitId = t.unitId and st.eeType = t.eeType)";
  $result = mysql_query($recList) or die('select ee type failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  $recs = mysql_fetch_array($result, MYSQL_NUM);

  echo "<table id='tabdEeTypeInfo'>";
  echo "<tr><td id='$recs[0]'  name='$recs[0]'>";
  echo '<a onclick="getRec(' . "'formEeTypes','?unitId=" .$unitId. '&eeType=' .$recs[0]. '&effdt=' .$recs[1]. "','todoform')" .'" href="javascript:void(0)">' .$recs[0]. '</a></td>';
  echo "<td>$recs[2]</td>";
  echo "<td>Base Wage:</td>";
  echo "<td>$recs[3]</td></tr>";
  echo "<tr><td>Food Rate/Group</td><td>$recs[4]</td><td>$recs[6]</td></tr>";
  echo "<tr><td>Bar Rate/Group</td><td>$recs[7]</td><td>$recs[9]</td></tr>";
  echo "</table>";
?>