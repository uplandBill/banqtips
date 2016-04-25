<?php
  session_start();
  include("db.php5");
  $userId=$_SESSION['userId'];

  if ($userId == "") {
     echo "Please Logon";
  } else {

     $unitId   = $_GET['unitId'];
     $eventNum = $_GET['eventNum'];
     $emplid   = $_GET['emplid'];
   
     $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
     $db_selected = mysql_select_db($dbname);

     if ($unitId == "" || $eventNum == "" || $emplid == "") {
        echo "Missing Parms";
     } else {
        
     $funcSql  = "Select e.wkendDate, e.funcDate, e.funcGroup, e.roomNum, r.roomDescr, e.funcType, e.funcNumWk, e.totCovers, e.defSetup, e.defClear, e.defExtra from events e, rooms r where e.unitId = '$unitId' and e.eventNum = $eventNum and r.unitId = e.unitId and r.roomNum = e.roomNum";
     $funcRes  = mysql_query($funcSql) or die('Get function failed: ' . mysql_error());
     $rows     = mysql_num_rows($funcRes);
     $function = mysql_fetch_array($funcRes, MYSQL_NUM);
//                       0          1         2          3           4              5             6          7             8             9          10           11            12         13           14         15
     $empSql = "Select e.empSeq, e.eeType, e.payGrp, e.emplClass, e.grat1Rate, e.grat1Group, e.grat1Cut, e.grat2Rate, e.grat2Group, e.grat2Cut, e.grat3Rate, e.grat3Group, e.grat3Cut, e.getSetup, e.getClear, e.getExtra";
     $empSql = $empSql .", e.eeBaseWage, e.coversAllowed, e.eeCovers, e.eeWeight, e.baseWage, e.hours, e.setupAmt, e.clearAmt, e.extraAmt, e.totalPay";
     $empSql = $empSql ." From funcEmps e Where e.unitId = '$unitId' and e.eventNum = $eventNum and e.emplid = '$emplid'";
     $empRes = mysql_query($empSql) or die('Get Employee Func failed: ' . mysql_error());
     $rows = mysql_num_rows($empRes);
     $funcEmps = mysql_fetch_array($empRes, MYSQL_NUM);

     $empSeq        = $funcEmps[0];
     $eeType        = $funcEmps[1];
     $payGrp        = $funcEmps[2];
     $emplClass     = $funcEmps[3];
     $grat1Rate     = $funcEmps[4];
     $grat1Group    = $funcEmps[5];
     $grat1Cut      = $funcEmps[6];
     $grat2Rate     = $funcEmps[7];
     $grat2Group    = $funcEmps[8];
     $grat2Cut      = $funcEmps[9];
     $grat3Rate     = $funcEmps[10];
     $grat3Group    = $funcEmps[11];
     $grat3Cut      = $funcEmps[12];
     $getSetup      = $funcEmps[13];
     $getClear      = $funcEmps[14];
     $getExtra      = $funcEmps[15];
     $eeBaseWage    = $funcEmps[16];
     $coversAllowed = $funcEmps[17];
     $eeCovers      = $funcEmps[18];
     $eeWeight      = $funcEmps[19];
     $baseWage      = $funcEmps[20];
     $hours         = $funcEmps[21];
     $setupAmt      = $funcEmps[22];
     $clearAmt      = $funcEmps[23];
     $extraAmt      = $funcEmps[24];
     $totalPay      = $funcEmps[25];

     echo "<div class='formFuncEmps'>";

     echo '<form id="formFuncEmps">';
     echo "<table width='340'>";
     echo '<tr>';
     echo '<td width="140">Emp Seq Number </td> <td><input type="text" size = "5" name="empSeq"    id="empSeq"    value="'.$empSeq    .'" readonly></td><td><input type="text" size = "6" name="emplid"    id="emplid"    value="'.$emplid    .'" readonly></td>';
     echo '</tr>';
     echo '<tr>';
     echo "<td width='150'>Role        </td><td><select name='eeType' id='eeType' value='$eeType'>";
     $eeTypeList = "select t.eeType, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.foodGroup, t.barTipPercent, t.barGroup from employeeTypes t where t.unitId = '$unitId' order by eeType";
     $eeTypeRes  = mysql_query($eeTypeList) or die('Get EE Types failed: ' . mysql_error());
     while ($eeTypeRec = mysql_fetch_array($eeTypeRes, MYSQL_NUM)) {
         $listEeType    = $eeTypeRec[0];
         $listTypeDescr = $eeTypeRec[1];
         if ($listEeType == $eeType)
            echo "<option selected='yes' value='$listEeType'>$listEeType - $listTypeDescr </option>";
         else
            echo "<option  value='$listEeType'>$listEeType - $listTypeDescr </option>";
      }
     echo "</select></td>";
     echo '</tr>';
     echo '<tr>';
     echo "<tr>";
     echo "<td width='150'>Pay Group</td><td><select name='payGrp' id='payGrp' value='$payGrp'>";
     $pgList = "select p.payGrp, p.payGrpDescr from payGrp p where p.unitId = '$unitId' and p.effStatus = 'A' and p.effdt = (select max(effdt) from payGrp sp where sp.unitId = p.unitId and sp.payGrp = p.payGrp) order by p.payGrpDescr";
     $pgRes  = mysql_query($pgList) or die('Get pay groups failed: ' . mysql_error());
     while ($pgRec = mysql_fetch_array($pgRes, MYSQL_NUM)) {
         $recPayGrp      = $pgRec[0];
         $recPayGrpDescr = $pgRec[1];
         if ($recPayGrp == $payGrp)
            echo "<option selected='yes' value='$recPayGrp'>$recPayGrpDescr </option>";
         else
            echo "<option  value='$recPayGrp'>$recPayGrpDescr </option>";
      }
     echo "</select></td>";
     echo '</tr>';
     echo '<tr>';
     echo "<td width='150'>Class</td><td><select name='emplClass' id='emplClass' value='$emplClass'>";
     $pgList = "select t.fieldValue, t.descr  from translates t where t.unitId = '$unitId' and t.fieldName = 'emplClass' and t.effStatus = 'A' and t.effdt = (select max(effdt) from translates st where st.unitId = t.unitId and st.fieldName = t.fieldName and st.fieldValue = t.fieldValue) order by t.descr";
     $pgRes  = mysql_query($pgList) or die('Get pay groups failed: ' . mysql_error());
     while ($pgRec = mysql_fetch_array($pgRes, MYSQL_NUM)) {
         $emplClassVal   = $pgRec[0];
         $emplClassDescr = $pgRec[1];
         if ($emplClassVal == $emplClass)
            echo "<option selected='yes' value='$emplClassVal'>$emplClassVal-$emplClassDescr </option>";
         else
            echo "<option  value='$emplClassVal'>$emplClassVal-$emplClassDescr </option>";
      }
     echo "</select></td>";
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 1 Rate    </td> <td><input type="text" size =" 5" name="grat1Rate"     id="grat1Rate"     value="'.$grat1Rate     .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 1 Group   </td> <td><input type="text" size =" 5" name="grat1Group"    id="grat1Group"    value="'.$grat1Group    .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 2 Cut     </td> <td><input type="text" size =" 5" name="grat1Cut"      id="grat1Cut"      value="'.$grat1Cut      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 2 Rate    </td> <td><input type="text" size =" 5" name="grat2Rate"     id="grat2Rate"     value="'.$grat2Rate     .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 2 Group   </td> <td><input type="text" size =" 5" name="grat2Group"    id="grat2Group"    value="'.$grat2Group    .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 2 Cut     </td> <td><input type="text" size =" 5" name="grat2Cut"      id="grat2Cut"      value="'.$grat2Cut      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 3 Rate    </td> <td><input type="text" size =" 5" name="grat3Rate"     id="grat3Rate"     value="'.$grat3Rate     .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 3 Group   </td> <td><input type="text" size =" 5" name="grat3Group"    id="grat3Group"    value="'.$grat3Group    .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Grat 3 Cut     </td> <td><input type="text" size =" 5" name="grat3Cut"      id="grat3Cut"      value="'.$grat3Cut      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Setup      </td> <td><input type="text" size =" 5" name="getSetup"      id="getSetup"      value="'.$getSetup      .'"></td><td><input type="text" size =" 5" name="setupAmt"      id="setupAmt"      value="'.$setupAmt      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Clear      </td> <td><input type="text" size =" 5" name="getClear"      id="getClear"      value="'.$getClear      .'"></td><td><input type="text" size =" 5" name="clearAmt"      id="clearAmt"      value="'.$clearAmt      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Extra      </td> <td><input type="text" size =" 5" name="getExtra"      id="getExtra"      value="'.$getExtra      .'"></td><td><input type="text" size =" 5" name="extraAmt"      id="extraAmt"      value="'.$extraAmt      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Get Base Wage  </td> <td><input type="text" size =" 5" name="eeBaseWage"    id="eeBaseWage"    value="'.$eeBaseWage    .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Uses Covers    </td> <td><input type="text" size =" 5" name="coversAllowed" id="coversAllowed" value="'.$coversAllowed .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Num Covers     </td> <td><input type="text" size =" 5" name="eeCovers"      id="eeCovers"      value="'.$eeCovers      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">EE Weight      </td> <td><input type="text" size =" 5" name="eeWeight"      id="eeWeight"      value="'.$eeWeight      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Base Wage      </td> <td><input type="text" size =" 5" name="baseWage"      id="baseWage"      value="'.$baseWage      .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Hours          </td> <td><input type="text" size =" 5" name="hours"         id="hours"         value="'.$hours         .'"></td>';
     echo '</tr>';
     echo '<tr>';
     echo '<td width="140">Total Pay      </td> <td><input type="text" size =" 5" name="totalPay"      id="totalPay"      value="'.$totalPay      .'"></td><td id="funcFormRes"></td>';
     echo '</tr>';
     echo "</table>";
     echo "</form>";

     echo "<table id='tabButtons'><tr>";
     echo '<td><input value="Save Entry Now" type="button" onclick="javascript:saveFuncEmps(\'./saveFuncEmps.php5?unitId=' .$unitId .'&eventNum='. $eventNum .'\', \'formFuncEmps\',\'funcFormRes\')"></td>';
     echo '<td id="statusRes"></td>';
     echo "</tr></table>";

     echo "</div>";
     
     echo "<div class='funcDisp'>";
     echo "<table>";
     echo "<tr>";
     echo "<td>Week End Date:</td><td>$function[0]</td>";
     echo "<td>Function Date:</td><td>$function[1]</td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td>Group:</td><td>$function[2]</td>";
     echo "<td>Room:</td><td>$function[4]</td>";
     echo "</tr>";
     echo "</table>";
     echo "</div>";

     echo "<div id='hiddenData3'>";
     echo "</div>";

     echo "<div class='formEmpRetX'><img src='./images/returnButton.gif' onclick='weekFunc1(" .'"'.$unitId. '","auditEmpBW","&emplid='. $emplid .'","listarea");' ."'/></div>";
     echo "<div class='formEmpHist' id='formEmpHist'></div>";
     }
   }
?>