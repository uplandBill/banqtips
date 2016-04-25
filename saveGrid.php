<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];

  $eventNum      = $_POST['eventNum'];
  $empSeq        = $_POST['empSeq'];
  $emplid        = $_POST['emplid'];
  $eeType        = $_POST['eeType'];
  $payGrp        = $_POST['payGrp'];
  $emplClass     = $_POST['emplClass'];
  $getSetup      = $_POST["getSetup"];
  $getClear      = $_POST["getClear"];
  $getExtra      = $_POST["getExtra"];
  $coversAllowed = $_POST["coversAllowed"];
  $eeCovers      = $_POST["eeCovers"];
  $eeWeight      = $_POST["eeWeight"];
  $eeBaseWage    = $_POST['eeBaseWage'];
  $foodRate      = $_POST['foodRate'];
  $foodGroup     = $_POST['foodGroup'];
  $barRate       = $_POST['barRate'];
  $barGroup      = $_POST['barGroup'];
  $baseWage      = $_POST['baseWage'];
  $hours         = $_POST['hours'];
  $setupAmt      = $_POST['setupAmt'];
  $clearAmt      = $_POST['clearAmt'];
  $extraAmt      = $_POST['extraAmt'];
  $foodCut       = $_POST['foodCut'];
  $barCut        = $_POST['barCut'];
  $totalPay      = $_POST['totalPay'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $gridSave = "Replace into funcEmps (unitId,   eventNum,  empSeq,   emplid,   eeType,   payGrp,   emplClass,    getSetup,    getClear,    getExtra,    eeBaseWage,   foodRate,   foodGroup,   barRate,   barGroup,    coversAllowed,   eeCovers,  eeWeight, baseWage,   hours,  setupAmt,  clearAmt,  extraAmt,  foodCut,  barCut,  totalPay)";
  $gridSave = $gridSave .  " values('$unitId', $eventNum, $empSeq, '$emplid', $eeType, '$payGrp', '$emplClass', '$getSetup', '$getClear', '$getExtra', '$eeBaseWage', $foodRate, '$foodGroup', $barRate, '$barGroup', '$coversAllowed', $eeCovers, $eeWeight, $baseWage, $hours, $setupAmt, $clearAmt, $extraAmt, $foodCut, $barCut, $totalPay)";
  $result = mysql_query($gridSave) or die("grid save failed for: $eventNum - $emplid: " . mysql_error());
  echo "Emp $empSeq Saved";

?>