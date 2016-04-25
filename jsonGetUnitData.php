<?php

// function to return, in JSON, the information for a given unitId

  session_start();
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

//Return something like {"funcNumWk":"14","exists":"no","eventNum":"512","empCnt":"32"}


// This ID parameter is sent by our javascript client.
$unitId    = $_GET["unitId"];
$parm1     = $_GET["parm1"];
$funcNumWk =  $parm1;

$topArr = array();
//                     0         1        2          3            4           5
$getSQL = "Select u.unitName, wkendDay, u.ecMeth, u.csvFormat, u.useBodies, unitImg from units u where u.unitId='$unitId'";
$result = mysql_query($getSQL) or die('Get unit data failed: ' . mysql_error());
$rows = mysql_num_rows($result);
while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
   $unitName   = $recs[0];
   $wkendDay   = $recs[1];
   $ecMeth     = $recs[2];
   $csvFormat  = $recs[3];
   $useBodies  = $recs[4];
   $unitImg    = $recs[5];
   $arrLine       = compact("unitName", "wkendDay", "ecMeth", "csvFormat", "useBodies", "unitImg");

   $topArr[$unitId]=$arrLine;

}

// Send the data.
echo json_encode($topArr);

?>