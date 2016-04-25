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
$unitId   = $_GET['unitId'];
$funcType = $_GET['funcType'];
$funcDate = $_GET['funcDate'];  //Should come in YYYY-MM-DD

if ($funcDate == "") {
  $funcDate = date("Y-m-d");
}

if (substr($funcDate, 2, 1) == "/") {    //format difference in selection vs loading from DB
   $funcDate = substr($funcDate, 6, 4) .'-'. substr($funcDate, 0, 2) .'-'. substr($funcDate, 3, 2);
}

// echo $unitId ."<br/>";
// echo $funcType ."<br/>";
// echo $funcDate ."<br/>";

$getSql = "";
//                      0         1           2           3       4 
$getSQL = $getSQL ."Select w.unitId, w.funcType, w.emplClass, w.effdt, w.baseWage from baseWages w";
$getSQL = $getSQL ." where w.unitId='$unitId' and w.funcType = $funcType";
$getSQL = $getSQL ." and w.effdt = (select max(effdt) from baseWages w2";
$getSQL = $getSQL ." Where w2.unitId = w.unitId and w2.funcType = w.funcType and w2.emplClass = w.emplClass";
$getSQL = $getSQL ." and w2.effdt <= '$funcDate')";
$getSQL = $getSQL ." order by emplClass";
$result = mysql_query($getSQL) or die('select emp event data failed: ' . mysql_error());
$rows = mysql_num_rows($result);
// echo "Num Rows:" .$rows;

$topArr = array();
$arrSeq = 1;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$unitId        = $recs[0];
	$funcType      = $recs[1];
	$emplClass     = $recs[2];
	$baseWage      = $recs[4];
	$arrLine       = compact("unitId", "funcType", "emplClass", "baseWage");

	$topArr["$arrSeq"] = $arrLine;
	$arrSeq++;
}

// Send the data.
echo json_encode($topArr);

?>