<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];
  $func   = $_GET['func'];
  $eventNum = $_GET['eventNum'];

  $currDate = date("Y-m-d");  //Current date in yyyy-mm-dd

//                     0        1             2          3          4
  $openWeek = "select 'Y', c.wkendDate, u.defGrat1, u.defGrat2, u.defGrat3 from wkendCal c, units u where c.unitId = '$unitId' and c.weekStatus='O' and u.unitId = c.unitId";
  $result = $db->query($openWeek);
  $rows = $result->num_rows;
  if ($rows > 0) {
     $wkend = $result->fetch_row();
     $wkendDate = $wkend[1];
     $defGrat1  = $wkend[2];
     $defGrat2  = $wkend[3];
     $defGrat3  = $wkend[4];
     $gratSql = "Select gratType, gratDescr from gratTypes where unitId = '$unitId'";
     $res = $db->query($gratSql);
     while ($gratDescr = $res->fetch_row()) {
        if ($gratDescr[0] == $defGrat1)
           $grat1Descr = $gratDescr[1];
        if ($gratDescr[0] == $defGrat2)
           $grat2Descr = $gratDescr[1];
        if ($gratDescr[0] == $defGrat3)
           $grat3Descr = $gratDescr[1];
         }

     $grat1 = $defGrat1;
     $grat2 = $defGrat2;
     $grat3 = $defGrat3;

     $grat1Chk   = "";
     $grat1Bill  = "";
     $grat1Grat  = 0;
     $grat1Addl  = 0;

     $grat2Chk   = "";
     $grat2Bill  = "";
     $grat2Grat  = 0;
     $grat2Addl  = 0;

     $grat3Chk   = "";
     $grat3Bill  = "";
     $grat3Grat  = 0;
     $grat3Addl  = 0;

     $editOn="N";
     if ($eventNum != '') {   //This event has been saved
      //                      0         1           2            3          4          5            6             7           8          9          10          11          12         13           14           15          16
         $getFunc = "Select f.unitId, f.eventNum, f.funcDate, f.roomNum, f.funcType, f.funcGroup, f.funcNumWk, f.foodCheck, f.barCheck, f.foodBill, f.foodGrat, f.barBill, f.barGrat, f.totCovers, f.defSetup, f.defClear, f.defExtra, rateDate from events f where f.unitId='$unitId' and f.eventNum = '$eventNum'";
         $result = $db->query($getFunc);
         $funcRec = $result->fetch_row();
         $rows = $result->num_rows;
         if ($rows > 0){
             $funcDate   = $funcRec[2];
             $roomNum    = $funcRec[3];
             $funcType   = $funcRec[4];
             $funcGroup  = $funcRec[5];
             $funcNumWk  = $funcRec[6];
             $foodCheck  = $funcRec[7];
             $barCheck   = $funcRec[8];
             $foodBill   = $funcRec[9];
             $foodGrat   = $funcRec[10];
             $barBill    = $funcRec[11];
             $barGrat    = $funcRec[12];
             $totCovers  = $funcRec[13];
             $defSetup   = $funcRec[14];
             $defClear   = $funcRec[15];
             $defExtra   = $funcRec[16];
             $rateDate   = $funcRec[17];
         }
         $grat1 = $defGrat1;
         $grat2 = $defGrat2;
         $grat3 = $defGrat3;
//                               0          1           2          3          4            5           6            7
         $getGrats = "Select g.unitId, g.eventNum, g.gratSeq, g.gratType, t.gratDescr, g.checkNum, g.checkAmt, g.gratAmt, g.gratAddl from funcGrats g, gratTypes t where g.unitId='$unitId' and g.eventNum = '$eventNum' and t.unitId = g.unitId and t.gratType = g.gratType order by g.gratSeq";
         $result = $db->query($getGrats);
         $gratHeads = "";
         while ($gratDets = $result->fetch_row()) {
             $gratSeq   = $gratDets[2];
             if ($gratSeq == 0) {
                $grat1      = $gratDets[3];
                $grat1Descr = $gratDets[4];
                $grat1Chk   = $gratDets[5];
                $grat1Bill  = $gratDets[6];
                $grat1Grat  = $gratDets[7];
                $grat1Addl  = $gratDets[8];
             }
             if ($gratSeq == 1) {
                $grat2      = $gratDets[3];
                $grat2Descr = $gratDets[4];
                $grat2Chk   = $gratDets[5];
                $grat2Bill  = $gratDets[6];
                $grat2Grat  = $gratDets[7];
                $grat2Addl  = $gratDets[8];
             }
             if ($gratSeq == 2) {
                $grat3      = $gratDets[3];
                $grat3Descr = $gratDets[4];
                $grat3Chk   = $gratDets[5];
                $grat3Bill  = $gratDets[6];
                $grat3Grat  = $gratDets[7];
                $grat3Addl  = $gratDets[8];
             }
         }
      } else {                   //non-saved function
        if ($func == "start") {
          $nextFunc = "select max(funcNumWk) from events e, wkendCal c where c.unitId = '$unitId' and c.weekStatus='O' and e.unitId = c.unitId";
          $nextFunc = $nextFunc ." and e.wkendDate = c.wkendDate";
          $result = $db->query($nextFunc);
          $rows = $result->num_rows;
          if ($rows > 0){
              $maxFunc = $result->fetch_row();
              $funcNumWk = $maxFunc[0] + 1;
           } else {
              $funcNumWk  = "1";
           }
           $eventNum   = "new";
           $editOn     = "Y";
           $funcDate   = "";
           $funcDate = date("Y-m-d");
           $roomNum    = 1;
           $funcType   = 0;
           $funcGroup  = "";

           $foodCheck  = "";
           $barCheck   = "";
           $totCovers  = "0";
           $defSetup   = "0";
           $defClear   = "0";
           $defExtra   = "0";
           $numBodies  = "0";
           $wineGrat   = "0";
//           $grat1 = $defGrat1;           $grat2 = $defGrat2;           $grat3 = $defGrat3;
          $curRateDate = "select max(effdt) from empGroups e where e.unitId = '$unitId' and e.effdt < '$currDate'";
          $result = $db->query($curRateDate);
          $rows = $result->fetch_row();
          $rateDate = $rows[0];
//          echo "Curr Date: " .$currDate ."  Rate Date:" . $rateDate;
        }
     }

     echo "<div class='funcForm' id='funcForm'>";
     echo "<div class='statusResult' id='statusResult'></div>";

     echo "<div class='offscreen' id='hiddenData'>";
     $getSql = "";
     $getSQL = $getSQL ."Select w.unitId, w.funcType, w.emplClass, w.baseWage from baseWages w";
     $getSQL = $getSQL ." where w.unitId='$unitId' and w.funcType = $funcType";
     $getSQL = $getSQL ." and w.effdt = (select max(effdt) from baseWages w2 where w2.unitId = w.unitId and w2.funcType = w.funcType and w2.effdt <= '$funcDate')";
     $getSQL = $getSQL ." order by emplClass";
     $result = $db->query($getSQL);
     $rows = $result->num_rows;
     while ($recs = $result->fetch_row()) {
      echo "<div id='empClass$recs[2]'>$recs[3]</div>";
     }
     echo "<div id='empClass'>0</div></div>";

     echo "<div class='offscreen' id='hiddenData2'>";

     echo "<div id='unitData'>";
     $topArr = array();
     //                     0         1        2          3            4
     $getSQL = "Select u.unitName, wkendDay, u.ecMeth, useBodies from units u where u.unitId='$unitId'";
     $result = $db->query($getSQL);
     $rows = $result->num_rows;
     while ($recs = $result->fetch_row()) {
      $unitName   = $recs[0];
      $wkendDay   = $recs[1];
      $ecMeth     = $recs[2];
      $useBodies  = $recs[3];
      $arrLine       = compact("unitName", "wkendDay", "ecMeth", "useBodies");

      $topArr[$unitId]=$arrLine;
        }
     echo json_encode($topArr);
     echo "</div>";

     echo "<div id='cutGroups'>";
     $topArr = array();
     //                      0            1            2
     $getSQL = "Select g.groupType, g.groupDescr, g.isBodies from cutGroups g where g.unitId='$unitId'";
     $result = $db->query($getSQL);
     $rows = $result->num_rows;
     while ($recs = $result->fetch_row()) {
        $groupType  = $recs[0];
        $groupDescr = $recs[1];
        $isBodies   = $recs[2];
        $arrLine       = compact("groupDescr", "isBodies");
        $topArr[$groupType]=$arrLine;
     }

     echo json_encode($topArr);
     echo "</div>";

     echo "<div id='empTypeOpts'>";
     $topArr = array();
     $bodiesCnt = 0;
     $bodsArr = array();
     $bodiesTab = "<table id='bodiesTab'>";
     //                    0            1            2             3            4               5           6            7           8           9          10
     $getSQL = "Select t.eeType, t.eeTypedescr, t.eeTypePlr, t.eeBaseWage, t.coversAllowed, t.defHours, t.getSetup, t.getClear, t.getExtra, t.autoLoad, t.cntBodies";
     $getSQL = $getSQL ." from employeeTypes t where t.unitId='$unitId' order by t.eeTypeDescr";
     $result = $db->query($getSQL);
     $rows = $result->num_rows;
     while ($recs = $result->fetch_row()) {
        $eeType          = $recs[0];
        $eeTypeDescr     = $recs[1];
        $eeTypePlr       = $recs[2];
        $eeBaseWage      = $recs[3];
        $coversAllowed   = $recs[4];
        $defHours        = $recs[5];
        $getSetup        = $recs[6];
        $getClear        = $recs[7];
        $getExtra        = $recs[8];
        $autoLoad        = $recs[9];
        $cntBodies       = $recs[10];
        $arrLine       = compact("eeTypeDescr","eeTypePlr","eeBaseWage","coversAllowed","defHours", "getSetup", "getClear", "getExtra", "autoLoad","cntBodies");

        $topArr[$recs[0]]=$arrLine;

        if ($cntBodies != "N") {
           if ($eventNum == "new") {
              $sortord = $cntBodies;
           } else {
              $bodsSQL = "Select numBodies from funcEmpCnts where unitId='$unitId' and eventNum = $eventNum and eeType = $eeType";
              $bodsRes = $db->query($bodsSQL);
              $bodsRec = $bodsRes->fetch_row();
              $numBodies  = $bodsRec[0];
              $sortord    = $bodsRec[0];
           }
           if ($numBodies == NULL)
              $numBodies = 0;

           $bodiesCnt++;
           $bodiesTR = "<tr sortord='$sortord'><td>$eeTypeDescr</td><td>";
           $bodiesTR = $bodiesTR . "<input type='text' class='numfld' size = '4' id='bodies$bodiesCnt' eetype='$recs[0]'   value='$numBodies'/>";
           $bodiesTR = $bodiesTR . "</td></tr>";
           $bodsArr[$bodiesCnt] = $bodiesTR;
//           $bodiesTab = $bodiesTab . $bodiesTR;
        }
     }
     echo json_encode($topArr);
     echo "</div>";

     sort($bodsArr);                                    //Sorts in ascending order
     for ($i=count($bodsArr) - 1; $i>-1 ; $i--) {       //Presents in reverse order
        $bodiesTab = $bodiesTab . $bodsArr[$i];
     }

     $bodiesTab = $bodiesTab . "</table>";

     echo "<div id='gratTypes'>";
     $topArr = array();
     //                    0         1            2           3          4           5
     $getSQL = "Select g.eeType, g.gratType, g.groupType, g.cutRate, g.netAcct, t.gratDescr from empGroups g, gratTypes t";
     $getSQL = $getSQL ." where g.unitId='$unitId' and g.effdt = '$rateDate' and t.unitId = g.unitId and t.gratType = g.gratType order by g.eeType, t.dispOrder";
     $result = $db->query($getSQL) or die('Get groups types data failed: ' . mysql_error());
     $rows = $result-num_rows;
     $row = 0;
     while ($recs = $result->fetch_row()) {
        $eeType          = $recs[0];
        $gratType        = $recs[1];
        $groupType       = $recs[2];
        $cutRate         = $recs[3];
        $netAcct         = $recs[4];
        $gratDescr       = $recs[5];
        $arrLine       = compact("eeType","gratType","groupType","cutRate","netAcct","gratDescr");
        $row++;

        $topArr[$row]=$arrLine;
     }
     echo json_encode($topArr);
     echo "</div>";

     echo "<div id='payGrps'>";
     $topArr = array();
     //                   0         1          2             3            4             5
     $getSQL = "Select g.payGrp, g.effdt, g.effStatus, g.payGrpDescr, g.emplClass, g.defHours from payGrp g where unitId='$unitId' and g.effdt = (select max(effdt) from payGrp g2 where g.unitId = g.unitId and g2.payGrp = g.payGrp) order by payGrp";
     $result = $db->query($getSQL);
     $rows = $result->num_rows;
     while ($recs = $result->fetch_row()) {
       $effStatus    = $recs[2];
       $payGrpDescr  = $recs[3];
       $emplClass    = $recs[4];
       $defHours     = $recs[5];
       $arrLine       = compact("payGrpDescr", "emplClass", "defHours");

       $topArr[$recs[0]]=$arrLine;
     }
     echo json_encode($topArr);
     echo "</div>";

     $topArr = array();
     echo "<div id='calcComp'>";
//                        0         1       2          3
     $getSQL = "Select funcType, eeType, gratType, calcMeth from calcComps  where unitId='$unitId' order by funcType, eeType, gratType";
     $result = $db->query($getSQL);
     $rows = $result->num_rows;
     $prevFuncType="";
     $prevEeType="";
     while ($recs = $result->fetch_row()) {
        $funcType1        = $recs[0];
        if ($prevFuncType == "")
           $prevFuncType = $funcType1;

        $eeType          = $recs[1];
        if ($prevEeType == "")
           $prevEeType = $eeType;

        $gratType        = $recs[2];
        if ($prevGratType == "")
           $prevGratType = $gratType;


        if ($prevEeType <> $eeType) {
           $eeLine[$prevEeType]=$gratLine;
           $gratLine = array();
        }

        if ($prevFuncType <> $funcType1) {
           $topArr[$prevFuncType]=$eeLine;
           $eeLine = array();
        }

        $calcMeth    = $recs[3];
        $methLine    = compact("calcMeth");
        $gratLine[$gratType] = $methLine;

        $prevEeType=$eeType;
        $prevFuncType=$funcType1;
        $prevGratType=$gratType;
     }
     $eeLine[$prevEeType]=$gratLine;
     $topArr[$prevFuncType]=$eeLine;
     echo json_encode($topArr);
     echo "</div></div>";
     echo "<div class='offscreen' id='hiddenData3'></div>";

//   Start of Form

     echo '<form id="enterFunc" name="enterFunc">';
     echo '<table class="funcTable">';

     if ($func == "entered") {
        $editOn="Y";
        $funcDate   = $_POST[funcDate];
        $roomNum    = $_POST[roomNum];
        $funcType   = $_POST[funcType];
        $funcGroup  = $_POST[funcGroup];
        $funcNumWk  = $_POST[funcNumWk];
        $foodCheck  = $_POST[foodCheck];
        $foodBill   = $_POST[foodBill];
        $foodGrat   = $_POST[foodGrat];
        $barCheck   = $_POST[barCheck];
        $barBill    = $_POST[barBill];
        $barGrat    = $_POST[barGrat];
        $totCovers  = $_POST[totCovers];
        $defSetup   = $_POST[defSetup];
        $defClear   = $_POST[defClear];
        $defExtra   = $_POST[defExtra];
     }

     if ($editOn = "Y") {
        echo "<tr>";
        echo "<td class='funcFormCol1'>Function Date   </td>";
        echo "<td class='funcFormCol2'><input type='text' size = '10' name='funcDate'    id='funcDate'    value='$funcDate' class='tcal tcalInput'/></td>";
        echo "<td class='funcFormCol3' id='unitId'>Unit: $unitId </td>";
        echo "<td class='funcFormCol4' id='wkendDate'>Weekending: $wkendDate</td>";
        echo "<td id='eventNum' class='hidden'>$eventNum</td>";
        echo "<td class='hidden'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='funcFormCol1'>Function Type   </td>";
        echo "<td class='funcFormCol2'><select type='text' name='funcType'    id='funcType'    value=$funcType>";
        $getFuncs = "Select t.funcType, t.funcDescr, t.defCovers from funcTypes t where t.unitId = '$unitId'";
        $result = $db->query($getFuncs);
        while ($func = $result->fetch_row())
          if ($funcType == $func[0]) {
             $defCovers = $func[2];
             echo  "<option selected='selected' covers='$defCovers' value=$func[0]>$func[1]</option>";
             }
          else
             echo  "<option value=$func[0] covers='$func[2]'>$func[1]</option>";
        echo "</select></td>";

        echo "<td class='funcFormCol3'>Group</td>";
        echo "<td class='funcFormCol4'><input type='text' class='textFld' size = '25' name='funcGroup'   id='funcGroup'   value='$funcGroup'/> </td>";
        echo "<td class='funcFormCol5'></td>";
        echo "<td class='funcFormCol6'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='funcFormCol1'>Room            </td>";
        echo "<td class='funcFormCol2'><select name='roomNum'     id='roomNum' value=$roomNum>   ";
        $getRooms = "Select roomNum, roomDescr from rooms where unitId = '$unitId' order by roomDescr";
        $result = $db->query($getRooms);
        while ($room = $result->fetch_row())
          if ($roomNum == $room[0])
              echo  "<option selected='selected' value=$room[0]>$room[1]</option>";
          else
              echo  "<option value=$room[0]>$room[1]</option>";
        echo "</select></td>";

        echo "<td class='funcFormCol3'>Default Covers</td>";
        echo "<td class='funcFormCol4'><div id='defCovers'>$defCovers</td>";
        if ($useBodies == "Y") {
           echo "<td class='funcFormCol5'></td>";
           echo "<td class='funcFormCol6'></td>";
        } else {
           echo "<td class='funcFormCol5'></td>";
           echo "<td class='funcFormCol6'></td>";
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td class='funcFormCol1'>Function Num</td>";
        echo "<td class='funcFormCol2'><input type='text' class='numfld'  size = '3'  name='funcNumWk'  id='funcNumWk'  value='$funcNumWk'/> </td>";
        echo "<td class='funcFormCol3'>Total Covers</td>";
        echo "<td class='funcFormCol4'><input type='text' class='numfld' size = '5' name='totCovers'   id='totCovers'   value='$totCovers'/></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "</tr>";
        echo "</table>";

        echo "<table id='gratsGrid'>";

        echo "<tr>";
        echo "<td class='funcFormColx1'>";
        echo "<select name='grat1' id='grat1' value=$grat1>";
        $getList = "Select gratType, gratDescr from gratTypes where unitId = '$unitId' order by dispOrder";
        $result = $db->query($getList);
        while ($listRec = $result->fetch_row())
          if ($grat1 == $listRec[0])
              echo  "<option selected='selected' value=$listRec[0] gtd='$listRec[1]'>$listRec[1]</option>";
          else
              echo  "<option value=$listRec[0] gtd='$listRec[1]'>$listRec[1]</option>";
        echo "</select></td>";
        echo "<td class='numfld funcFormColx3'>Chk#</td>";
        echo "<td class='funcFormColx2'><input type='text' class='textfld' size = '10'  id='grat1Chk'  value='$grat1Chk'/> </td>";
        echo "<td class='numfld funcFormColx3'>Bill</td>";
        echo "<td class='funcFormColx4'><input type='text' class='numfld'  size = '8'   id='grat1Bill' value='$grat1Bill'/> </td>";
        echo "<td class='numfld funcFormColx5'>Gratuity</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld'  size = '7'   id='grat1Grat' value='$grat1Grat'/> </td>";
        echo "<td class='numfld funcFormColx5'>Addl</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld'  size = '7'   id='grat1Addl' value='$grat1Addl'/> </td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='funcFormColx1'>";
        echo "<select name='grat2' id='grat2' value=$grat2>";
        $getList = "Select gratType, gratDescr from gratTypes where unitId = '$unitId' order by dispOrder";
        $result = $db->query($getList);
        while ($listRec = $result->fetch_row())
          if ($grat2 == $listRec[0])
              echo  "<option selected='selected' value=$listRec[0] gtd='$listRec[1]'>$listRec[1]</option>";
          else
              echo  "<option value=$listRec[0] gtd='$listRec[1]'>$listRec[1]</option>";
        echo "</select></td>";
        echo "<td class='numfld funcFormColx3'>Chk#</td>";
        echo "<td class='funcFormColx2'><input type='text' class='textfld' size = '10'  id='grat2Chk'  value='$grat2Chk'/> </td>";
        echo "<td class='numfld funcFormColx3'>Bill</td>";
        echo "<td class='funcFormColx4'><input type='text' class='numfld'  size = '8'   id='grat2Bill' value='$grat2Bill'/> </td>";
        echo "<td class='numfld funcFormColx5'>Gratuity</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld'  size = '7'   id='grat2Grat' value='$grat2Grat'/> </td>";
        echo "<td class='numfld funcFormColx5'>Addl</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld'  size = '7'   id='grat2Addl' value='$grat2Addl'/> </td>";
        echo "</tr>";

        echo "<tr>";
//        echo "<td class='xx'><input type='checkbox' name='useGrat3' value='N'/></td>";
        echo "<td class='funcFormColx1'>";
        echo "<select name='grat3' id='grat3' value=$grat3>";
        $getList = "Select gratType, gratDescr from gratTypes where unitId = '$unitId' order by dispOrder";
        $result = $db->query($getList);
        while ($listRec = $result->fetch_row())
          if ($grat3 == $listRec[0])
              echo  "<option selected='selected' value=$listRec[0] gtd='$listRec[1]'>$listRec[1]</option>";
          else
              echo  "<option value=$listRec[0] gtd='$listRec[1]'>$listRec[1]</option>";
        echo "</select></td>";
        echo "<td class='numfld funcFormColx3'>Chk#</td>";
        echo "<td class='funcFormColx2'><input type='text' class='textfld' size = '10'  id='grat3Chk'  value='$grat3Chk'/> </td>";
        echo "<td class='numfld funcFormColx3'>Bill</td>";
        echo "<td class='funcFormColx4'><input type='text' class='numfld'  size = '8'   id='grat3Bill' value='$grat3Bill'/> </td>";
        echo "<td class='numfld funcFormColx5'>Gratuity</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld'  size = '7'   id='grat3Grat' value='$grat3Grat'/> </td>";
        echo "<td class='numfld funcFormColx5'>Addl</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld'  size = '7'   id='grat3Addl' value='$grat3Addl'/> </td>";
        echo "</tr>";
        echo "</table>";

        echo "<table id='setDefaults'>";

        echo "<tr><td colspan=3>Rate Date<select id='rateDate'>";
        $getList = "Select distinct effdt from empGroups where unitId = '$unitId' order by effdt";
        $result = $db->query($getList);
        while ($listRec = $result->fetch_row())
          if ($rateDate == $listRec[0])
              echo  "<option selected='selected' value=$listRec[0] >$listRec[0]</option>";
          else
              echo  "<option value=$listRec[0]>$listRec[0]</option>";
        echo "</select></td></tr>";

        echo "<tr>";
        echo "<td class='funcFormColx1'>Def Setup </td>";
        echo "<td class='funcFormColx2'><input type='text' class='numfld' size = '6' name='defSetup'    id='defSetup'    value='$defSetup'/>   </td>";
        echo "<td class='funcFormColx3'>Def Clear</td>";
        echo "<td class='funcFormColx4'><input type='text' class='numfld' size = '6' name='defClear'    id='defClear'    value='$defClear'/>   </td>";
        echo "<td class='funcFormColx5'>Def Extra</td>";
        echo "<td class='funcFormColx6'><input type='text' class='numfld' size = '6' name='defExtra'    id='defExtra'    value='$defExtra'/>   </td>";
        echo "</tr>";
        echo "</table>";
        echo $bodiesTab;
        echo "</form>";

//  End of function form.

        echo "<table class='buttons' id ='buttons'>";
        echo '<tr>';
        echo '<td><input value="Save this Function" type="button" onclick=' . "'javascript:saveGrid();" . "'/></td>";
        echo '<td><input value="Report" type="button" onclick=' . "'javascript:func_report();" . "'/></td>";
        echo "<td>&nbsp;-&nbsp;</td>";
        $getAddButtons = "Select eeType, eeTypeDescr From employeeTypes Where unitId = '$unitId' and addButton = 'Y'";
        $result = $db->query($getAddButtons);
        while ($eeTypes = $result->fetch_row()) {
//            echo '<td><form name = "add' . $eeTypes[0] . '" >';
            echo '<td>';
            echo '<input type="button" value="Add ' .$eeTypes[1]. '" onclick="add_eeTypes(' . "'$eeTypes[1]'". ');">';
//            echo "</form>";
            echo "</td>";
        }
        echo "<td>&nbsp;-&nbsp;</td>";
        $nextFunc = "Select max(funcNumWk) from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk < $funcNumWk";
        $sqlRes = $db->query($nextFunc);
        $rec1 = $sqlRes->fetch_row();
        $nextFuncNum = $rec1[0];
        if ($nextFuncNum <> "") {
           $nextFunc = "Select eventNum from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk = $nextFuncNum";
           $sqlRes = $db->query($nextFunc);
           $rec1 = $sqlRes->fetch_row();
           $prevEvent = $rec1[0];
           echo '<td><input value="Prev Func(' .$nextFuncNum. ')" type="button" onclick="' . "javascript:loadFunc2('$unitId',$prevEvent);" . '"/></td>';
        }

        $nextFunc = "Select min(funcNumWk) from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk > $funcNumWk";
        $sqlRes = $db->query($nextFunc);
        $rec1 = $sqlRes->fetch_row();
        $nextFuncNum = $rec1[0];
        if ($nextFuncNum == "")
           $nextFuncNum = 1;
        $nextFunc = "Select eventNum from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk = $nextFuncNum";
        $sqlRes = $db->query($nextFunc);
        $rec1 = $sqlRes->fetch_row();
        $prevEvent = $rec1[0];
        echo '<td><input value="Next Func(' .$nextFuncNum. ')" type="button" onclick="' . "javascript:loadFunc2('$unitId',$prevEvent);" . '"/></td>';
        echo '</tr></table>';
        echo "</div>";

//        echo "<div class='empGridFrame'>";
        echo "<div class='empGrid'>";
        echo "<table class='empGridTab' id='empGridTab'>";
        echo "<tbody class='empGridHead' id='empGridHead'>";
        echo "<tr><th class='w1'>Row</th><th class='w2'>Emplid</th><th class='w3'>Employee</th><th class='w8'>Role</th>";
        if ($grat1 == "X")
           echo "<th class='wx7 hidecell'>Grat1</th>";
        else
           echo "<td class='wx7'>Grat1</td>";
        if ($grat2 == "X")
           echo "<th class='wx7 hidecell'>Grat2</th>";
        else
           echo "<td class='wx7'>Grat2</td>";
        if ($grat3 == "X")
           echo "<th class='wx7 hidecell'>Grat3</th>";
        else
           echo "<td class='wx7'>Grat3</td>";
        echo "<th class='w5'>Covers</th><th class='w5'>WT</th><th class='w6'>Base</th><th class='w5'>Hrs</th><th class='w5'>Setup</th><th class='w5'>Clear</th><th class='w5'>Extra</th>";
        if ($grat1 == "X")
           echo "<th class='w6 hidecell'>$grat1Descr</th>";
        else
           echo "<th class='w6'>$grat1Descr</th>";
        if ($grat2 == "X")
           echo "<th class='w6 hidecell'>$grat2Descr</th>";
        else
           echo "<th class='w6'>$grat2Descr</th>";
        if ($grat3 == "X")
           echo "<th class='w6 hidecell'>$grat3Descr</th>";
        else
           echo "<th class='w6'>$grat3Descr</th>";
        echo "<th class='w6'>Total</th><th>&nbsp;&nbsp;</th></tr>";
        echo "</tbody>";
        echo "<tbody id='empGridBody'></tbody>";
//        echo "<tbody id='empGridTot'>";
//        echo "<tr><td></td><td></td><td></td><td></td><td></td><td>Totals</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
//        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        echo "<table class='empGridTots' id ='empGridTots'>";
        echo "<tr class='gridTotsRow'>";
        echo "<td class='w1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";                      //0
        echo "<td class='w2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";                 //1
        echo "<td class='w3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";   //2
        echo "<td class='w4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";                //3
        echo "<td class='w3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Totals</td>";                   //4
        echo "<td class='w1' id='gridEmpCnt'><input type='text' class='numfld' size='5'></input></td>";   //5
        echo "<td class='w5'><input type='text' class='numfld' size='3' readonly/></td>";     //Covers   6
        echo "<td class='w5'><input type='text' class='numfld' size='3' readonly/></td>";     //Weight   7
        echo "<td class='w6'><input type='text' class='numfld' size='5' readonly/></td>";     //Base     8
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Hours    9
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Setup   10
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Clear   11
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Extra   12
        if ($grat1 == "X")
           echo "<td class='w6 hidecell'><input type='text' class='numfld' size='7' readonly/></td>";     //Food    13
        else
           echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Food    13
        if ($grat2 == "X")
           echo "<td class='w6 hidecell'><input type='text' class='numfld' size='7' readonly/></td>";     //Bar     14
        else
           echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Bar     14
        if ($grat3 == "X")
           echo "<td class='w6 hidecell'><input type='text' class='numfld' size='7' readonly/></td>";     //Wine    15
        else
           echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Wine    15
        echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Total   16
        echo "</tr>";
        echo "</table>";

//        echo "</div>";
     }
       echo "Form is read-only";
       echo "</div>";
       echo "<div class='empCounts' id='empCounts'><table id='tabEmpCnts'></table></div>";

  } else {
    echo "No Week is currently open for processing.  Start the new week, then enter the new function.";
  }
?>
