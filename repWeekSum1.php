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

//                      0         1                        2                        3            4
$getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
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
echo ".leftBuff {width: 300px;}";
echo ".rightBuff {width: 200px;}";
echo "h4, h5 {height: 20px;	margin: 0; padding: 0; border: 0;}";
echo" </style></head><body>";

$wkendDate = $recs[1];
$wkEndForm = $recs[2];
$unitName  = $recs[3];
$csvFormat = $recs[4];
$Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
$today = date("F d, Y");
$pageCnt = 0;

//                      0          1             2           3           4            5            6            7            8          9           10           11        12         13           14           15
$totals = array();
$eventSum = "select e.eventNum, e.funcNumWk, e.funcDate, e.funcGroup, e.roomNum, r.roomDescr, e.funcType, f.funcDescr, e.funcNumWk, e.foodCheck, e.barCheck, e.foodBill, e.foodGrat, e.barBill, e.barGrat, e.wineGrat from events e, rooms r, funcTypes f where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and r.roomNum = e.roomNum and r.unitId = e.unitId and f.funcType = e.funcType and f.unitId = e.unitId order by e.funcNumWk";
$sqlRes  = mysql_query($eventSum) or die('event summ SQL data failed: ' . mysql_error());
   $lineCnt = 0;
   $printCnt = 0;
   while ($detsRecs = mysql_fetch_array($sqlRes, MYSQL_NUM)) {

        if ($lineCnt == 0) {
           $pageCnt++;
           echo "<table>";
           echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
           echo "<tr><td class='headLeft'><h4>Functions Summary</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
           echo "</table>";
           
           echo "<table>";
           echo "<tr><th>Func Num</th><th>Func Date</th><th>Group</th><th>Room</th><th>Func Type</th><th>Food Bill</th><th>Food Grat</th><th>Bar Bill</th><th>Bar Grat</th></tr>";
          }

      $lineCnt++;
      if ($lineCnt / 2 == round($lineCnt /2, 0)) {
         $className = "shade";
      } else {
         $className = "";
      }

        $detsRecs[12] = $detsRecs[12] + $detsRecs[15];

	echo "<tr class='$className'>";
	echo "<td class='char'>$detsRecs[1]</td>";
	echo "<td class='char'>$detsRecs[2]</td>";
	echo "<td class='char'>$detsRecs[3]</td>";
	echo "<td class='char'>$detsRecs[5]</td>";
	echo "<td class='char'>$detsRecs[7]</td><td>";
	echo number_format($detsRecs[11],2) . "</td><td>";
	echo number_format($detsRecs[12],2) . "</td><td>";
	echo number_format($detsRecs[13],2) . "</td><td>";
	echo number_format($detsRecs[14],2) . "</td>";
	echo "</tr>";
	$totals[11] += $detsRecs[11];
	$totals[12] += $detsRecs[12];
	$totals[13] += $detsRecs[13];
	$totals[14] += $detsRecs[14];
	
	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }
}
	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }
echo "<tr><td></td><td></td><td></td><td></td>";
echo "<td>Totals</td><td>";
echo number_format($totals[11],2) ."</td><td>";
echo number_format($totals[12],2) ."</td><td>";
echo number_format($totals[13],2) ."</td><td>";
echo number_format($totals[14],2) ."</td></tr>";
echo "</table><br/><br/>";

// ---------------------------------------------------------------------------------------------------------------------------------

$totals = array();
$pageCnt = 0;
//                      0             1              2                3               4                       5            6            7            8          9           10           11        12         13       
$eventSum = "select e.funcDate, f.funcDescr, count(*), sum(e.foodBill), sum(e.foodGrat + e.wineGrat), sum(e.barBill), sum(e.barGrat) from events e, rooms r, funcTypes f where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and r.roomNum = e.roomNum and r.unitId = e.unitId and f.funcType = e.funcType and f.unitId = e.unitId group by e.funcDate, f.funcDescr order by e.funcDate";
$sqlRes  = mysql_query($eventSum) or die('event summ SQL data failed: ' . mysql_error());
   $lineCnt = 0;
   $printCnt = 0;
   echo "</table><span class='page-break'></span>";
  while ($detsRecs = mysql_fetch_array($sqlRes, MYSQL_NUM)) {

        if ($lineCnt == 0) {
           $pageCnt++;
           echo "<table>";
           echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
           echo "<tr><td class='headLeft'><h4>Daily Summary by Function</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
           echo "</table>";
           
           echo "<table>";
           echo "<tr><th>Func Date</th><th>FuncType(Count)</th><th>Food Bill</th><th>Food Grat</th><th>Bar Bill</th><th>Bar Grat</th></tr>";
          }

      $lineCnt++;
      if ($lineCnt / 2 == round($lineCnt /2, 0)) {
       $className = "shade";
      } else {
       $className = "";
      }

	echo "<tr class='$className'>";
	echo "<td class='char'>$detsRecs[0]</td>";
	echo "<td class='char'>$detsRecs[1] ($detsRecs[2])</td><td>";
	echo number_format($detsRecs[3],2) ."</td><td>";
	echo number_format($detsRecs[4],2) ."</td><td>";
	echo number_format($detsRecs[5],2) ."</td><td>";
	echo number_format($detsRecs[6],2) ."</td>";
	echo "</tr>";
	$totals[3] += $detsRecs[3];
	$totals[4] += $detsRecs[4];
	$totals[5] += $detsRecs[5];
	$totals[6] += $detsRecs[6];

	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }

}
	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }

echo "<tr><td></td><td>Totals</td><td>";
echo number_format($totals[3],2) ."</td><td>";
echo number_format($totals[4],2) ."</td><td>";
echo number_format($totals[5],2) ."</td><td>";
echo number_format($totals[6],2) ."</td></tr>";
echo "</table><br/><br/>";


// ---------------------------------------------------------------------------------------------------------------------------------


$totals = array();
$pageCnt = 0;
//                      0             1              2                3               4                           5            6            7            8          9           10           11        12         13       
$eventSum = "select e.funcDate,  count(*), sum(e.foodBill), sum(e.barBill), sum(e.foodGrat + e.wineGrat), sum(e.barGrat) from events e, rooms r, funcTypes f where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and r.roomNum = e.roomNum and r.unitId = e.unitId and f.funcType = e.funcType and f.unitId = e.unitId group by e.funcDate order by e.funcDate";
$sqlRes  = mysql_query($eventSum) or die('event summ SQL data failed: ' . mysql_error());
   $lineCnt = 0;
   $printCnt = 0;
   echo "</table><span class='page-break'></span>";
  while ($detsRecs = mysql_fetch_array($sqlRes, MYSQL_NUM)) {

        if ($lineCnt == 0) {
           $pageCnt++;
           echo "<table>";
           echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
           echo "<tr><td class='headLeft'><h4>Daily Summary</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
           echo "</table>";
           
           echo "<table>";
           echo "<tr><th>Func Date(Count)</th><th>Food Bill</th><th>Bar Bill</th><th>Food Grat</th><th>Bar Grat</th></tr>";
          }

      $lineCnt++;
      if ($lineCnt / 2 == round($lineCnt /2, 0)) {
       $className = "shade";
      } else {
       $className = "";
      }

	echo "<tr class='$className'>";
	echo "<td class='char'>$detsRecs[0] ($detsRecs[1])</td><td>";
	echo number_format($detsRecs[2],2) ."</td><td>";
	echo number_format($detsRecs[3],2) ."</td><td>";
	echo number_format($detsRecs[4],2) ."</td><td>";
	echo number_format($detsRecs[5],2) ."</td>";
	echo "</tr>";
	$totals[2] += $detsRecs[2];
	$totals[3] += $detsRecs[3];
	$totals[4] += $detsRecs[4];
	$totals[5] += $detsRecs[5];

	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }

}
	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }

echo "<tr><td>Totals</td><td>";
echo number_format($totals[2],2) ."</td><td>";
echo number_format($totals[3],2) ."</td><td>";
echo number_format($totals[4],2) ."</td><td>";
echo number_format($totals[5],2) ."</td></tr>";
echo "</table><br/><br/>";


// ---------------------------------------------------------------------------------------------------------------------------------

$totals = array();
$pageCnt = 0;
//                      0         1           2                3               4               5                6                7               8              9        10
   $detsSQL = "Select n.emplid, n.name, count(*), sum(e.baseWage), sum(e.hours), sum(e.setupAmt), sum(e.clearAmt), sum(e.extraAmt), sum(e.foodCut), sum(e.barCut), sum(e.totalPay) from funcEmps e, employees n, events v where v.unitId='$unitId' and v.wkendDate = '$wkendDate' and e.unitId = v.unitId and e.eventNum = v.eventNum and n.unitId = v.unitId and n.emplid = e.emplid group by n.emplid, n.name order by 11";
   $detsResult = mysql_query($detsSQL) or die('select emp events data failed: ' . mysql_error());
   $rows = mysql_num_rows($detsResult);
   
   $lineCnt = 0;
   $printCnt = 0;
   
   echo "</table><span class='page-break'></span>";
   while ($detsRecs = mysql_fetch_array($detsResult, MYSQL_NUM)) {
   
        if ($lineCnt == 0) {
           $pageCnt++;
           echo "<table>";
           echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
           echo "<tr><td class='headLeft'><h4>Employee Summary</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
           echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
           echo "</table>";
           
           echo "<table>";
           echo "<tr><th>Emplid</th><th>Employee(Functions)</th><th>Base Wage</th><th>Hours</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Food Grat</th><th>Bar Grat</th><th>Total Pay</th></tr>";
          }

      $lineCnt++;
      if ($lineCnt / 2 == round($lineCnt /2, 0)) {
       $className = "shade";
      } else {
       $className = "";
      }
   
      echo "<tr class='$className'><td class='char'>$detsRecs[0]</td>";
      echo "<td class='char'>$detsRecs[1] ($detsRecs[2])</td><td>";
      echo number_format($detsRecs[3],2) . "</td><td>";
      echo number_format($detsRecs[4],2) . "</td><td>";
      echo number_format($detsRecs[5],2) . "</td><td>";
      echo number_format($detsRecs[6],2) . "</td><td>";
      echo number_format($detsRecs[7],2) . "</td><td>";
      echo number_format($detsRecs[8],2) . "</td><td>";
      echo number_format($detsRecs[9],2) . "</td><td>";
      echo number_format($detsRecs[10],2) . "</td></tr>";
   
      $printCnt++;
      $totals[3] += $detsRecs[3];
      $totals[4] += $detsRecs[4];
      $totals[5] += $detsRecs[5];
      $totals[6] += $detsRecs[6];
      $totals[7] += $detsRecs[7];
      $totals[8] += $detsRecs[8];
      $totals[9] += $detsRecs[9];
      $totals[10] += $detsRecs[10];
      
	if ($lineCnt == 30) {
           echo "</table><span class='page-break'></span>";
           $lineCnt = 0;
        }

   }
        if ($lineCnt == 0) {
           echo "<table>";
           echo "<tr><td colspan=3> $unitName </td></tr>";
           echo "<tr></tr>";
           echo "</table>";
           
           echo "<table>";
           echo "<tr><th>Emplid</th><th>Employee(Functions)</th><th>Base Wage</th><th>Hours</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Food Grat</th><th>Bar Grat</th><th>Total Pay</th></tr>";
          }

   echo "<tr class='$className'><td></td><td>Totals</td><td>";
   echo number_format($totals[3],2) ."</td><td>";
   echo number_format($totals[4],2) ."</td><td>";
   echo number_format($totals[5],2) ."</td><td>";
   echo number_format($totals[6],2) ."</td><td>";
   echo number_format($totals[7],2) ."</td><td>";
   echo number_format($totals[8],2) ."</td><td>";
   echo number_format($totals[9],2) ."</td><td>";
   echo number_format($totals[10],2) ."</td>";
   
   echo "</table>";
?>