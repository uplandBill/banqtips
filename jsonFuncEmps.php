<?php

  session_start();
  include("db.php5");

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

// This ID parameter is sent by our javascript client.
$eventNum = $_GET['eventNum'];
$unitId   = $_GET['unitId'];

//                    0             1         2         3         4       5            6            7            8          9            10           11           12            13          14           15           16           17          18         19          20               21           22            23          24            25         26         27         28          29         30         31
$funcEmps = "Select e.unitId, e.eventNum, e.empSeq, e.emplid, n.name, e.eeType, et.eeTypeDescr, e.payGrp, e.emplClass, e.grat1Rate, e.grat1Group, e.grat1Cut, e.grat2Rate, e.grat2Group, e.grat2Cut, e.grat3Rate, e.grat3Group, e.grat3Cut, e.getSetup, e.getClear, e.getExtra,  e.coversAllowed, e.eeCovers, e.eeWeight, e.eeBaseWage, e.baseWage, e.eeCovers, e.hours, e.setupAmt, e.clearAmt, e.extraAmt, e.totalPay from funcEmps e, employeeTypes et, employees n where e.eventNum = $eventNum and e.unitId = '$unitId' and et.unitId = e.unitId and et.eeType = e.eeType and n.unitId = e.unitId and n.emplid = e.emplid order by empSeq";
$result = $db->query($funcEmps);
$rows = $result->num_rows;
$empArr = array();

while ($recs = $result->fetch_assoc()) {
	$unitId        = $recs['unitId'];
	$eventNum      = $recs['eventNum'];
	$empSeq        = $recs['empSeq'];
	$emplid        = $recs['emplid'];
	$name          = $recs['name'];
	$eeType        = $recs['eeType'];
	$eeTypeDescr   = $recs['eeTypeDescr'];
	$payGrp        = $recs['payGrp'];
	$emplClass     = $recs['emplClass'];
	$grat1Rate     = $recs['grat1Rate'];
	$grat1Group    = $recs['grat1Group'];
	$grat1Cut      = $recs['grat1Cut'];
	$grat2Rate     = $recs['grat2Rate'];
	$grat2Group    = $recs['grat2Group'];
	$grat2Cut      = $recs['grat2Cut'];
	$grat3Rate     = $recs['grat3Rate'];
	$grat3Group    = $recs['grat3Group'];
	$grat3Cut      = $recs['grat3Cut'];
	$getSetup      = $recs['getSetup'];
	$getClear      = $recs['getClear'];
	$getExtra      = $recs['getExtra'];
	$coversAllowed = $recs['coversAllowed'];
	$eeCovers      = $recs['eeCovers'];
	$eeWeight      = $recs['eeWeight'];
	$eeBaseWage    = $recs['eeBaseWage'];
	$baseWage      = $recs['baseWage'];
	$eeCovers      = $recs['eeCovers'];
	$hours         = $recs['hours'];
	$setupAmt      = $recs['setupAmt'];
	$clearAmt      = $recs['clearAmt'];
	$extraAmt      = $recs['extraAmt'];
	$totalPay      = $recs['totalPay'];

//                           0           1            2           3           4
	$grats = "Select g.gratSeq, e.gratType, e.groupType, e.gratRate, e.gratAmt from funcEmpGrats e, funcGrats g Where g.unitId = '$unitId' and e.unitId = g.unitId and g.eventNum = $eventNum and e.eventNum = g.eventNum and e.emplid = '$emplid' order by g.gratSeq";
        $gratRes = $db->query($grats);
        while ($gratRec = $gratRes->fetch_row()) {
           $gratSeq   = $gratRec[0];
           $gratType  = $gratRec[1];
           $groupType = $gratRec[2];
           $gratRate  = $gratRec[3];
           $gratAmt   = $gratRec[4];
        }

	$empLine       = compact("unitId", "eventNum", "empSeq", "emplid", "name", "eeType", "eeTypeDescr", "payGrp", "emplClass", "grat1Rate", "grat1Group", "grat1Cut",  "grat2Rate", "grat2Group", "grat2Cut",  "grat3Rate", "grat3Group", "grat3Cut", "getSetup", "getClear", "getExtra", "coversAllowed", "eeCovers", "eeWeight", "eeBaseWage", "baseWage", "eeCovers", "hours", "setupAmt", "clearAmt", "extraAmt", "totalPay");

	$empArr["$empSeq"] = $empLine;
}

// Send the data.
echo json_encode($empArr);

?>
