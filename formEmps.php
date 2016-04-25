<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];
  $emplid = $_GET['emplid'];
  $effdt  = $_GET['effdt'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  if ($emplid == 'xnewx') {
      $effdt      = "12/01/2012";
      $name       = "";
      $deptId     = " ";
      $location   = " ";
      $emplStatus = "A";
      $deptDescr  = "Dept Name";
      $eeTyepe    = 1;
      $locId      = "";
      $emplClass  = "6";
      $baseWage   = 0;
      $payGrp     = " ";
  } else {
//                       0        1         2        3          4          5             6           7            8            9               10             11                 12         13
     $query = "Select e.emplid, e.effdt, e.name, e.deptid, d.deptDescr, e.locId, e.emplStatus, e.eeType, e.emplClass, t.eeTypeDescr, t.eeBaseWage, t.foodTipPercent, t.barTipPercent, e.payGrp, e.jobcode from employees e, employeeTypes t, depts d where e.unitId='$unitId' and e.emplid = '$emplid' and t.eeType = e.eeType and d.deptId = e.deptId and e.effdt = (select max(effdt) from employees e2 where e2.emplid = e.emplid) order by e.emplid";
     $result = mysql_query($query) or die('Get Employee failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     $line = mysql_fetch_array($result, MYSQL_NUM);

     $emplid     = $line[0];
     $effdt      = $line[1];
     $name       = $line[2];
     $deptId     = $line[3];
     $locId      = $line[5];
     $emplStatus = $line[6];
     $eeType     = $line[7];
     $emplClass  = $line[8];
     $payGrp     = $line[13];
     $jobcode    = $line[14];
  }

   $maxKey   = "select min(emplid) from employees e where e.unitId = '$unitId' and e.emplid > '$emplid'";
   $nextres  = mysql_query($maxKey) or die('get max entry failed: ' . mysql_error());
   $line     = mysql_fetch_array($nextres, MYSQL_NUM);
   $nextKey  = $line[0];

   $minKey   = "select max(emplid) from employees e where e.unitId = '$unitId' and e.emplid < '$emplid'";
   $nextres  = mysql_query($minKey) or die('get min entry failed: ' . mysql_error());
   $line     = mysql_fetch_array($nextres, MYSQL_NUM);
   $prevKey  = $line[0];


   echo "<div class='formEmpDiv'>";
    echo "<table><tr><td>";
    echo '<input type="button" value="Prev Employee (' . $prevKey. ')" onclick="getRec(' ."'formEmps','unitId=$unitId&emplid=$prevKey','todoform'". ');"">';
    echo "</td><td width='150'></td><td>";
    echo '<input type="button" value="Next Employee (' . $nextKey. ')" onclick="getRec(' ."'formEmps','unitId=$unitId&emplid=$nextKey','todoform'". ');"">';

//    echo "</td><td> $Action </td>
    echo "</tr></table>";

    echo '<form id="formEmps">';
    echo "<table width='750'>";

    echo '<tr><td width="150">Unit Id:       </td> <td ><input type="text" size = "15" name="unitId"    id="unitId"    value="'.$unitId    .'" readonly></td><td></td></tr>';
    if ($emplid == 'xnewx') {
       echo '<tr><td width="150">Emplid:        </td> <td ><input type="text" size = "15" name="emplid"    id="emplid"    value="'.$emplid    .'" >';
       echo '<input id="noButton1" value="Get next Temp Id" type="button" onclick="javascript:getTempId(' ."'$unitId'". ')"></td></tr>';
       }
    else
       echo '<tr><td width="150">Emplid:        </td> <td ><input type="text" size = "15" name="emplid"    id="emplid"    value="'.$emplid    .'" readonly></td><td></td></tr>';
    echo '<tr><td width="150">Effdt:         </td> <td ><input type="text" size = "10" name="effdt"  id="effdt"    value="'.$effdt     .'" class="tcal tcalInput"/></td>';
    echo "<td>";
    echo "</td>";
    echo '</tr>';
    
    echo "<tr><td class='hidden'>x</td></tr>";

    echo "<td width='150'>Status         </td><td><select name='emplStatus' id='emplStatus' value='$emplStatus'>";
    $transList = "select t.fieldValue, t.descr from translates t where t.unitId = '$unitId' and fieldName = 'emplStatus' and t.effStatus = 'A' and t.effdt = (select max(effdt) from translates st where st.unitId = t.unitId and st.fieldName = t.fieldName and st.fieldValue = st.fieldValue) order by t.descr";
    $transRes  = mysql_query($transList) or die('Get EC Method Types failed: ' . mysql_error());
    while ($transRec = mysql_fetch_array($transRes, MYSQL_NUM)) {
    	$fieldValue  = $transRec[0];
    	$descr       = $transRec[1];
        if ($fieldValue == $emplStatus)
           echo "<option selected='yes' value='$fieldValue'>$descr </option>";
        else
           echo "<option  value='$fieldValue'>$descr </option>";
     }
    echo "</select></td>";

    echo '<tr><td width="150">Employee Name: </td> <td ><input type="text" size = "30" name="name"     id="name"     value="'.$name      .'"></td><td></td></tr>';
    echo "<tr><td width='150'>Department:    </td><td><select name='deptId' id='deptId' value='$deptId'>";
    $deptList = "select deptId, deptDescr from depts d where d.unitId = '$unitId' order by deptid";
    $deptRes  = mysql_query($deptList) or die('Get Depts failed: ' . mysql_error());
    while ($deptRec = mysql_fetch_array($deptRes, MYSQL_NUM)) {
    	$deptListId    = $deptRec[0];
    	$deptListDescr = $deptRec[1];
        if ($deptListId == $deptId)
           echo "<option selected='yes' value='$deptListId'>$deptListId - $deptListDescr </option>";
        else
           echo "<option  value='$deptListId'>$deptListId - $deptListDescr </option>";
     }
    echo "</select></td>";

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
    echo "</tr>";

    echo "<tr><td width='150'>Job Code:    </td><td><input type='text' size = '10'  name='jobcode'   id='jobcode'     value='".$jobcode      ."'></td></tr>";
    
    echo "<tr><td></td><td><div class='deptInfo' id='deptInfo'></div></td><td></td><td><div class='eeTypeInfo' id='eeTypeInfo'></div></td></tr>";

    echo "<tr>";
    echo "<td width='150'>Location</td><td><select name='locId' id='locId' value='$locId'>";
    $pgList = "select l.locId, l.locDescr  from locs l where l.unitId = '$unitId' order by l.locId";
    $pgRes  = mysql_query($pgList) or die('Get pay groups failed: ' . mysql_error());
    while ($pgRec = mysql_fetch_array($pgRes, MYSQL_NUM)) {
    	$selLocId    = $pgRec[0];
    	$selLocDescr = $pgRec[1];
        if ($selLocId == $locId)
           echo "<option selected='yes' value='$selLocId'>$selLocId - $selLocDescr </option>";
        else
           echo "<option  value='$selLocId'>$selLocId - $selLocDescr </option>";
     }
    echo "</select></td>";
    echo "</tr>";

    echo "<tr>";
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
    echo "</tr>";

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
    echo "</tr>";

    echo "</table>";
    echo "</form>";

    echo "<table id='tabButtons'><tr>";
    echo '<td><input value="Save Entry Now" type="button" onclick="javascript:saveEmp()"></td>';
    echo '<td><input value="Add New Employee" type="button" onclick="javascript:getRec(\'formEmps\',\'unitId=' .$unitId. '&emplid=xnewx\',\'todoform\')"></td>';
    echo '<td id="statusRes"></td>';
    echo "</tr></table>";

    echo "</div>";
    echo "<div class='formEmpRet'><img src='./images/returnButton.gif' onclick='weekFunc1(" .'"'.$unitId. '","getEmps","","listarea");' ."'/></div>";
    echo "<div class='formEmpHist' id='formEmpHist'></div>";

?>