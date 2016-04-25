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

$funcEmps = "Select gratType, gratDescr from gratTypes where unitId = '$unitId' and gratType <> 'X'";
$result = mysql_query($funcEmps) or die('select grat descr data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$empArr = array();
$empSeq = 1;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
        $gratType      = $recs[0];
        $gratDescr     = $recs[1];
        $empLine       = compact("gratDescr");

        $empArr["$gratType"] = $empLine;
        $empSeq++;
}

// Send the data.
echo json_encode($empArr);

?>