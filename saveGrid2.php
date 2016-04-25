<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];

  $jsonGrid  = json_decode(file_get_contents('php://input'));

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $saveCnt = 0;

  foreach ($jsonGrid as $row => $jsonGridRow) {
//     foreach ($jsonGridRow as $key => $value) 
     $eventNum      = $jsonGridRow->eventNum;
     $empSeq        = $jsonGridRow->empSeq;
     $emplid        = $jsonGridRow->emplid;
     $eeType        = $jsonGridRow->eeType;
     $payGrp        = $jsonGridRow->payGrp;
     $emplClass     = $jsonGridRow->emplClass;
     $getSetup      = $jsonGridRow->getSetup;
     $getClear      = $jsonGridRow->getClear;
     $getExtra      = $jsonGridRow->getExtra;
     $coversAllowed = $jsonGridRow->coversAllowed;
     $eeCovers      = $jsonGridRow->eeCovers;
     $eeWeight      = $jsonGridRow->eeWeight;
     $eeBaseWage    = $jsonGridRow->eeBaseWage;
     $foodRate      = $jsonGridRow->foodRate;
     $foodGroup     = $jsonGridRow->foodGroup;
     $barRate       = $jsonGridRow->barRate;
     $barGroup      = $jsonGridRow->barGroup;
     $baseWage      = $jsonGridRow->baseWage;
     $hours         = $jsonGridRow->hours;
     $setupAmt      = $jsonGridRow->setupAmt;
     $clearAmt      = $jsonGridRow->clearAmt;
     $extraAmt      = $jsonGridRow->extraAmt;
     $foodCut       = $jsonGridRow->foodCut;
     $barCut        = $jsonGridRow->barCut;
     $totalPay      = $jsonGridRow->totalPay;
     $gridSave = "Replace into funcEmps (unitId,   eventNum,  empSeq,   emplid,   eeType,   payGrp,   emplClass,    getSetup,    getClear,    getExtra,    eeBaseWage,   foodRate,   foodGroup,   barRate,   barGroup,    coversAllowed,   eeCovers,  eeWeight, baseWage,   hours,  setupAmt,  clearAmt,  extraAmt,  foodCut,  barCut,  totalPay)";
     $gridSave = $gridSave .  " values('$unitId', $eventNum, $empSeq, '$emplid', $eeType, '$payGrp', '$emplClass', '$getSetup', '$getClear', '$getExtra', '$eeBaseWage', $foodRate, '$foodGroup', $barRate, '$barGroup', '$coversAllowed', $eeCovers, $eeWeight, $baseWage, $hours, $setupAmt, $clearAmt, $extraAmt, $foodCut, $barCut, $totalPay)";
     $result = mysql_query($gridSave) or die("grid save failed for: $eventNum - $emplid: " . mysql_error());
     $saveCnt++;
  }
  echo "Saved $saveCnt rows, ready.";  	
?>