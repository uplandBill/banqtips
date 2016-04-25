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
echo "table {width: 1300px;}";
echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
echo " .shade {background-color: #C9DBDB;}";
// #CBCBCB;}";
// #C9DBDB;}";
echo ".unitHead {width: 33%; text-align: center;}";
echo ".headLeft {width: 33%; text-align: left;}";
echo ".headRight {width: 33%; text-align: right;}";
//echo "body {width: 1100px;}";
echo" </style></head>";

echo "<body>";

$wkendDate = $recs[1];
$unitName  = $recs[2];
$csvFormat = $recs[3];
$Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
$today = date("F d, Y");

$theList = "Select d.deptId, d.effdt, d.deptDescr, d.dud from depts d where d.unitId = '$unitId' order by d.deptDescr";
$listRes  = mysql_query($theList) or die('Dept list data failed: ' . mysql_error());
   $page = 0;
while ($listRec = mysql_fetch_array($listRes, MYSQL_NUM)) {

   $deptId    = $listRec[0];
   $effdt     = $listRec[1];
   $deptDescr = $listRec[2];
   $dud       = $listRec[3];

   //                    0        1        2       3          4           5            6            7           8         9           10         11           12         13        14
   $totals = array();
   $eeList = "select e.emplid, e.effdt, e.name, e.locId, e.emplStatus, e.eeType, t.eeTypeDescr, e.emplClass, e.payGrp, e.jobCode from employees e, employeeTypes t where e.unitId = '$unitId' and e.deptId = '$deptId' and t.eeType = e.eeType and t.unitId = e.unitId order by e.emplClass, e.name";
   $sqlRes  = mysql_query($eeList) or die('ee list SQL data failed: ' . mysql_error());
   $lineCnt = 0;
   $printCnt = 0;
   while ($detsRecs = mysql_fetch_array($sqlRes, MYSQL_NUM)) {
   
     if ($lineCnt == 0) {
        $page = $page + 1;
        echo "<table>";
        echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
        echo "<tr><td class='headLeft'><h4>Employees By Department</h4></td><td></td><td class='headRight'><h4>$today</h4></td></tr>";
        echo "<tr><td class='char'><h3>$deptId: $deptDescr</h3></td><td></td><td><h3>Page: $page</h3></td></tr>";
        echo "<tr></tr>";
        echo "</table>";
        
        echo "<table>";
        echo "<tr><th>Emplid</th><th>Name</th><th>Status</th><th>Role</th><th>Class</th><th>Pay Group</th><th>Job Code</th><th></th><th></th><th></th></tr>";
        $className = "shade";
       }
   
      echo "<tr class='$className'>";
      echo "<td class='char'>$detsRecs[0]</td>";
      echo "<td class='char'>$detsRecs[2]</td>";
      echo "<td class='char'>$detsRecs[4]</td>";
      echo "<td class='char'>$detsRecs[6]</td>";
      echo "<td class='char'>$detsRecs[7]</td>";
      echo "<td class='char'>$detsRecs[8]</td>";
      echo "<td class='char'>$detsRecs[9]</td>";
      echo "</tr>";
      $totals[7] += $detsRecs[7];
      
      $lineCnt++;
      if ($lineCnt / 2 == round($lineCnt /2, 0)) {
         $className = "shade";
      } else {
         $className = "";
      }

      if ($lineCnt == 30) {
         echo "</table><span class='page-break'></span>";
         $lineCnt = 0;
      }
      $printCnt++;
   }   

   if ($lineCnt > 0) {
      echo "<tr>";
      echo "<td></td><td class='char'>Total Head Count: ";
      echo number_format($printCnt,0) ."</td><td>";
      echo "</table><span class='page-break'></span>";
   }

  $grands[7]  += $totals[7];
}

 echo "<table><tr class='$className'><td></td><td>Totals</td><td>";
 echo number_format($grands[7],2) ."</td><td>";
 echo "</table>";
?>