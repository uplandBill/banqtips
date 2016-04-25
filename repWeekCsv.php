<?php

//  Genereic json Get

  session_start();
  include("db.php5");


// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// This ID parameter is sent by our javascript client.
$unitId    = $_GET['unitId'];
$funcGroup = $_GET['option'];

//                    0          1                        2                           3            4
$getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y') , u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = $db->query($getSQL);
$recs = $result->fetch_row();

echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
echo "table {width: 1300px;}";
echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
echo " .shade {background-color: #C9DBDB;}";
// #CBCBCB;}";
// #C9DBDB;}";
echo ".unitHead {width: 33%; text-align: center;}";
echo ".headLeft {width: 33%; text-align: left;}";
echo ".headRight {width: 33%; text-align: right;}";
echo" </style></head><body>";

$gratTypes = array();
$miscCodes = array();
$miscTots = array();    //     0         1
$miscSql = "select distinct gratType, miscCode from gratTypes where unitId = '$unitId'";
$miscRes = $db->query($miscSql);
$miscCnt = 0;
while ($gratRec = $miscRes->fetch_row()) {
    $miscCnt++;
    $gratType = $gratRec[0];
    $miscCode = $gratRec[1];
    $gratTypes[$miscCnt] = $gratType;
    $miscCodes[$miscCnt] = $miscCode;
    $miscTots[$miscCode] = 0;
}

$wkendDate = $recs[1];
$wkEndForm = $recs[2];
$unitName  = $recs[3];
$csvFormat = $recs[4];
$Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
$today = date("F d, Y");

$stamp=getdate();
$timeStamp = sprintf('%02d',$stamp[hours]) . sprintf('%02d',$stamp[minutes]) . sprintf('%02d',$stamp[seconds]);
$fileName = "BQT_$unitId.$Weekending.$stamp[hours]$stamp[minutes]$stamp[seconds].csv";
$fileName = "BQT_$unitId.$Weekending.$timeStamp.txt";
$fileName = $unitId ."_BQT.txt";

$tab=chr(9);

$myFile = "./files/$fileName";
$fh = fopen($myFile, 'w') or die("can't open file: " .$myFile ." for user: " . get_current_user());

$repHeads = "<tr><th>Emplid</th><th class='repsNameCell'>Employee</th><th>Base Wage</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Total Wages</th>";

$grats = array();
$gratTots = array();
$gratCnt = 0;
//                      0             1             2             3         4
$gratSQL = "Select g.gratType, gt.gratDescr, gt.dispOrder, gt.miscCode, count(*)";
$gratSQL = $gratSQL . " from events e, funcGrats g, gratTypes gt, funcTypes ft, funcGroups fg ";
$gratSQL = $gratSQL . " where e.unitId='$unitId' and e.wkendDate ='$wkendDate' and g.unitId = e.unitId and g.eventNum = e.eventNum";
$gratSQL = $gratSQL . " and gt.unitId = g.unitId and gt.gratType = g.gratType"; 
$gratSQL = $gratSQL . " and ft.unitId = g.unitId and ft.funcType = e.funcType and ft.funcGroup = '$funcGroup'"; 
$gratSQL = $gratSQL . " and fg.unitId = g.unitId and fg.funcGroup = ft.funcGroup"; 
$gratSQL = $gratSQL . " group by g.gratType, gt.gratDescr, gt.dispOrder order by 5 desc, 3 asc";
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
         $repHeads = $repHeads . "<th>" . $gratDescr . "</th>";
      }
}
$repHeads = $repHeads . "<th>Total Pay</th></tr>";

//                     0        1       2       3          4            5               6              7                8               9             10              11
$detsSQL = "Select e.emplid, n.name, d.dud, n.jobcode, n.locid, sum(e.baseWage), sum(e.hours), sum(e.setupAmt), sum(e.clearAmt), sum(e.extraAmt), sum(e.totalPay), count(*)";
$detsSQL = $detsSQL . " from funcEmps e, employees n, events v, depts d, funcTypes ft";
$detsSQL = $detsSQL . " where v.unitId='$unitId' and v.wkendDate = '$wkendDate' and e.unitId = v.unitId and e.eventNum = v.eventNum";
$detsSQL = $detsSQL . " and ft.unitId = e.unitId and ft.funcType = v.funcType and ft.funcGroup = '$funcGroup'";
$detsSQL = $detsSQL . " and n.unitId = v.unitId and n.emplid = e.emplid and d.unitId = v.unitId and d.deptId = n.deptId";
$detsSQL = $detsSQL . " and d.effdt = (select max(effdt) from depts d2 where d2.deptId = d.deptId)";
$detsSQL = $detsSQL . " and n.effdt = (select max(effdt) from employees n2 where n2.emplid = n.emplid and n2.unitId = n.unitId and n2.effdt <= v.funcDate)";
$detsSQL = $detsSQL . " group by n.emplid, n.name, d.dud, n.jobcode";
$detsResult = $db->query($detsSQL);
$rows = mysql_num_rows($detsResult);

$lineCnt    = 0;
$pageCnt    = 0;
$printCnt   = 0;
$eeCoversT  = 0;
$eeWeightT  = 0;
$baseWageT  = 0;
$hoursT     = 0;
$setupAmtT  = 0;
$clearAmtT  = 0;
$extraAmtT  = 0;
$totalPayT  = 0;
$totalWagesT= 0;

while ($detsRecs = $detsResult->fetch_row()) {

   if ($lineCnt == 0) {
      $pageCnt++;
      if ($pageCnt > 1) {
         echo "</table><span class='page-break'></span>";
      }
      echo "<table class='fullReport'>";
      echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
      echo "<tr><td class='headLeft'><h4>Week's Summary</h4></td><td></td><td class='headRight'><h4>$today</h4></td></tr>";
      echo "<tr><td class='headLeft'><h4 id='download'>File:$fileName</h4></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
      echo "</table>";

      echo "<table class='fullReport'>";
      echo $repHeads;
      $className = "shade";
   }

   $lineCnt++;
   $emplid         = $detsRecs[0];
   $name           = $detsRecs[1];
   $dud            = $detsRecs[2];
   $jobcode        = $detsRecs[3];
   $locid          = $detsRecs[4];
   $baseWage       = $detsRecs[5];
   $hours          = $detsRecs[6];
   $setupAmt       = $detsRecs[7];
   $clearAmt       = $detsRecs[8];
   $extraAmt       = $detsRecs[9];
   $totalPay       = $detsRecs[10];
   $events         = $detsRecs[11];

   $totalWages = $baseWage + $setupAmt + $clearAmt + $extraAmt;

   for ($i=1; $i <= $miscCnt; $i++) {
      $miscTots[$miscCodes[$i]] = 0;
   }
   $unit = substr($locid, 2, 3);
   if ($locid == null)
      $unit = "XXX";
   if ($locid == $unitId)
      $unit = "";

   echo "<tr class='$className'><td class='txtfld'>$emplid$unit</td><td class='txtfld repsNameCell'>$name($events)</td><td class='numfld'>$baseWage</td><td class='numfld'>$setupAmt</td><td class='numfld'>$clearAmt</td><td class='numfld'>$extraAmt</td><td class='numfld'>$totalWages</td>";
//
// For each of the grat types that were identified as being in use for the entire week, attempt to accumulate that type for the given employee.  If matched, then show it, else show 0
//
   for ($i=1; $i<=$gratCnt; $i++) {
      $gratType = $grats[$i];
      $gratSums = "Select sum(eg.gratAmt) from funcEmpGrats eg, events e, funcTypes ft";
      $gratSums = $gratSums . " where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and eg.unitId = e.unitId";
      $gratSums = $gratSums . " and eg.eventNum = e.eventNum and eg.emplid = '$emplid' and eg.gratType = '$gratType'";
      $gratSums = $gratSums . " and ft.unitId = e.unitId and ft.funcGroup = '$funcGroup' and ft.funcType = e.funcType";
      $gratsRes = $db->query($gratSums);
      $rows     = $gratsRes->num_rows;
      $gratSum  = $gratsRes->fetch_row();
      $gratTot  = $gratSum[0];
      if ($gratTot != "") {
         echo "<td class='numfld'>$gratTot";
         $gratTots[$i] = $gratTots[$i] + $gratTot;
         for ($j=1; $j<=$miscCnt; $j++) {
             if ($gratType == $gratTypes[$j]) {
//                echo $miscCodes[$j];
                $miscTots[$miscCodes[$j]] = $miscTots[$miscCodes[$j]] + $gratTot;   //Take the total and accumulate it against the Misc Codes
//                echo "/". $miscTots[$miscCodes[$j]];
                }
             }
         echo "</td>";
         }
      else
         echo "<td class='numfld'>0.00</td>";
   }

   if ($csvFormat == 1) {
//      if ($locid !== $unitId)
         $recLine0 = "$unitId,$dud,$emplid" ."$unit,";
//      else
//         $recLine0 = "$unitId,$dud,$emplid,";
      for ($j=1; $j<=$miscCnt; $j++) {
          if ($miscTots[$miscCodes[$j]] != 0) {
             $recLine = $recLine0 . "$miscCodes[$j],," .$miscTots[$miscCodes[$j]]. ",$jobcode,$Weekending,$name\n";
             fwrite($fh, $recLine);
          }
      }
      if ($totalWages >  0 ) {
        $recLine = $recLine0 . "19,,$totalWages,123456,$Weekending,$name\n";
        fwrite($fh, $recLine);
      }
      if ($hours >  0 ) {
        if ($hours > 40)
           $hours = 40;
        $recLine = $recLine0 . "41,,$hours,123456,$Weekending,$name\n";
        fwrite($fh, $recLine);
      }
   }

   if ($csvFormat == 2) {
      $recLine0 = $unitId .$tab .$dud .$tab .$emplid.$unit .$tab;
      for ($j=1; $j<=$miscCnt; $j++) {
          if ($miscTots[$miscCodes[$j]] != 0) {
             $recLine = $recLine0 . $miscCodes[$j] .$tab ."0" .$tab .$miscTots[$miscCodes[$j]] .$tab .$jobcode .$tab .$Weekending .$tab  .'"' .$name. '"' ."\n";
             fwrite($fh, $recLine);
             $miscTots[$miscCodes[$j]] = 0;
          }
      }
      if ($totalWages >  0 ) {
        $recLine = $recLine0 . "19" .$tab;
        if ($hours >  0 ) {
           if ($hours > 40)
              $hours = 40;
           $recLine = $recLine . "0";   //$hours;
        } else {
           $recLine = $recLine . "0";
        }
        $recLine = $recLine .$tab .$totalWages .$tab .$jobcode .$tab .$Weekending .$tab  .'"' .$name. '"' ."\n";
        fwrite($fh, $recLine);
      }
   }

   echo "<td class='numfld'>$totalPay</td></tr>";

   $printCnt++;
   $eeCoversT  = $eeCoversT + $eeCovers;
   $baseWageT  = $baseWageT + $baseWage;
   $hoursT     = $hoursT    + $hours;
   $setupAmtT  = $setupAmtT + $setupAmt;
   $clearAmtT  = $clearAmtT + $clearAmt;
   $extraAmtT  = $extraAmtT + $extraAmt;
   $foodCutT   = $foodCutT  + $foodCut;
   $barCutT    = $barCutT   + $barCut;
   $totalPayT  = $totalPayT + $totalPay;
   $totalWagesT= $totalWagesT+ $totalWages;

   if ($lineCnt == 30) {
//      echo "</table><span class='page-break'></span>";
      $lineCnt = 0;
   }

   if ($lineCnt / 2 == round($lineCnt /2, 0)) {
     $className = "shade";
   } else {
     $className = "";
   }

}

echo "<tr class='$className'><td></td><td>Totals:</td><td class='numfld'>";
echo number_format($baseWageT,2) ."</td><td class='numfld'>";
echo number_format($setupAmtT,2) ."</td><td class='numfld'>";
echo number_format($clearAmtT,2) ."</td><td class='numfld'>";
echo number_format($extraAmtT,2) ."</td><td class='numfld'>";
echo number_format($totalWagesT,2) ."</td><td class='numfld'>";
for ($i=1; $i<=$gratCnt; $i++)
   echo number_format($gratTots[$i],2) ."</td><td class='numfld'>";
echo number_format($totalPayT,2) ."</td></tr>";

echo "</table>";
fclose($fh);
?>
