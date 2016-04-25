<?php
  session_start();
  include("db.php5");

  $unitId   = $_GET['unitId'];
  $eventNum = $_GET['eventNum'];

  $funcDate   = $_POST['funcDate'];
  $wkendDate  = $_POST['wkendDate'];
  $roomNum    = $_POST['roomNum'];
  $funcType   = $_POST['funcType'];
  $funcGroup  = $_POST['funcGroup'];
  $funcNumWk  = $_POST['funcNumWk'];
  $foodCheck  = $_POST['foodCheck'];
  $barCheck   = $_POST['barCheck'];
  $foodBill   = $_POST['foodBill'];
  $barBill    = $_POST['barBill'];
  $foodGrat   = $_POST['foodGrat'];
  $barGrat    = $_POST['barGrat'];
  $totCovers  = $_POST['totCovers'];
  $defSetup   = $_POST['defSetup'];
  $defClear   = $_POST['defClear'];
  $defExtra   = $_POST['defExtra'];

  if (substr($funcDate, 2, 1) == "/") {    //format difference in selection vs loading from DB
     $funcDate = substr($funcDate, 6, 4) .'-'. substr($funcDate, 0, 2) .'-'. substr($funcDate, 3, 2);
  }
  
  if ($foodGroup == "") $foodGroup = " ";
  if ($foodCheck == "") $foodCheck = " ";
  if ($barCheck  == "") $barCheck = " ";
  if ($foodBill  == "") $foodBill = 0;
  if ($barBill   == "") $barBill = 0;
  if ($foodGrat  == "") $foodGrat = 0;
  if ($barGrat   == "") $barGrat = 0;
  if ($totCovers == "") $totCovers = 0;
  if ($defSetup  == "") $defSetup = 0;
  if ($defClear  == "") $defClear = 0;
  if ($defExtra  == "") $defExtra = 0;

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  if ($eventNum == "new") {
     $funcSave = "Replace into events (unitId,  wkendDate,   funcDate,   roomNum,    funcType,   funcGroup, funcNumWk,   foodCheck,    barCheck,    foodBill,   barBill,   foodGrat,  barGrat,  totCovers, defSetup, defClear, defExtra)";
     $funcSave = $funcSave . " values('$unitId', '$wkendDate', '$funcDate', $roomNum, $funcType, '$funcGroup', $funcNumWk, '$foodCheck', '$barCheck', $foodBill, $barBill, $foodGrat, $barGrat, $totCovers, $defSetup, $defClear, $defExtra)";
     $result = mysql_query($funcSave) or die('insert of function failed: ' . mysql_error());
  } else {
     $funcSave = "update events set wkendDate='$wkendDate', funcDate='$funcDate', roomNum=$roomNum, funcType=$funcType, funcGroup='$funcGroup', funcNumWk=$funcNumWk, foodCheck='$foodCheck', barCheck='$barCheck', foodBill=$foodBill,"; 
     $funcSave = $funcSave . "barBill=$barBill, foodGrat=$foodGrat, barGrat=$barGrat, totCovers=$totCovers, defSetup=$defSetup, defClear=$defClear, defExtra=$defExtra Where unitId='$unitId' and eventNum=$eventNum";
     $result = mysql_query($funcSave) or die('update of function failed: ' . mysql_error());
  }
  

  $funcSave = "Select eventNum from events where unitId='$unitId' and wkendDate='$wkendDate' and funcNumWk='$funcNumWk'";
  $result = mysql_query($funcSave) or die('get func num failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  $funcNum = mysql_fetch_array($result, MYSQL_NUM);
  $eventNum = $funcNum[0];

  echo 'Saved {"eventNum":"'.$eventNum.'"}';

?>