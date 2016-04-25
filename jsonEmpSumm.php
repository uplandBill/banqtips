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

$getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
$recs   = mysql_fetch_array($result, MYSQL_NUM);
$wkendDate = $recs[1];
$wkEndForm = $recs[2];
$unitName  = $recs[3];
$csvFormat = $recs[4];

$gratTypes = array();
$miscCodes = array();
$miscTots = array();    //     0         1
$miscSql = "select distinct gratType, miscCode from gratTypes where unitId = '$unitId'"; 
$miscRes = mysql_query($miscSql) or die('select weekend dat failed: ' . mysql_error());
$miscCnt = 0;
while ($gratRec = mysql_fetch_array($miscRes, MYSQL_NUM)) {
    $miscCnt++;
    $gratType = $gratRec[0];
    $miscCode = $gratRec[1];
    $gratTypes[$miscCnt] = $gratType;
    $miscCodes[$miscCnt] = $miscCode;
    $miscTots[$miscCode] = 0;
}

$empArr = array();
$h1="Row";
$h2="Emplid";
$h3="Name";
$h4="Role";
$h5="Functions";
$h6="Base Wage";
$h7="Hours";
$h8="Setup";
$h9="Clear";
$h10="Extra";
$tot="Total Pay";
$headArr=array("h1", "h2", "h3", "h4", "h5", "h6", "h7", "h8", "h9", "h10");
$gratCnt=0;
//                     Load the different Grats used for the entire week
//                      0             1             2             3         4
$gratSQL = "Select g.gratType, gt.gratDescr, gt.dispOrder, gt.miscCode, count(*)";
$gratSQL = $gratSQL ." from events e, funcGrats g, gratTypes gt";
$gratSQL = $gratSQL ." where e.unitId='$unitId' and e.wkendDate ='$wkendDate'";
$gratSQL = $gratSQL ." and g.unitId = e.unitId and g.eventNum = e.eventNum";
$gratSQL = $gratSQL ." and gt.unitId = g.unitId and gt.gratType = g.gratType group by g.gratType, gt.gratDescr, gt.dispOrder order by 5 desc, 3 asc";
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
	    $h11 = $gratDescr;
	    array_push($headArr,"h11");
	 }
	 if ($gratCnt == 2) {
	    $h12 = $gratDescr;
	    array_push($headArr,"h12");
	 }
	 if ($gratCnt == 3) {
	    $h13 = $gratDescr;
	    array_push($headArr,"h13");
	 }
	 if ($gratCnt == 4) {
	    $h14 = $gratDescr;
	    array_push($headArr,"h14");
	 }
	 if ($gratCnt == 5) {
	    $h15 = $gratDescr;
	    array_push($headArr,"h15");
	 }
      }
}
    array_push($headArr,"tot");

  $empArr["1"] = compact($headArr);

//                      0         1        2        3          4              5           6                7              8                9               10              11
$funcEmps = "Select e.unitId, e.emplid, n.name, e.eeType, et.eeTypeDescr, count(*), sum(e.baseWage), sum(e.hours), sum(e.setupAmt), sum(e.clearAmt), sum(e.extraAmt), sum(e.totalPay)";
$funcEmps = $funcEmps ." from funcEmps e, employeeTypes et, employees n, wkendCal c, events v";
$funcEmps = $funcEmps ." where c.unitId='$unitId' and c.weekStatus = 'O' and v.unitId = c.unitId and v.wkendDate = c.wkendDate and e.unitId = c.unitId and e.eventNum = v.eventNum and et.unitId = e.unitId";
$funcEmps = $funcEmps ." and et.eeType = e.eeType and n.unitId = e.unitId and n.emplid = e.emplid group by e.unitId, e.emplid, n.name, e.eeType, et.eeTypeDescr order by 6 desc, 4";
$result = mysql_query($funcEmps) or die('select emp event data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$empSeq = 2;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
        $unitId        = $recs[0];
        $emplid        = $recs[1];
        $name          = $recs[2];
        $eeType        = $recs[3];
        $eeTypeDescr   = $recs[4];
        $funcTot       = $recs[5];
        $sumBaseWage   = $recs[6];
        $sumHours      = $recs[7];
        $sumSetup      = $recs[8];
        $sumClear      = $recs[9];
        $sumExtra      = $recs[10];
        $sumTotal      = $recs[11];
        $empLine       = array("unitId", "emplid", "name", "eeType", "eeTypeDescr", "funcTot", "sumBaseWage", "sumHours", "sumSetup", "sumClear", "sumExtra");

        for ($i=1; $i<=$gratCnt; $i++) {
           $gratType = $grats[$i];
           $gratSQL = "Select g2.emplid, sum(g2.gratAmt) from funcEmpGrats g2, events v2";
           $gratSQL = $gratSQL ." where v2.unitId='$unitId' and v2.wkendDate='$wkendDate' and g2.unitId = v2.unitId and g2.eventNum = v2.eventNum and g2.gratType = '$gratType' and g2.emplid='$emplid'";
           $gratSQL = $gratSQL ." group by g2.emplid";

           $gratRes = mysql_query($gratSQL) or die('select grats data failed: ' . mysql_error());
           $gratRec = mysql_fetch_array($gratRes, MYSQL_NUM);
           $gratAmt = $gratRec[1];
           if ($i == 1) {
              $grat1 = $gratAmt;
              array_push($empLine,"grat1");
           }
           if ($i == 2) {
              $grat2 = $gratAmt;
              array_push($empLine,"grat2");
           }
           if ($i == 3) {
              $grat3 = $gratAmt;
              array_push($empLine,"grat3");
           }
           if ($i == 4) {
              $grat4 = $gratAmt;
              array_push($empLine,"grat4");
           }
           if ($i == 5) {
              $grat5 = $gratAmt;
              array_push($empLine,"grat5");
           }
        }
        array_push($empLine,"sumTotal");
        
        $empArr["$empSeq"] = compact($empLine);
        $empSeq++;
}

// Send the data.
echo json_encode($empArr);

?>