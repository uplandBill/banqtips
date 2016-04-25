<?php
  session_start();
  include("db.php5");

function erase_function($unitId, $eventNum) {
  if ($unitId == "" || $eventNum == 0) {
    return false;
  } else {
    $gridDel = "delete from funcEmps where unitId = '$unitId' and eventNum = $eventNum";
    $sqlRes = mysql_query($gridDel) or die("grid delete failed for: $unitId - $eventNum" . mysql_error());
     
    $gridDel = "delete from funcEmpCnts where unitId = '$unitId' and eventNum = $eventNum";
    $sqlRes = mysql_query($gridDel) or die("emp cnts delete failed for: $unitId - $eventNum" . mysql_error());
     
    $gratsDel = "delete from funcEmpGrats where unitId = '$unitId' and eventNum = $eventNum";
    $sqlRes = mysql_query($gratsDel) or die("grats delete failed for: $unitId - $eventNum" . mysql_error());
     
    $gratsDel = "delete from funcGrats where unitId = '$unitId' and eventNum = $eventNum";
    $sqlRes = mysql_query($gratsDel) or die("grat types delete failed for: $unitId - $eventNum" . mysql_error());
    return true;
    } 
}

  $unitId     = $_GET['unitId'];

  $logFile = "saveResults-" .$unitId. ".txt";
  $myfile = fopen($logFile, "w") or die("Unable to open file!");
  fwrite($myfile, "Starting save.");

  $eventNum   = $_GET['eventNum'];
  $eventNumIn = $eventNum;

  $funcDate   = $_GET['funcDate'];
  $wkendDate  = $_GET['wkendDate'];
  $roomNum    = $_GET['roomNum'];
  $funcType   = $_GET['funcType'];
  $funcGroup  = $_GET['funcGroup'];
  $funcNumWk  = $_GET['funcNumWk'];
     
  $grat1Type  = $_GET['grat1Type'];
  $grat1Chk   = $_GET['grat1Chk'];
  $grat1Bill  = $_GET['grat1Bill'];
  $grat1Grat  = $_GET['grat1Grat'];
  $grat1Addl  = $_GET['grat1Addl'];
    
  $grat2Type  = $_GET['grat2Type'];
  $grat2Chk   = $_GET['grat2Chk'];
  $grat2Bill  = $_GET['grat2Bill'];
  $grat2Grat  = $_GET['grat2Grat'];
  $grat2Addl  = $_GET['grat2Addl'];
     
  $grat3Type  = $_GET['grat3Type'];
  $grat3Chk   = $_GET['grat3Chk'];
  $grat3Bill  = $_GET['grat3Bill'];
  $grat3Grat  = $_GET['grat3Grat'];
  $grat3Addl  = $_GET['grat3Addl'];
     
  $foodCheck  = $_GET['foodCheck'];
  $barCheck   = $_GET['barCheck'];
  $foodBill   = $_GET['foodBill'];
  $barBill    = $_GET['barBill'];
  $foodGrat   = $_GET['foodGrat'];
  $barGrat    = $_GET['barGrat'];
  $totCovers  = $_GET['totCovers'];
  $defSetup   = $_GET['defSetup'];
  $defClear   = $_GET['defClear'];
  $defExtra   = $_GET['defExtra'];
  $numBodies  = $_GET['numBodies'];
  $wineGrat   = $_GET['wineGrat'];

  $rateDate   = $_GET['rateDate'];

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
  if ($numBodies  == "") $numBodies = 0;
  if ($wineGrat   == "") $wineGrat = 0;

  if ($funcDate == NULL || $funcType == NULL) {
    $result = "Error: func date or type is missing.";
  } else {
     $result  = "Saved";
     
    if (substr($funcDate, 2, 1) == "/") {    //format difference in selection vs loading from DB
      $funcDate = substr($funcDate, 6, 4) .'-'. substr($funcDate, 0, 2) .'-'. substr($funcDate, 3, 2);
    }
     
    $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
    $db_selected = mysql_select_db($dbname);
//
//  This will save the event row.  eventNum is auto incremented in the DB, so it will be assigned for a 'new' event
//
    if ($eventNum == "new") {
      $funcSave = "Replace into events (unitId,  wkendDate,   funcDate,   roomNum,    funcType,   funcGroup, funcNumWk,   foodCheck,    barCheck,    foodBill,   barBill,   foodGrat,";
      $funcSave = $funcSave . " barGrat,  totCovers, defSetup, defClear, defExtra, numBodies, wineGrat, rateDate)";
      $funcSave = $funcSave . " values('$unitId', '$wkendDate', '$funcDate', $roomNum, $funcType, '$funcGroup', $funcNumWk, '$foodCheck', '$barCheck', $foodBill, $barBill, $foodGrat,";
      $funcSave = $funcSave . " $barGrat, $totCovers, $defSetup, $defClear, $defExtra, $numBodies, $wineGrat, '$rateDate')";
      $sqlRes = mysql_query($funcSave) or die('insert of function failed: ' . mysql_error());
    } else {
      $funcSave = "update events set wkendDate='$wkendDate', funcDate='$funcDate', roomNum=$roomNum, funcType=$funcType, funcGroup='$funcGroup', funcNumWk=$funcNumWk, foodCheck='$foodCheck',";
      $funcSave = $funcSave . " barCheck='$barCheck', foodBill=$foodBill,";
      $funcSave = $funcSave . " barBill=$barBill, foodGrat=$foodGrat, barGrat=$barGrat, totCovers=$totCovers, defSetup=$defSetup, defClear=$defClear, defExtra=$defExtra, numBodies=$numBodies,";
      $funcSave = $funcSave . " wineGrat=$wineGrat, rateDate='$rateDate' Where unitId='$unitId' and eventNum=$eventNum";
      $sqlRes = mysql_query($funcSave) or die('update of function failed: ' . mysql_error());
    }

    fwrite($myfile, "Saved Func Details.");

    // Begin by getting the eventNum for this event.  It maybe a new event, so read it from the DB.
    $funcSave = "Select e.eventNum, t.funcGroup from events e, funcTypes t";
    $funcSave = $funcSave . " where e.unitId = '$unitId' and e.wkendDate='$wkendDate' and e.funcType = '$funcType'";
    $funcSave = $funcSave . "   and t.unitId = e.unitId  and t.funcType = e.funcType  and e.funcNumWk='$funcNumWk'";
    $sqlRes = mysql_query($funcSave) or die('get func num failed: ' . mysql_error());
    $rows = mysql_num_rows($sqlRes);
    $funcNum = mysql_fetch_array($sqlRes, MYSQL_NUM);
    $eventNum  = $funcNum[0];
    $funcGroup = $funcNum[1];

// Calling the delete only fails if unit id or event number is missing, which they shouldn't be
    if (erase_function($unitId, $eventNum) != true) {
      $result = "Error: Could not erase function. (" . $unitId .")(". $eventNum .")";
    } else {
       
      $jsonGrid  = json_decode(file_get_contents('php://input'));
      $saveCnt = 0;
//
//  The grid will contain 3 different types of values, the employee grid, the gratuity types, and the body counts.
//
      foreach ($jsonGrid as $row => $jsonGridRow) {
//       foreach ($jsonGridRow as $key => $value)
//       $eventNum      = $jsonGridRow->eventNum;
        $gratType      = $jsonGridRow->gratType;
        if ($gratType != NULL) {
          $gratSeq     = $jsonGridRow->gratSeq;
          $checkNum    = $jsonGridRow->checkNum;
          $checkAmt    = $jsonGridRow->checkAmt;
          if ($checkAmt == NULL)
             $checkAmt = 0;
          $gratAmt     = $jsonGridRow->gratAmt;
          if ($gratAmt == NULL)
             $gratAmt = 0;
          $gratAddl    = $jsonGridRow->gratAddl;
          if ($gratAddl == NULL)
             $gratAddl    = 0;
          $gridSave = "Replace into funcGrats (unitId,   eventNum, gratSeq,    gratType,    checkNum,   checkAmt,  gratAmt,  gratAddl)";
          $gridSave = $gridSave .   " values('$unitId', $eventNum, $gratSeq, '$gratType', '$checkNum', $checkAmt, $gratAmt, $gratAddl)";
          $sqlRes = mysql_query($gridSave) or die("grat type insert failed for: $gratType: " . mysql_error());
        } else {
          $empSeq        = $jsonGridRow->empSeq;  //Is this an employee grid row?
          if ($empSeq != NULL) {
            $emplid        = $jsonGridRow->emplid;
            $eeType        = $jsonGridRow->eeType;
            $payGrp        = $jsonGridRow->payGrp;
            $emplClass     = $jsonGridRow->emplClass;
            $grat1Rate     = $jsonGridRow->grat1Rate;
            $grat1Group    = $jsonGridRow->grat1Group;
            $grat1Cut      = $jsonGridRow->grat1Cut;
            $grat2Rate     = $jsonGridRow->grat2Rate;
            $grat2Group    = $jsonGridRow->grat2Group;
            $grat2Cut      = $jsonGridRow->grat2Cut;
            $grat3Rate     = $jsonGridRow->grat3Rate;
            $grat3Group    = $jsonGridRow->grat3Group;
            $grat3Cut      = $jsonGridRow->grat3Cut;
            $getSetup      = $jsonGridRow->getSetup;
            $getClear      = $jsonGridRow->getClear;
            $getExtra      = $jsonGridRow->getExtra;
            $coversAllowed = $jsonGridRow->coversAllowed;
            $eeCovers      = $jsonGridRow->eeCovers;
            $eeWeight      = $jsonGridRow->eeWeight;
            $eeBaseWage    = $jsonGridRow->eeBaseWage;
            $baseWage      = $jsonGridRow->baseWage;
            $hours         = $jsonGridRow->hours;
            $setupAmt      = $jsonGridRow->setupAmt;
            $clearAmt      = $jsonGridRow->clearAmt;
            $extraAmt      = $jsonGridRow->extraAmt;
            $grat1Cut      = $jsonGridRow->grat1Cut;
            $grat2Cut      = $jsonGridRow->grat2Cut;
            $grat3Cut      = $jsonGridRow->grat3Cut;
            $totalPay      = $jsonGridRow->totalPay;
            
            if ($grat1Rate == NULL || $grat1Rate == '')
                $grat1Rate = 0;
            if ($grat1Group == NULL)
                $grat1Group = "";
            if ($grat1Cut == NULL || $grat1Cut == '')
                $grat1Cut = 0;
            if ($grat2Rate == NULL || $grat2Rate == '')
                $grat2Rate = 0;
            if ($grat2Group == NULL)
                $grat2Group = "";
            if ($grat2Cut == NULL || $grat2Cut == '')
                $grat2Cut = 0;
            if ($grat3Rate == NULL || $grat3Rate == '')
                $grat3Rate = 0;
            if ($grat3Group == NULL)
                $grat3Group = "";
            if ($grat3Cut == NULL || $grat3Cut == '')
                $grat3Cut = 0;
                
            $baseWage = ltrim(rtrim($baseWage, " "), " ");
            if ($baseWage == NULL || $baseWage == '')
                $baseWage = 0;
                
            $hours = ltrim(rtrim($hours, " "), " ");
            if ($hours == NULL || $hours == '')
                $hours = 0;
                
            $setupAmt = ltrim(rtrim($setupAmt, " "), " ");
            if ($setupAmt == NULL || $setupAmt == '')
                $setupAmt = 0;
                
            $clearAmt = ltrim(rtrim($clearAmt, " "), " ");
            if ($clearAmt == NULL || $clearAmt == '')
                $clearAmt = 0;
                
            $extraAmt = ltrim(rtrim($extraAmt, " "), " ");
              if ($extraAmt == NULL || $extraAmt == '')
                  $extraAmt = 0;
                  
            $gridSave = "Replace into funcEmps (unitId,   eventNum,  empSeq,   emplid,   eeType,   payGrp,    emplClass,   grat1Rate,   grat1Group,   grat1Cut,  grat2Rate,   grat2Group,   grat2Cut,  grat3Rate,   grat3Group,   grat3Cut, ";
            $gridSave = $gridSave .  "  getSetup,    getClear,    getExtra,   eeBaseWage,     coversAllowed,   eeCovers,  eeWeight,  baseWage,  hours,  setupAmt,  clearAmt,  extraAmt,  totalPay)";
            $gridSave = $gridSave .  " values('$unitId', $eventNum, $empSeq, '$emplid', $eeType, '$payGrp', '$emplClass', $grat1Rate, '$grat1Group', $grat1Cut, $grat2Rate, '$grat2Group', $grat2Cut, $grat3Rate, '$grat3Group', $grat3Cut, ";
            $gridSave = $gridSave .  "'$getSetup', '$getClear', '$getExtra', '$eeBaseWage', '$coversAllowed', $eeCovers, $eeWeight, $baseWage, $hours, $setupAmt, $clearAmt, $extraAmt, $totalPay)";
            $sqlRes = mysql_query($gridSave) or die("grid save failed for: $eventNum - $emplid: " . mysql_error());
            $saveCnt++;

            fwrite($myfile, "Saving " .$saveCnt. "\n ");
    
            if ($grat1Type != "X") {
               $gridSave = "Replace into funcEmpGrats (unitId,   eventNum,  empSeq,   emplid,    gratType,     groupType,   gratRate,   gratAmt)";
               $gridSave = $gridSave .      " values('$unitId', $eventNum, $empSeq, '$emplid', '$grat1Type', '$grat1Group', $grat1Rate,  $grat1Cut)";
               $sqlRes = mysql_query($gridSave) or die("grid grat1 failed for: $eventNum - $emplid: " . mysql_error());
            }
    
            if ($grat2Type != "X") {
               $gridSave = "Replace into funcEmpGrats (unitId,   eventNum,  empSeq,   emplid,    gratType,     groupType,    gratRate,   gratAmt)";
               $gridSave = $gridSave .      " values('$unitId', $eventNum, $empSeq, '$emplid', '$grat2Type', '$grat2Group', $grat2Rate, $grat2Cut)";
               $sqlRes = mysql_query($gridSave) or die("grid grat2 failed for: $eventNum - $emplid: " . mysql_error());
            }
    
            if ($grat3Type != "X") {
               $gridSave = "Replace into funcEmpGrats (unitId,   eventNum,  empSeq,   emplid,    gratType,     groupType,    gratRate,   gratAmt)";
               $gridSave = $gridSave .      " values('$unitId', $eventNum, $empSeq, '$emplid', '$grat3Type', '$grat3Group', $grat3Rate, $grat3Cut)";
               $sqlRes = mysql_query($gridSave) or die("grid grat2 failed for: $eventNum - $emplid: " . mysql_error());
            }
          } else {
            foreach ($jsonGridRow as $eeType => $cntBodies) {
              $gridSave = "Replace into funcEmpCnts (unitId,   eventNum,   eeType, numBodies)";
              $gridSave = $gridSave .      " values('$unitId', $eventNum, $eeType, $cntBodies)";
              $sqlRes = mysql_query($gridSave) or die("emp counts failed for: $eeType - $cntBodies: " . mysql_error());
              }
          }  
        }//else row type
      }  //loop
    }
  }

  fwrite($myfile, "Returning");
  fclose($myfile);

  echo '{"result":"' .$result. '","eventNum":"' .$eventNum. '","rows":"' .$saveCnt. '","eventNumIn":"' .$eventNumIn. '"}';
?>