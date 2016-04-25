<?php

  session_start();
  include("db.php5");

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// This ID parameter is sent by our javascript client.
$unitId = $_GET['unitId'];
$funcGroup = $_GET['option'];

//                    0          1                          2                       3             4
$getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = $db->query($getSQL);
$recs = $result->fetch_row();

echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
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

$wkendDate = $recs[1];
$wkEndForm = $recs[2];
$unitName  = $recs[3];
$csvFormat = $recs[4];
$weekEnding = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
$today = date("F d, Y");

$eeList = "Select distinct f1.emplid, n1.name from events e1, funcEmps f1, employees n1, funcTypes ft";
$eeList = $eeList ." where e1.unitId = '$unitId' and e1.wkendDate = '$wkendDate' and f1.eventNum = e1.eventNum and f1.emplid = n1.emplid";
$eeList = $eeList ." and ft.funcGroup = '$funcGroup' and e1.funcType = ft.funcType";
$eeList = $eeList ." order by n1.name";
$eeRes  = $db->query($eeList);
while ($eeRec = $eeRes->fetch_row()) {

   $emplid = $eeRec[0];
   $name   = $eeRec[1];

   $grats       = array();
   $gratsDescrs = array();
   $gratCnt = 0;
   $gratHeads = "";
   //                      0             1             2             3         4
   $gratSQL = "Select g.gratType, gt.gratDescr, gt.dispOrder, gt.miscCode, count(*)";
   $gratSQL = $gratSQL . " from events e, funcEmpGrats g, gratTypes gt";
   $gratSQL = $gratSQL . " where e.unitId='$unitId' and e.wkendDate ='$wkendDate' and g.unitId = e.unitId and g.eventNum = e.eventNum";
   $gratSQL = $gratSQL . " and g.emplid = '$emplid' and gt.unitId = g.unitId and gt.gratType = g.gratType and g.gratAmt > 0";
   $gratSQL = $gratSQL . " group by g.gratType, gt.gratDescr, gt.dispOrder";
   $gratSQL = $gratSQL . " order by 5 desc, 3 asc";
   $gratRes = $db->query($gratSQL);
   while ($gratRec = $gratRes->fetch_row()) {
         $gratType  = $gratRec[0];
         $gratDescr = $gratRec[1];
         $miscCode  = $gratRec[3];
         $count     = $gratRec[4];
         if ($gratType != "X") {
            $gratCnt++;
            $grats[$gratCnt] = $gratType;
            $gratsDescrs[$gratCnt] = $gratDescr;
            $gratHeads = $gratHeads . "<th>$gratRec[1]</th>";
         }
   }

   //Get Employee's functions
   //                      0          1             2           3           4            5            6            7         8          9           10         11           12          13
   $totals   = array();
   $gratTots = array();
   $eventSum = "select e.funcDate, e.eventNum, e.funcGroup, e.funcNumWk, e.funcType, t.funcDescr, e.funcNumWk, f.hours, f.baseWage, f.setupAmt, f.clearAmt, f.extraAmt, f.totalPay, r.roomDescr";
   $eventSum = $eventSum . " from events e, funcTypes t, funcEmps f, rooms r, funcTypes ft";
   $eventSum = $eventSum . " where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and t.funcType = e.funcType and t.unitId = e.unitId and f.eventNum = e.eventNum";
   $eventSum = $eventSum . " and ft.funcGroup = '$funcGroup' and ft.funcType = e.funcType";
   $eventSum = $eventSum . " and f.emplid = '$emplid' and r.unitId = e.unitId and r.roomNum = e.roomNum order by e.funcDate, e.eventNum";

   $sqlRes  = $db->query($eventSum);
   $lineCnt = 0;
   $printCnt = 0;
   $pageCnt = 0;
   while ($detsRecs = $sqlRes->fetch_row()) {

     $eventNum =    $detsRecs[1];
     if ($lineCnt == 0) {
        $pageCnt = $pageCnt + 1;
        echo "<table class='fullReport'>";
        echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
        echo "<tr><td class='headLeft'><h4>Employee's Details</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
        echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
        echo "<tr><td class='headLeft'><h4>$name</h4></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
        echo "<tr><td></td></tr>";
        echo "</table>";

        echo "<table class='fullReport'>";
        echo "<tr><th>Func Date</th><th>Func Num</th><th>Room</th><th>Type</th><th>Hours</th><th>Base Wage</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Total Wages</th>";
        echo $gratHeads;
        echo "<th>Total Gratuities</th></tr>";
        $className = "shade";
       }

      echo "<tr class='$className'>";
      echo "<td class='char'>$detsRecs[0]</td>";
      echo "<td class='char'>$detsRecs[3]</td>";
      echo "<td class='char'>$detsRecs[13]</td>";
      echo "<td class='char'>$detsRecs[5]</td><td class='numfld'>";
      echo number_format($detsRecs[7],2) . "</td><td class='numfld'>";
      echo number_format($detsRecs[8],2) . "</td><td class='numfld'>";
      echo number_format($detsRecs[9],2) . "</td><td class='numfld'>";
      echo number_format($detsRecs[10],2) . "</td><td class='numfld'>";
      echo number_format($detsRecs[11],2) . "</td><td class='numfld'>";
      $totWage = $detsRecs[8] + $detsRecs[9] + $detsRecs[10] + $detsRecs[11];
      echo number_format($totWage,2) . "</td><td class='numfld'>";

      $totGratuity = 0;
      for ($i=1; $i<=$gratCnt; $i++) {
	   $gratType = $grats[$i];
	   $indGrats = "Select gratAmt from funcEmpGrats g where g.unitId = '$unitId' and g.eventNum = $eventNum and g.emplid = '$emplid' and g.gratType = '$gratType'";
	   $indRes = $db->query($indGrats);
	   $indRec = $indRes->fetch_row();
	   $gratAmt = $indRec[0];
	   $gratTots[$i] += $gratAmt;
	   $totGratuity  += $gratAmt;
           echo number_format($gratAmt,2) . "</td><td class='numfld'>";
      }

      echo number_format($totGratuity,2) . "</td>";
      echo "</tr>";
      $totals[7] += $detsRecs[7];
      $totals[8] += $detsRecs[8];
      $totals[9] += $detsRecs[9];
      $totals[10] += $detsRecs[10];
      $totals[11] += $detsRecs[11];
      $totals[12] += $totWage;
      $totals[13] += $totGratuity;

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
   }

   echo "<tr><td></td><td></td><td></td>";
   echo "<td>Totals</td><td class='numfld'>";
   echo number_format($totals[7],2) ."</td><td class='numfld'>";
   echo number_format($totals[8],2) ."</td><td class='numfld'>";
   echo number_format($totals[9],2) ."</td><td class='numfld'>";
   echo number_format($totals[10],2) ."</td><td class='numfld'>";
   echo number_format($totals[11],2) ."</td><td class='numfld'>";
   echo number_format($totals[12],2) ."</td><td class='numfld'>";
   for ($i=1; $i<=$gratCnt; $i++)
        echo number_format($gratTots[$i],2) ."</td><td class='numfld'>";
   echo number_format($totals[13],2) ."</td>";
   echo "</table><span class='page-break'></span>";

  $grands[7]  += $totals[7];
  $grands[8]  += $totals[8];
  $grands[9]  += $totals[9];
  $grands[10] += $totals[10];
  $grands[11] += $totals[11];
  $grands[12] += $totals[12];
  $grands[13] += $totals[13];
}

// echo "<table><tr class='$className'><td></td><td>Totals</td><td>";
// echo number_format($grands[7],2) ."</td><td>";
// echo number_format($grands[8],2) ."</td><td>";
// echo number_format($grands[9],2) ."</td><td>";
// echo number_format($grands[10],2) ."</td><td>";
// echo number_format($grands[11],2) ."</td><td>";
// echo number_format($grands[12],2) ."</td><td>";
// echo number_format($grands[13],2) ."</td><td>";
// echo number_format($grands[14],2) ."</td>";
// echo "</table>";
?>
