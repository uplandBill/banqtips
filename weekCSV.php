<?php


//  Genereic json Get

  session_start();
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// This ID parameter is sent by our javascript client.
$unitId = $_GET['unitId'];

//                    0          1           2           3            4          5           6           7            8           9           10    
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
echo" </style></head><body>";

$wkendDate = $recs[1];
$unitName  = $recs[2];
$csvFormat = $recs[3];
$Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);

$stamp=getdate();
$fileName = "BQT_$unitId.$Weekending.$stamp[hours]$stamp[minutes]$stamp[seconds].csv";

$myFile = "./files/$fileName";
$fh = fopen($myFile, 'w') or die("can't open file");

//                     0        1       2       3             4               5               6              7                8               9              10               11
$detsSQL = "Select e.emplid, n.name, d.dud, n.jobcode, sum(e.baseWage), sum(e.hours), sum(e.setupAmt), sum(e.clearAmt), sum(e.extraAmt), sum(e.foodCut), sum(e.barCut), sum(e.totalPay) from funcEmps e, employees n, events v, depts d where v.unitId='$unitId' and v.wkendDate = '$wkendDate' and e.unitId = v.unitId and e.eventNum = v.eventNum and n.unitId = v.unitId and n.emplid = e.emplid and d.unitId = v.unitId and d.deptId = n.deptId and d.effdt = (select max(effdt) from depts d2 where d2.deptId = d.deptId) group by n.emplid, n.name, d.dud, n.jobcode";
$detsResult = mysql_query($detsSQL) or die('select emp events data failed: ' . mysql_error());
$rows = mysql_num_rows($detsResult);

$lineCnt = 0;
$printCnt = 0;
$eeCoversT  = 0;
$eeWeightT  = 0;
$baseWageT  = 0;
$hoursT     = 0;
$setupAmtT  = 0;
$clearAmtT  = 0;
$extraAmtT  = 0;
$foodCutT   = 0;
$barCutT    = 0;
$totalPayT  = 0;
$totalWagesT= 0;

while ($detsRecs = mysql_fetch_array($detsResult, MYSQL_NUM)) {

   if ($lineCnt == 0) {
      echo "<table>";
      echo "<tr><td class='char' id='download' colspan=2>File:$fileName</td><td class='char' colspan=3> $unitName </td><td>Weekending Date: $wkendDate</td></tr>";
      echo "<tr></tr>";
      echo "</table>";
      
      echo "<table>";
      echo "<tr><th>Emplid</th><th class='repsNameCell'>Employee</th><th>Base Wage</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Total</th><th>Food Grat</th><th>Bar Grat</th><th>Total Pay<?th></tr>";
      $className = "shade";
     }

   $lineCnt++;
   $emplid         = $detsRecs[0];
   $name           = $detsRecs[1];
   $dud            = $detsRecs[2];
   $jobcode        = $detsRecs[3];
   $baseWage       = $detsRecs[4];
   $hours          = $detsRecs[5];
   $setupAmt       = $detsRecs[6];
   $clearAmt       = $detsRecs[7];
   $extraAmt       = $detsRecs[8];
   $foodCut        = $detsRecs[9];
   $barCut         = $detsRecs[10];
   $totalPay       = $detsRecs[11];
   
   $totalWages = $baseWage + $setupAmt + $clearAmt + $extraAmt;

   if ($csvFormat == 1) {   
      $recLine0 = "$unitId,$unitId,$emplid,";
      if ($foodCut >  0 ) {
      	$recLine = $recLine0 . "18,,$foodCut,123456,$Weekending,$name\n";
        fwrite($fh, $recLine);
      }
      if ($barCut >  0 ) {
      	$recLine = $recLine0 . "19,,$barCut,123456,$Weekending,$name\n";
        fwrite($fh, $recLine);
      }
      if ($totalWages >  0 ) {
      	$recLine = $recLine0 . "19,,$totalWages,123456,$Weekending,$name\n";
        fwrite($fh, $recLine);
      }
      if ($hours >  0 ) {
      	if ($hours > 40)
      	   $hours = 40;
      	$recLine = $recLine0 . "23,,$hours,123456,$Weekending,$name\n";
        fwrite($fh, $recLine);
      }
   }
   
   if ($csvFormat == 2) {   
      $recLine0 = "$unitId,$unitId,$emplid,";
      if ($foodCut >  0 ) {
      	$recLine = $recLine0 . "18,,$foodCut,$jobcode,$Weekending," .'"' .$name. '"' ."\n";
        fwrite($fh, $recLine);
      }
      if ($barCut >  0 ) {
      	$recLine = $recLine0 . "19,,$barCut,$jobcode,$Weekending,"  .'"' .$name. '"' ."\n";
        fwrite($fh, $recLine);
      }
      if ($totalWages >  0 ) {
      	$recLine = $recLine0 . "19,,$totalWages,$jobcode,$Weekending,"  .'"' .$name. '"' ."\n";
        fwrite($fh, $recLine);
      }
      if ($hours >  0 ) {
      	if ($hours > 40)
      	   $hours = 40;
      	$recLine = $recLine0 . "23,$hours,0,$jobcode,$Weekending,"  .'"' .$name. '"' ."\n";
        fwrite($fh, $recLine);
      }
//      $recLine = "$unitId,$dud,$emplid,";
//      $recLine = $recLine . number_format($baseWage,2,".","") .",";
//      $recLine = $recLine . number_format($setupAmt,2,".","") .",";
//      $recLine = $recLine . number_format($clearAmt,2,".","")  .",";
//      $recLine = $recLine . number_format($extraAmt,2,".","")  .",";
//      $recLine = $recLine . number_format($totalWages,2,".","")  .",";
//      $recLine = $recLine . number_format($foodCut,2,".","")  .",";
//      $recLine = $recLine . number_format($barCut,2,".","")  .",";
//      $recLine = $recLine . number_format($totalPay,2,".","")  ."\n";
//      fwrite($fh, $recLine);
   }
      
   echo "<tr class='$className'><td class='txtfld'>$emplid</td><td class='txtfld repsNameCell'>$name</td><td>$baseWage</td><td>$setupAmt</td><td>$clearAmt</td><td>$extraAmt</td><td>$totalWages</td><td>$foodCut</td><td>$barCut</td><td>$totalPay</td></tr>";

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
      echo "</table><span class='page-break'></span>";
      $lineCnt = 0;
   }

   if ($lineCnt / 2 == round($lineCnt /2, 0)) {
     $className = "shade";
   } else {
     $className = "";
   }


}
     echo "<tr class='$className'><td></td><td>Totals:</td><td>";
     echo number_format($baseWageT,2) ."</td><td>";
     echo number_format($setupAmtT,2) ."</td><td>";
     echo number_format($clearAmtT,2) ."</td><td>";
     echo number_format($extraAmtT,2) ."</td><td>";
     echo number_format($totalWagesT,2) ."</td><td>";
     echo number_format($foodCutT,2) ."</td><td>";
     echo number_format($barCutT,2) ."</td><td>";
     echo number_format($totalPayT,2) ."</td></tr>";

     echo "</table>";
fclose($fh);
?>