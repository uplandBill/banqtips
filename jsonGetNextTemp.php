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
$parm1  = $_GET['parm1'];

//                      0         1     
$updSQL = "update units set lastTempId = lastTempId +1 where unitId='$unitId'";
$result = mysql_query($updSQL) or die('upd last temp failed: ' . mysql_error());

$getSQL = "Select u.unitId, u.lastTempId from units u where u.unitId='$unitId'";
$result = mysql_query($getSQL) or die('select emp event data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$topArr = array();
$arrSeq = 1;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$unitId        = $recs[0];
	$lastTempId    = $recs[1];
	$arrLine       = compact("unitId", "lastTempId");

	$topArr["$arrSeq"] = $arrLine;
	$arrSeq++;
}

// Send the data.
echo json_encode($topArr);

?>