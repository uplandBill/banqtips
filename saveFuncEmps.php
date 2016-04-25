<?php
  session_start();
  include("db.php5");

  $unitId     = $_GET['unitId'];
  $eventNum   = $_GET['eventNum'];
  $eventNumIn = $eventNum;

  if ($unitId !="" || $eventNum !="") {
     $result  = "Saved";
     
     $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
     $db_selected = mysql_select_db($dbname);
     
     $jsonData  = json_decode(file_get_contents('php://input'));
     $saveCnt = 0;
     
     foreach ($jsonData as $row => $jsonDataRow) {
//        foreach ($jsonDataRow as $key => $value)
//        $eventNum      = $jsonDataRow->eventNum;
        $gratType      = $jsonDataRow->gratType;
        $empSeq        = $jsonDataRow->empSeq;
        $emplid        = $jsonDataRow->emplid;
        $eeType        = $jsonDataRow->eeType;
        $payGrp        = $jsonDataRow->payGrp;
        $emplClass     = $jsonDataRow->emplClass;
        $grat1Rate     = $jsonDataRow->grat1Rate;
        $grat1Group    = $jsonDataRow->grat1Group;
        $grat1Cut      = $jsonDataRow->grat1Cut;
        $grat2Rate     = $jsonDataRow->grat2Rate;
        $grat2Group    = $jsonDataRow->grat2Group;
        $grat2Cut      = $jsonDataRow->grat2Cut;
        $grat3Rate     = $jsonDataRow->grat3Rate;
        $grat3Group    = $jsonDataRow->grat3Group;
        $grat3Cut      = $jsonDataRow->grat3Cut;
        $getSetup      = $jsonDataRow->getSetup;
        $getClear      = $jsonDataRow->getClear;
        $getExtra      = $jsonDataRow->getExtra;
        $coversAllowed = $jsonDataRow->coversAllowed;
        $eeCovers      = $jsonDataRow->eeCovers;
        $eeWeight      = $jsonDataRow->eeWeight;
        $eeBaseWage    = $jsonDataRow->eeBaseWage;
        $baseWage      = $jsonDataRow->baseWage;
        $hours         = $jsonDataRow->hours;
        $setupAmt      = $jsonDataRow->setupAmt;
        $clearAmt      = $jsonDataRow->clearAmt;
        $extraAmt      = $jsonDataRow->extraAmt;
        $grat1Cut      = $jsonDataRow->grat1Cut;
        $grat2Cut      = $jsonDataRow->grat2Cut;
        $grat3Cut      = $jsonDataRow->grat3Cut;
        $totalPay      = $jsonDataRow->totalPay;
        
        if ($grat1Rate == NULL)
            $grat1Rate = 0;
        if ($grat1Group == NULL)
            $grat1Group = "";
        if ($grat1Cut == NULL)
            $grat1Cut = 0;
        if ($grat2Rate == NULL)
            $grat2Rate = 0;
        if ($grat2Group == NULL)
            $grat2Group = "";
        if ($grat2Cut == NULL)
            $grat2Cut = 0;
        if ($grat3Rate == NULL || $grat3Rate == '')
            $grat3Rate = 0;
        if ($grat3Group == NULL)
            $grat3Group = "";
        if ($grat3Cut == NULL || $grat3Cut == '')
            $grat3Cut = 0;

        $gridDel = "delete from funcEmps where unitId = '$unitId' and eventNum = $eventNum and emplid = '$emplid'";
        $sqlRes = mysql_query($gridDel) or die("grid delete failed for: $unitId - $eventNum = $emplid" . mysql_error());
     
        $gratsDel = "delete from funcEmpGrats where unitId = '$unitId' and eventNum = $eventNum and emplid = '$emplid'";
        $sqlRes = mysql_query($gratsDel) or die("grats delete failed for: $unitId - $eventNum = $emplid" . mysql_error());
     
        $gridSave = "Replace into funcEmps (unitId,   eventNum,  empSeq,   emplid,   eeType,   payGrp,    emplClass,   grat1Rate,   grat1Group,   grat1Cut,  grat2Rate,   grat2Group,   grat2Cut,  grat3Rate,   grat3Group,   grat3Cut, ";
        $gridSave = $gridSave .  "  getSetup,    getClear,    getExtra,   eeBaseWage,     coversAllowed,   eeCovers,  eeWeight,  baseWage,  hours,  setupAmt,  clearAmt,  extraAmt,  totalPay)";
        $gridSave = $gridSave .  " values('$unitId', $eventNum, $empSeq, '$emplid', $eeType, '$payGrp', '$emplClass', $grat1Rate, '$grat1Group', $grat1Cut, $grat2Rate, '$grat2Group', $grat2Cut, $grat3Rate, '$grat3Group', $grat3Cut, ";
        $gridSave = $gridSave .  "'$getSetup', '$getClear', '$getExtra', '$eeBaseWage', '$coversAllowed', $eeCovers, $eeWeight, $baseWage, $hours, $setupAmt, $clearAmt, $extraAmt, $totalPay)";
        $sqlRes = mysql_query($gridSave) or die("grid save failed for: $eventNum - $emplid: " . mysql_error());
        $saveCnt++;
     
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
     }
  } else {
    $result = "ERROR:Missing Parms";
  }
  echo '{"result":"' .$result. '","eventNum":"' .$eventNum. '","rows":"' .$saveCnt. '","eventNumIn":"' .$eventNumIn. '"}';
?>