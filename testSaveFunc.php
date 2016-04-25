<?php
  session_start();

  $jsonGrid  = json_decode(file_get_contents('php://input'));
  $saveCnt = 0;
  
  $loop = 0;
//  var_dump($jsonGrid);
  foreach ($jsonGrid as $row => $jsonGridRow) {
     $loop++;
     $empSeq        = $jsonGridRow->empSeq;
     $gratType      = $jsonGridRow->gratType;
     if ($gratType != NULL) {
        echo "save grat: " .$gratType . "</br>";
        }
     else {
        echo "save employee: " . $empSeq . "</br>";
        }
  }
  
  foreach ($jsonGrid as $row => $jsonGridRow) {
//     foreach ($jsonGridRow as $key => $value) 
//     $eventNum      = $jsonGridRow->eventNum;
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

  }

echo '{"results":"complete"}';
?>