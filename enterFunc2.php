<?php
  session_start();
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $unitId = $_GET['unitId'];
  $func   = $_GET['func'];
  $eventNum = $_GET['eventNum'];

  $openWeek = "select 'Y', wkendDate from wkendCal where unitId = '$unitId' and weekStatus='O'";
  $result = mysql_query($openWeek) or die('select open week failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  if ($rows > 0) {
     $wkend = mysql_fetch_array($result, MYSQL_NUM);
     $wkendDate = $wkend[1];

     $editOn="N";
     if ($eventNum != '') {
     	//                      0         1           2            3          4          5            6             7           8          9          10          11          12         13           14           15          16          17          18
         $getFunc = "Select f.unitId, f.eventNum, f.funcDate, f.roomNum, f.funcType, f.funcGroup, f.funcNumWk, f.foodCheck, f.barCheck, f.foodBill, f.foodGrat, f.barBill, f.barGrat, f.totCovers, f.defSetup, f.defClear, f.defExtra, f.numBodies, f.wineGrat from events f where f.unitId='$unitId' and f.eventNum = '$eventNum'";
         $result = mysql_query($getFunc) or die('error getting next func number: ' . mysql_error());
         $funcRec = mysql_fetch_array($result, MYSQL_NUM);
         $rows = mysql_num_rows($result);
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
             $numBodies  = $funcRec[17];
             $wineGrat   = $funcRec[18];
         }
      } else {
        if ($func == "start") {
          $nextFunc = "select max(funcNumWk) from events e, wkendCal c where c.unitId = '$unitId' and c.weekStatus='O' and e.unitId = c.unitId and e.wkendDate = c.wkendDate";
          $result = mysql_query($nextFunc) or die('error getting next func number: ' . mysql_error());
          $rows = mysql_num_rows($result);
          if ($rows > 0){
              $maxFunc = mysql_fetch_array($result, MYSQL_NUM);
              $funcNumWk = $maxFunc[0] + 1;
           } else {
              $funcNumWk  = "1";
           }
           $eventNum   = "new";
           $editOn     = "Y";
           $funcDate   = "";
           $roomNum    = 1;
           $funcType   = 1;
           $funcGroup  = "";
           $foodCheck  = "";
           $barCheck   = "";
           $totCovers  = "0";
           $defSetup   = "0";
           $defClear   = "0";
           $defExtra   = "0";
           $numBodies  = "0";
           $wineGrat   = "0";
        }
     }

     echo "<div class='funcForm' id='funcForm'>";
     echo "<div class='statusResult' id='statusResult'></div>";

     echo "<div class='offscreen' id='hiddenData'>";
     $getSQL = "Select w.unitId, w.funcType, w.emplClass, w.baseWage from baseWages w where w.unitId='$unitId' and w.funcType = $funcType and w.effdt = (select max(effdt) from baseWages w2 where w2.unitId = w.unitId and w2.funcType = w.funcType and w2.effdt <= '$wkendDate') order by emplClass";
     $result = mysql_query($getSQL) or die('select emp event data failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
     	echo "<div id='empClass$recs[2]'>$recs[3]</div>";
     }
     echo "<div id='empClass'>0</div></div>";

     echo "<div class='offscreen' id='hiddenData2'>";

     echo "<div id='unitData'>";
     $topArr = array();
     //                     0         1        2          3            4
     $getSQL = "Select u.unitName, wkendDay, u.ecMeth, useBodies from units u where u.unitId='$unitId'";
     $result = mysql_query($getSQL) or die('Get unit data failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
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
     $result = mysql_query($getSQL) or die('Get unit data failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
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
     //                   0        1           2             3            4          5            6          7        8          9             10        11          12        13        14        15         16
     $getSQL = "Select eeType, eeTypedescr, eeBaseWage, foodTipPercent, foodNet, foodGroup, barTipPercent, barNet, barGroup, coversAllowed, defHours, compMethod, getSetup, getClear, getExtra, emplClass, autoLoad from employeeTypes  where unitId='$unitId' order by eeTypeDescr";
     $result = mysql_query($getSQL) or die('Get emp types data failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
 	$eeTypeDescr     = $recs[1];
	$eeBaseWage      = $recs[2];
	$foodTipPercent  = $recs[3];
	$foodNet         = $recs[4];
	$foodGroup       = $recs[5];
	$barTipPercent   = $recs[6];
	$barNet          = $recs[7];
	$barGroup        = $recs[8];
	$coversAllowed   = $recs[9];
	$defHours        = $recs[10];
	$compMethod      = $recs[11];
	$getSetup        = $recs[12];
	$getClear        = $recs[13];
	$getExtra        = $recs[14];
	$emplClass       = $recs[15];
	$autoLoad        = $recs[16];
	$arrLine       = compact("eeTypeDescr","eeBaseWage","foodTipPercent","foodNet","foodGroup","barTipPercent","barNet","barGroup","coversAllowed","defHours", "compMethod", "getSetup", "getClear", "getExtra", "emplClass", "autoLoad" );

     	$topArr[$recs[0]]=$arrLine;

     }
     echo json_encode($topArr);
     echo "</div>";

     echo "<div id='payGrps'>";
     $topArr = array();
     //                   0         1          2             3            4   
     $getSQL = "Select g.payGrp, g.effdt, g.effStatus, g.payGrpDescr, g.emplClass from payGrp g where unitId='$unitId' and g.effdt = (select max(effdt) from payGrp g2 where g.unitId = g.unitId and g2.payGrp = g.payGrp) order by payGrp";
     $result = mysql_query($getSQL) or die('Get pay groups data failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$effStatus    = $recs[2];
	$payGrpDescr  = $recs[3];
	$emplClass    = $recs[4];
	$arrLine       = compact("payGrpDescr", "emplClass");

     	$topArr[$recs[0]]=$arrLine;

     }
     echo json_encode($topArr);
     echo "</div>";

     $topArr = array();
     echo "<div id='calcComp'>";
     $getSQL = "Select funcType, eeType, foodMeth, barMeth from calcComps  where unitId='$unitId' order by funcType, eeType";
     $result = mysql_query($getSQL) or die('Get emp types data failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     $prevFuncType="";
     $prevEeType="";
     while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$funcType1        = $recs[0];
	if ($prevFuncType == "")
	   $prevFuncType = $funcType1;

        if ($prevFuncType <> $funcType1) {
           $topArr[$prevFuncType]=$eeLine;
           $eeLine = array();
        }

	$eeType          = $recs[1];
	if ($prevEeType == "") {
	   $preveeType = $eeType;
	   $eeLine = array();
	}

	$foodMeth   = $recs[2];
	$barMeth    = $recs[3];
        $methLine     = compact("foodMeth", "barMeth" );
        $eeLine[$eeType] = $methLine;

     	$prevEeType=$eeType;
     	$prevFuncType=$funcType1;
     }
     $topArr[$prevFuncType]=$eeLine;
     echo json_encode($topArr);
     echo "</div></div>";
     echo "<div class='offscreen' id='hiddenData3'></div>";
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
        $numBodies  = $_POST[numBodies];
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
        $result = mysql_query($getFuncs) or die('could not get functions: ' . mysql_error());
        while ($func = mysql_fetch_array($result, MYSQL_NUM))
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
        $result = mysql_query($getRooms) or die('could not get rooms: ' . mysql_error());
        while ($room = mysql_fetch_array($result, MYSQL_NUM))
          if ($roomNum == $room[0])
              echo  "<option selected='selected' value=$room[0]>$room[1]</option>";
          else
              echo  "<option value=$room[0]>$room[1]</option>";
        echo "</select></td>";

        echo "<td class='funcFormCol3'>Default Covers</td>";
        echo "<td class='funcFormCol4'><div id='defCovers'>$defCovers</td>";
        if ($useBodies == "Y") {
           echo "<td class='funcFormCol5'>Bodies Count</td>";
           echo "<td class='funcFormCol6'><input type='text' class='numfld'  size = '3'  name='numBodies'  id='numBodies'  value='$numBodies'/></td>";
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
        echo "<td class='funcFormCol5'>Wine Gratuity</td>";
        echo "<td class='funcFormCol6'><input type='text' class='numfld' size = '5' name='wineGrat'   id='wineGrat'   value='$wineGrat'/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='funcFormCol1'>Food Check#</td>";
        echo "<td class='funcFormCol2'><input type='text' class='textfld' size = '10' name='foodCheck' id='foodCheck' value='$foodCheck'/> </td>";
        echo "<td class='funcFormCol3'>Food Bill</td>";
        echo "<td class='funcFormCol4'><input type='text' class='numfld'  size = '10' name='foodBill'  id='foodBill'  value='$foodBill'/> </td>";
        echo "<td class='funcFormCol5'>Food Gratuity</td>";
        echo "<td class='funcFormCol6'><input type='text' class='numfld'  size = '9' name='foodGrat'  id='foodGrat'  value='$foodGrat'/> </td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='funcFormCol1'>Bar Check#</td>";
        echo "<td class='funcFormCol2'><input type='text' class='textfld' size = '10' name='barCheck'  id='barCheck'  value='$barCheck'> </td>";
        echo "<td class='funcFormCol3'>Bar Bill</td>";
        echo "<td class='funcFormCol4'><input type='text' class='numfld'  size = '10' name='barBill'   id='barBill'   value='$barBill'/> </td>";
        echo "<td class='funcFormCol5'>Bar Gratuity</td>";
        echo "<td class='funcFormCol6'><input type='text' class='numfld'  size = '9' name='barGrat'   id='barGrat'   value='$barGrat'/> </td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='funcFormCol1'>Default Setup </td>";
        echo "<td class='funcFormCol2'><input type='text' class='numfld' size = '10' name='defSetup'    id='defSetup'    value='$defSetup'/>   </td>";
        echo "<td class='funcFormCol3'>Default Clear</td>";
        echo "<td class='funcFormCol4'><input type='text' class='numfld' size = '10' name='defClear'    id='defClear'    value='$defClear'/>   </td>";
        echo "<td class='funcFormCol5'>Default Extra</td>";
        echo "<td class='funcFormCol6'><input type='text' class='numfld' size = '9' name='defExtra'    id='defExtra'    value='$defExtra'/>   </td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";

        echo "<table class='buttons' id ='buttons'>";
        echo '<tr>';
        echo '<td><input value="Save this Function" type="button" onclick=' . "'javascript:saveGrid();" . "'/></td>";
        echo '<td><input value="Report" type="button" onclick=' . "'javascript:func_report();" . "'/></td>";
        echo "<td>&nbsp;-&nbsp;</td>";
        $getAddButtons = "Select eeType, eeTypeDescr From employeeTypes Where unitId = '$unitId' and addButton = 'Y'";
        $result = mysql_query($getAddButtons) or die('get add buttons failed: ' . mysql_error());
        while ($eeTypes = mysql_fetch_array($result, MYSQL_NUM)) {
//            echo '<td><form name = "add' . $eeTypes[0] . '" >';
            echo '<td>';
            echo '<input type="button" value="Add ' .$eeTypes[1]. '" onclick="add_eeTypes(' . "'$eeTypes[1]'". ');">';
//            echo "</form>";
            echo "</td>";
        }
        echo "<td>&nbsp;-&nbsp;</td>";
        $nextFunc = "Select max(funcNumWk) from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk < $funcNumWk";
        $sqlRes = mysql_query($nextFunc) or die('get prev func failed: ' . mysql_error());
        $rec1 = mysql_fetch_array($sqlRes, MYSQL_NUM);
        $nextFuncNum = $rec1[0];
        if ($nextFuncNum <> "") {
           $nextFunc = "Select eventNum from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk = $nextFuncNum";
           $sqlRes = mysql_query($nextFunc) or die('get prev event failed: ' . mysql_error());
           $rec1 = mysql_fetch_array($sqlRes, MYSQL_NUM);
           $prevEvent = $rec1[0];
           echo '<td><input value="Prev Func(' .$nextFuncNum. ')" type="button" onclick="' . "javascript:loadFunc2('$unitId',$prevEvent);" . '"/></td>';
        }

        $nextFunc = "Select min(funcNumWk) from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk > $funcNumWk";
        $sqlRes = mysql_query($nextFunc) or die('get prev func failed: ' . mysql_error());
        $rec1 = mysql_fetch_array($sqlRes, MYSQL_NUM);
        $nextFuncNum = $rec1[0];
        if ($nextFuncNum == "")
           $nextFuncNum = 1;
        $nextFunc = "Select eventNum from events e Where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' and e.funcNumWk = $nextFuncNum";
        $sqlRes = mysql_query($nextFunc) or die('get prev event failed: ' . mysql_error());
        $rec1 = mysql_fetch_array($sqlRes, MYSQL_NUM);
        $prevEvent = $rec1[0];
        echo '<td><input value="Next Func(' .$nextFuncNum. ')" type="button" onclick="' . "javascript:loadFunc2('$unitId',$prevEvent);" . '"/></td>';
        echo '</tr></table>';
        echo "</div>";

//        echo "<div class='empGridFrame'>";
        echo "<div class='empGrid'>";
        echo "<table class='empGridTab' id='empGridTab'>";
        echo "<tbody class='empGridHead' id='empGridHead'>";
        echo "<tr><th class='w1'>Row</th><th class='w2'>Emplid</th><th class='w3'>Employee</th><th class='w8'>Role</th><th class='w7'>Food Rate</th><th class='w7'>Bar Rate</th><th class='w5'>Covers</th><th class='w5'>WT</th><th class='w6'>Base</th><th class='w5'>Hrs</th><th class='w5'>Setup</th><th class='w5'>Clear</th><th class='w5'>Extra</th><th class='w6'>Food</th><th class='w6'>Bar</th><th class='w6'>Total</th><th>&nbsp;&nbsp;</th></tr>";
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
        echo "<td class='w3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Totals Amounts</td>";                   //4
        echo "<td class='w1' id='gridEmpCnt'><input type='text' class='numfld' size='5'></input></td>";   //5
        echo "<td class='w5'><input type='text' class='numfld' size='3' readonly/></td>";     //Covers   6
        echo "<td class='w5'><input type='text' class='numfld' size='3' readonly/></td>";     //Weight   7
        echo "<td class='w6'><input type='text' class='numfld' size='5' readonly/></td>";     //Base     8
        echo "<td class='w5'><input type='text' class='numfld' size='2' readonly/></td>";     //Hours    9
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Setup   10
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Clear   11
        echo "<td class='w5'><input type='text' class='numfld' size='4' readonly/></td>";     //Extra   12
        echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Food    13
        echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Bar     14
        echo "<td class='w6'><input type='text' class='numfld' size='7' readonly/></td>";     //Total   15
        echo "</tr>";
        echo "</table>";

//        echo "</div>";
     }
//    echo '<input value="Save this Function" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"enterFunc.php5?unitId='. $unitId . '&func=saveFunc","enterFunc");' . "'>";
       echo "</div>";
       echo "<div class='empCounts' id='empCounts'><table id='tabEmpCnts'></table></div>";

  } else {
  	echo "No Week is currently open for processing.  Start the new week, then enter the new function.";
   }
?>