<?php


//  Genereic json Get

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

//                      0         1           2           3            4          5           6           7            8           9           10    
$getSQL = "Select c.unitId, e.eventNum, e.funcNumWk, e.wkendDate, e.funcDate, e.roomNum, r.roomDescr, e.funcType, f.funcDescr, e.foodGrat, e.barGrat from events e, wkendCal c, rooms r, funcTypes f where c.unitId='$unitId' and c.weekStatus = 'O' and e.unitId = c.unitId and e.wkendDate = c.wkendDate and r.unitId = e.unitId and r.roomNum = e.roomNum  and f.unitId = e.unitId and f.funcType = e.funcType order by funcNumWk";
$result = mysql_query($getSQL) or die('select emp event data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$topArr = array();
$arrSeq = 1;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$unitId        = $recs[0];
	$eventNum      = $recs[1];
	$funcNumWk     = $recs[2];
	$wkendDate     = $recs[3];
	$funcDate      = $recs[4];
	$roomNum       = $recs[5];
	$roomDescr     = $recs[6];
	$funcType      = $recs[7];
	$funcDescr     = $recs[8];
	$foodGrat      = $recs[9];
	$barGrat       = $recs[10];
	$arrLine       = compact("unitId", "eventNum", "funcNumWk", "wkendDate", "funcDate", "roomNum", "roomDescr", "funcType", "funcDescr", "foodGrat", "barGrat");

	$topArr["$arrSeq"] = $arrLine;
	$arrSeq++;
}

// Send the data.
echo json_encode($topArr);

?>