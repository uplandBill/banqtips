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

//                      0         1           2           3            4          5           6           7            8           9           10    
$getSQL = "Select c.unitId, c.wkendDate, u.unitName from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
$recs = mysql_fetch_array($result, MYSQL_NUM);

echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
echo "table {width: 1300px;}";
echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
echo " .shade {background-color: #C9DBDB;}";
echo" </style></head><body>";

$wkendDate = $recs[1];
$unitName = $recs[2];
$pageCnt = 0;
//                    0           1            2           3           4           5           6              7           8           9          10         11          12          13
$getSQL = "Select e.eventNum, e.funcNumWk, e.funcDate, e.roomNum, r.roomDescr, e.funcType, f.funcDescr, e.foodCheck, e.barCheck, e.foodBill, e.barBill, e.foodGrat, e.barGrat, e.totCovers from events e, rooms r, funcTypes f where e.unitId='$unitId' and e.wkendDate = '$wkendDate' and r.unitId = e.unitId and r.roomNum = e.roomNum  and f.unitId = e.unitId and f.funcType = e.funcType order by funcNumWk";
$result = mysql_query($getSQL) or die('select events data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {

//                           0       1         2        3           4           5           6           7           8             9          10           11          12          13              14          15          16          17        18         19          20          21         22
      $detsSQL = "Select e.emplid, n.name, e.empSeq, e.eeType, e.emplClass, e.getSetup, e.getClear, e.getExtra, e.eeBaseWage, e.foodRate, e.foodGroup, e.barRate, e.barGroup, e.coversAllowed, e.eeCovers, e.eeWeight, e.baseWage, e.hours, e.setupAmt, e.clearAmt, e.extraAmt, e.foodCut, e.barCut, e.totalPay from funcEmps e, employees n where e.eventNum = $recs[0] and n.unitId = e.UnitId and n.emplid = e.emplid order by empSeq";
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
       
      $eventEmpCnt = 0;
      if ($pageCnt > 0)
         echo "</table><span class='page-break'></span>";
      while ($detsRecs = mysql_fetch_array($detsResult, MYSQL_NUM)) {

        if ($lineCnt == 0) {
           $pageCnt++;
           echo "<table>";
           echo "<tr><td colspan=3> $unitName </td></tr>";
           echo "<tr><td class='char'>Function Date: $recs[2]</td><td class='char'> Room: $recs[4] $recs[6]</td><td></td><td class='char'>Weekending Date: $wkendDate</td></tr>";
           echo "<tr><td class='char'>Function Number: $recs[1]</td><td></td><td></td><td></td><td>Page: $pageCnt</td></tr>";
           echo "<tr><td></td><td class='char'>Food Check #: $recs[7]</td><td class='char'>Bar Check #: $recs[8]</td><td></td></tr>";
           echo "<tr><td></td><td class='char'>Food Amount: $recs[9]</td><td class='char'>Bar Amount: $recs[10]</td><td></td></tr>";
           echo "<tr><td></td><td class='char'>Food Gratuity: $recs[11]</td><td class='char'>Bar Gratuity: $recs[12]</td><td></td></tr>";
           echo "<tr><td></td><td class='char'>Tip Covers: $recs[13]</td></td><td></td></tr>";
           echo "<tr></tr>";
           echo "</table>";
           
           echo "<table>";
           echo "<tr><th width='200px'>Employee</th><th>Emplid</th><th>Covers</th><th>Base Wage</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Total</th><th>Food Grat</th><th>Bar Grat</th><th>Total Pay<?th></tr>";
          }

        $lineCnt++;
	$emplid         = $detsRecs[0];
	$name           = $detsRecs[1];
	$eeCovers       = $detsRecs[14];
        $eeType         = $detsRecs[3];
        $emplClass      = $detsRecs[4];
        $getSetup       = $detsRecs[5];
        $getClear       = $detsRecs[6];
        $getExtra       = $detsRecs[7];
        $eeBaseWage     = $detsRecs[8];
        $foodRate       = $detsRecs[9];
        $foodGroup      = $detsRecs[10];
        $barRate        = $detsRecs[11];
        $barGroup       = $detsRecs[12];
        $coversAllowed  = $detsRecs[13];
        $eeCovers       = $detsRecs[14];
        $eeWeight       = $detsRecs[15];
        $baseWage       = $detsRecs[16];
        $hours          = $detsRecs[17];
        $setupAmt       = $detsRecs[18];
        $clearAmt       = $detsRecs[19];
        $extraAmt       = $detsRecs[20];
        $foodCut        = $detsRecs[21];
        $barCut         = $detsRecs[22];
        $totalPay       = $detsRecs[23];
        
        if ($lineCnt / 2 == round($lineCnt /2, 0)) {
        	$className = "shade";
        } else {
        	$className = "";
        }
	
	$totalWages = $baseWage + $setupAmt + $clearAmt + $extraAmt;
	
	echo "<tr class='$className'><td width='200px' class='char'>$name</td><td class='char'>$emplid</td><td>";
	echo number_format($eeCovers,0) ."</td><td>";
	echo number_format($baseWage,2) ."</td><td>";
	echo number_format($setupAmt,2) ."</td><td>";
	echo number_format($clearAmt,2) ."</td><td>";
	echo number_format($extraAmt,2) ."</td><td>";
	echo number_format($totalWages,2) ."</td><td>";
	echo number_format($foodCut,2) ."</td><td>";
	echo number_format($barCut,2) ."</td><td>";
	echo number_format($totalPay,2) ."</td></tr>";
        $eventEmpCnt = $eventEmpCnt + 1;
	$printCnt++;
        $eeCoversT  = $eeCoversT + $eeCovers;
        $eeWeightT  = $eeWeightT + $eeWeight;
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
     }
     if ($eventEmpCnt > 0) {
        echo "<tr class='$className'><td width='200px' class='char'></td><td class='char'>Totals</td><td>";
        echo number_format($eeCoversT,0) ."</td><td>";
        echo number_format($baseWageT,2) ."</td><td>";
        echo number_format($setupAmtT,2) ."</td><td>";
        echo number_format($clearAmtT,2) ."</td><td>";
        echo number_format($extraAmtT,2) ."</td><td>";
        echo number_format($totalWagesT,2) ."</td><td>";
        echo number_format($foodCutT,2) ."</td><td>";
        echo number_format($barCutT,2) ."</td><td>";
        echo number_format($totalPayT,2) ."</td></tr>";
     }

     echo "</table>";
}
echo "<script>window.print();</script></body>";
?>