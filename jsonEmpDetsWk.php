<?php

  session_start();
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

// This ID parameter is sent by our javascript client.
$unitId = $_GET['unitId'];
$emplid = $_GET['emplid'];

$getSQL = "Select c.unitId, c.wkendDate, u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
$recs = mysql_fetch_array($result, MYSQL_NUM);
$wkendDate = $recs[1];
$unitName  = $recs[2];
$csvFormat = $recs[3];

$h1="Position";
$h2="Func Date";
$h3="Func Type";
$h4="Base Wage";
$h5="Hours";
$h6="Setup";
$h7="Clear";
$h8="Extra";
$h9="Total";

$gratTots    = array();
$empArr      = array();

$grats       = array();
$gratsDescrs = array();
$gratCnt = 0;
//                      0             1             2             3         4
$gratSQL = "Select g.gratType, gt.gratDescr, gt.dispOrder, gt.miscCode, count(*)";
$gratSQL = $gratSQL . " from events e, funcEmpGrats g, gratTypes gt";
$gratSQL = $gratSQL . " where e.unitId='$unitId' and e.wkendDate ='$wkendDate' and g.unitId = e.unitId and g.eventNum = e.eventNum";
$gratSQL = $gratSQL . " and g.emplid = '$emplid' and gt.unitId = g.unitId and gt.gratType = g.gratType and g.gratAmt > 0";
$gratSQL = $gratSQL . " group by g.gratType, gt.gratDescr, gt.dispOrder";
$gratSQL = $gratSQL . " order by 5 desc, 3 asc";
$gratRes = mysql_query($gratSQL) or die('select grats data failed: ' . mysql_error());
while ($gratRec = mysql_fetch_array($gratRes, MYSQL_NUM)) {
      $gratType  = $gratRec[0];
      $gratDescr = $gratRec[1];
      $miscCode  = $gratRec[3];
      $count     = $gratRec[4];
      if ($gratType != "X") {
         $gratCnt++;
         $grats[$gratCnt] = $gratType;
         $gratsDescrs[$gratCnt] = $gratDescr;
         if ($gratCnt == 1) {
            $h10 = $gratRec[1];
            $h11 = "Total Pay";
            }
         if ($gratCnt == 2) {
            $h11 = $gratRec[1];
            $h12 = "Total Pay";
            }
         if ($gratCnt == 3) {
            $h12 = $gratRec[1];
            $h13 = "Total Pay";
            }
         if ($gratCnt == 4) {
            $h13 = $gratRec[1];
            $h14 = "Total Pay";
            }
         if ($gratCnt == 5) {
            $h14 = $gratRec[1];
            $h15 = "Total Pay";
            }
         if ($gratCnt == 6) {
            $h15 = $gratRec[1];
            $h16 = "Total Pay";
            }
      }
}
 $empLine = compact("h1", "h2", "h3", "h4", "h5", "h6", "h7", "h8", "h9", "h10", "h11", "h12", "h13", "h14", "h15", "h16");
 $empArr[1] = $empLine;

//                      0         1        2             3             4            5           6          7          8         9           10        11            12         13         14            15
$funcEmps = "Select e.unitId, e.emplid, e.eeType, e.eventNum, et.eeTypeDescr, f.funcDate, ft.funcDescr, e.baseWage, e.hours, e.setupAmt, e.clearAmt, e.extraAmt, e.grat1Cut, e.grat2Cut, e.grat3Cut, e.totalPay";
$funcEmps = $funcEmps . " from funcEmps e, employeeTypes et, wkendCal c, events f, funcTypes ft";
$funcEmps = $funcEmps . " where c.unitId = '$unitId' and c.weekStatus = 'O' and f.wkendDate = c.wkendDate and e.eventNum = f.eventNum and e.unitId = c.unitId and e.emplid = '$emplid' and et.unitId = e.unitId and et.eeType = e.eeType and ft.funcType = f.funcType";
$funcEmps = $funcEmps . " order by 6 desc, 4";
$result = mysql_query($funcEmps) or die('select emp event data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$empSeq = 2;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$unitId        = $recs[0];
	$emplid        = $recs[1];
	$eeType        = $recs[2];
	$eventNum      = $recs[3];
	$eeTypeDescr   = $recs[4];
	$funcDate      = $recs[5];
	$funcDescr     = $recs[6];
	$sumBaseWage   = $recs[7];
	$sumHours      = $recs[8];
	$sumSetup      = $recs[9];
	$sumClear      = $recs[10];
	$sumExtra      = $recs[11];
	$sumCut1       = $recs[12];
	$sumCut2       = $recs[13];
	$sumCut3       = $recs[14];
	$sumTotal      = $recs[15];
	$sumWages = $sumBaseWage + $sumSetup + $sumClear + $sumExtra;

        $compArr = array("unitId", "emplid", "eeType", "eeTypeDescr", "funcDate", "funcDescr", "sumBaseWage", "sumHours", "sumSetup", "sumClear", "sumExtra", "sumWages"); //"sumCut1", "sumCut2", "sumCut3", "sumTotal");
	for ($i=1; $i<=$gratCnt; $i++) {
	     $gratType = $grats[$i];
	     $indGrats = "Select gratAmt from funcEmpGrats g where g.unitId = '$unitId' and g.eventNum = $eventNum and g.emplid = '$emplid' and g.gratType = '$gratType'";
	     $indRes = mysql_query($indGrats) or die('select emp grats failed: ' . mysql_error());
	     $indRec = mysql_fetch_array($indRes, MYSQL_NUM);
	     $gratAmt = $indRec[0];
	     if ($i == 1) {
	        $grat1 = $gratAmt;
	        array_push($compArr,"grat1");
	     }
	     if ($i == 2) {
	        $grat2 = $gratAmt;
	        array_push($compArr,"grat2");
	     }
	     if ($i == 3) {
	        $grat3 = $gratAmt;
	        array_push($compArr,"grat3");
	     }
	     if ($i == 4) {
	        $grat4 = $gratAmt;
	        array_push($compArr,"grat4");
	     }
	     if ($i == 5) {
	        $grat5 = $gratAmt;
	        array_push($compArr,"grat5");
	     }
        }
        array_push($compArr,"sumTotal");
        
	$empLine       = compact($compArr);

	$empArr["$empSeq"] = $empLine;
	$empSeq++;
}

// Send the data.
echo json_encode($empArr);

?>