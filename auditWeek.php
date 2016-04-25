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
$recs   = mysql_fetch_array($result, MYSQL_NUM);
$wkendDate = $recs[1];
$wkEndForm = $recs[2];
$unitName  = $recs[3];
$csvFormat = $recs[4];

$Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
$today = date("F d, Y");
$pageCnt = 0;

echo "<html><head><style>body {font: 16px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
echo "table {width: 1300px;}";
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

include("comGetGrats.php");

echo "<div class='fullReport'>";

$chkCnt = 0;
//                      0          1             2           3           4            5            6            7            8               9           10           11          12         13          14        15
$totals = array();
$totals2 = array();
$eventSum = "select e.eventNum, e.funcNumWk, e.funcDate, e.funcGroup, e.roomNum, r.roomDescr, e.funcType, f.funcDescr, e.funcNumWk"; //, e.foodCheck, e.barCheck, e.foodBill, e.foodGrat, e.barBill, e.barGrat, e.wineGrat";
$eventSum = $eventSum ." from events e, rooms r, funcTypes f ";
$eventSum = $eventSum ." where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and r.roomNum = e.roomNum and r.unitId = e.unitId and f.funcType = e.funcType and f.unitId = e.unitId order by e.funcNumWk";
$sqlRes  = mysql_query($eventSum) or die('event summ SQL data failed: ' . mysql_error());
$lineCnt = 0;
$printCnt = 0;
$pageBreak = "";
   while ($detsRecs = mysql_fetch_array($sqlRes, MYSQL_NUM)) {
      if ($lineCnt == 0) {
         $pageCnt++;
         echo $pageBreak;
         echo "<table class='fullReport'>";
         echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
         echo "<tr><td class='headLeft'><h4>Audit Report</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
         echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
         echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
         echo "</table>";
         
         echo "<table class='fullReport'>";
         echo "<tr><th>Func Num</th><th>Func Date</th><th>Group</th><th>Room</th><th>Func Type</th>$repHeads<th>Chk</th></tr>";
      }

      $lineCnt++;
      $lineCnt++;
      $printCnt++;
      if ($printCnt / 2 == round($printCnt / 2, 0)) {
         $className = "shade";
      } else {
         $className = "";
      }

//      $detsRecs[12] = $detsRecs[12] + $detsRecs[15];

      echo "<tr class='$className'>";
      echo "<td class='char'>$detsRecs[1]</td>";
      echo "<td class='char'>$detsRecs[2]</td>";
      echo "<td class='char'>$detsRecs[3]</td>";
      echo "<td class='char'>$detsRecs[5]</td>";
      echo "<td class='char'>$detsRecs[7]</td>";
//      $totals[11] += $detsRecs[11];
//      $totals[12] += $detsRecs[12];
//      $totals[13] += $detsRecs[13];
//      $totals[14] += $detsRecs[14];

      $eventNum = $detsRecs[0];

//                          0             1              2               3                4                 5               6 
      $detsSQL = "Select count(*), sum(e.baseWage), sum(e.hours), sum(e.setupAmt), sum(e.clearAmt), sum(e.extraAmt), sum(e.totalPay)";
      $detsSQL = $detsSQL ." from funcEmps e, events v where v.unitId='$unitId' and v.eventNum = $eventNum and e.unitId = v.unitId and e.eventNum = v.eventNum group by v.eventNum";
      $detsResult = mysql_query($detsSQL) or die('select emp events data failed: ' . mysql_error());
      $detsRecs2  = mysql_fetch_array($detsResult, MYSQL_NUM);

      $diff = "&nbsp";
      $eeLine = "<tr class='$className'><td></td><td></td><td></td><td></td><td class='char'>Employees: $detsRecs2[0] </td>";

      $gratsLine=array();
      for ($i=1; $i<=$gratCnt; $i++) {
         $gratType = $grats[$i];
         $gratSQL = "Select g.gratAmt from funcGrats g";
         $gratSQL = $gratSQL ." where g.unitId='$unitId' and g.eventNum = $eventNum and g.gratType = '$gratType'";
         $gratRes = mysql_query($gratSQL) or die('select grats data failed: ' . mysql_error());
         $gratRec = mysql_fetch_array($gratRes, MYSQL_NUM);
         $gratAmt = $gratRec[0];
         $totals[$i] += $gratAmt;
         echo "<td class='numfld'>". number_format($gratAmt,2) ."</td>";

         $gratType = $grats[$i];
         $gratsWeek = "Select sum(e.gratAmt) from funcEmpGrats e, events f where f.unitId='$unitId' and f.eventNum = $eventNum and e.unitId = f.unitId and e.eventNum = f.eventNum and e.gratType = '$gratType'";
         $gratsRes = mysql_query($gratsWeek) or die('select emp grats data failed: ' . mysql_error());
         $gratsRec = mysql_fetch_array($gratsRes, MYSQL_NUM);
         $gratAmt2=$gratsRec[0];
         $totals2[$i] += $gratAmt2;
         $eeLine = $eeLine ."<td class='numfld'>". number_format($gratAmt2,2) ."</td>";
         
         if ($gratAmt <> $gratAmt2)
            $diff = "***";
      }

      echo "<td>&nbsp;</td>";
      $eeLine = $eeLine ."<td class='numfld'>". $diff ."</td></tr>";

      if ($diff == "***") {
         $chkCnt++;
      }

      echo "</tr>";
      
      echo $eeLine;
        
      if ($lineCnt == 30) {
         $pageBreak = "</table><span class='page-break'></span>";
         $lineCnt = 0;
      }
  }
  
if ($printCnt / 2 == round($printCnt / 2, 0)) {
   $className = "";
} else {
   $className = "shade";
}

echo "<tr class='$className'><td></td><td></td><td></td><td></td>";
echo "<td>Totals</td>";
for ($i=1; $i<=$gratCnt; $i++) {
   echo "<td class='numfld'>". number_format($totals[$i],2) ."</td>";
   }
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "<tr class='$className'><td></td><td></td><td></td><td></td>";
echo "<td></td>";
for ($i=1; $i<=$gratCnt; $i++) {
   echo "<td class='numfld'>". number_format($totals2[$i],2) ."</td>";
   }
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "</table><br/><br/>";

echo "Number of functions not in balance: $chkCnt <br/><br/>";
echo "</div>";
// ---------------------------------------------------------------------------------------------------------------------------------

?>