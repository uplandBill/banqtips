<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
//                     0        1           2 
  $recList = "Select userid, userName, userStat from users order by userName";
  $result = mysql_query($recList) or die('select room list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "<table id='empsList'>";
  echo "<thead><th>Logon</th><th>User Name</th></thead>";
  $rowcl=1;
  $keys=array();
  while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
  	$json = '{"func":"formUserSec.php5","keys":{"userid":"' .$recs[0].'"},"func2":"formUserSecEvents"}';
        echo "<tr>";
        echo "<td class='row$rowcl' id='$recs[0]'  name='$recs[0]'>";
        echo "<a href='javascript:void(0)' json='" .$json. "'> $recs[0]</a>";
        echo "</td>";
        echo "<td>$recs[1]</td>";
        echo "</tr>";
  	$rowcl = 3 - $rowcl;
  }
  echo "</table>";
?>