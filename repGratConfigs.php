<?php

  session_start();
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// This ID parameter is sent by our javascript client.
$unitId = $_GET['unitId'];

//                    0          1           2            3
$getSQL = "Select c.unitId, c.wkendDate, u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
$recs = mysql_fetch_array($result, MYSQL_NUM);

echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
echo "table {width: 1000px;}";
echo "table .subtable {width: 100%;}";
echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
echo " .shade {background-color: #C9DBDB;}";
echo " .noshade {background-color: #FFF;}";
// #CBCBCB;}";
// #C9DBDB;}";
echo ".unitHead {width: 33%; text-align: center;}";
echo ".headLeft {width: 33%; text-align: left;}";
echo ".headRight {width: 33%; text-align: right;}";
echo ".leftBuff {width: 300px;}";
echo ".rightBuff {width: 200px;}";
echo "h4, h5 {height: 20px;     margin: 0; padding: 0; border: 0;}";
echo" </style></head><body>";

echo "<h2>Gratuity Configs by Employee Type: $unitId</h2>";

$wkendDate = $recs[1];
$unitName  = $recs[2];
$csvFormat = $recs[3];
$Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
$today = date("F d, Y");

//                           0       1         2           3            4             5
$eeList = "Select distinct eeType, effdt, eeTypeDescr, eeBaseWage, coversAllowed, defHours from employeeTypes e";
$eeList = $eeList . " where unitId = '$unitId' and effdt = (select max(effdt) from employeeTypes e2 where e2.unitId = e.unitId and e2.eeType = e.eeType) order by eeType";
$eeRes  = mysql_query($eeList) or die('EE Type list data failed: ' . mysql_error());

echo "<table>";
echo "<tr><th>EE Type</th><th>Eff Dt</th><th></th><th>Grat1</th><th>Grat2</th><th>Grat3</th></tr>";
$className = "shade";

while ($eeRec = mysql_fetch_array($eeRes, MYSQL_NUM)) {

   $eeType        = $eeRec[0];
   $effdt         = $eeRec[1];
   $eeTypeDescr   = $eeRec[2];
   $eeBaseWage    = $eeRec[3];
   $coversAllowed = $eeRec[4];
   $defhours      = $eeRec[5];

   echo "<tr class='$className'>";
   echo "<td class='char'>$eeTypeDescr</td>";
   echo "<td class='char'>$effdt</td>";

  echo "<td><table class='subtable'>";   
  echo "<tr><td class='charx'>Grat Type:</td></tr>";
  echo "<tr><td class='charx'>Eff Date:</td></tr>";
  echo "<tr><td class='charx'>Group:</td></tr>";
  echo "<tr><td class='charx'>Cut Rate:</td></tr>";
  echo "<tr><td class='charx'>Net Acct:</td></tr>";
  echo "</table></td>";

   //                       0          1           2           3            4
   $totals = array();
   $gratSql = "select g.gratType, g.gratDescr, e.effdt, e.groupType, e.cutRate, e.netAcct from gratTypes g, empGroups e";
   $gratSql = $gratSql . " where g.unitId = '$unitId' and g.gratType <> 'X' and e.unitId = g.unitId and e.gratType = g.gratType and e.eeType = '$eeType'";
   $gratSql = $gratSql . " and e.effdt = (select max(effdt) from empGroups e2 where e2.unitid = e.unitId and e2.eeType = e.eeType) order by g.dispOrder";
   $sqlRes  = mysql_query($gratSql) or die('ee summ SQL data failed: ' . mysql_error());
   while ($detsRecs = mysql_fetch_array($sqlRes, MYSQL_NUM)) {

      echo "<td><table class='subtable'>";   
      echo "<tr><td class='char'>$detsRecs[1]</td></tr>";
      echo "<tr><td class='char'>$detsRecs[2]</td></tr>";
      echo "<tr><td class='char'>$detsRecs[3]</td></tr>";
      echo "<tr><td class='char'>$detsRecs[4]</td></tr>";
      echo "<tr><td class='char'>$detsRecs[5]</td></tr>";
      echo "</table></td>";
            
      $lineCnt++;
      if ($lineCnt / 2 == round($lineCnt /2, 0)) {
         $className = "shade";
      } else {
         $className = "";
      }

   }   

   echo "</tr>";
}
echo "</table>";
?>