<?php
  session_start();
  include("db.php5");

  $jsonIn  = json_decode(file_get_contents('php://input'));

  foreach ($jsonIn as $jkey => $jsonSet) {
     if ($jkey == "keys") {
        $unitId = $jsonSet->unitId;
        $deptId = $jsonSet->deptId;
        $effdt  = $jsonSet->effdt;
     }
  }

//  $unitId = $_GET['unitId'];
//  $deptId = $_GET['deptId'];
//  $effdt  = $_GET['effdt'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $jsonAdd = '{"func":"formDepts.php","keys":{"unitId":"' .$unitId. '","deptId":"new","effdt":"' .date("m-d-Y"). '"},"func2":"formDeptEvents"}';
  if ($deptId == 'new') {
      $deptId    = "xxnewxx";
      $effdt     = "12/01/2012";
      $deptDescr = "Dept Name";
      $dud       = "";      
  } else {
     $query = "Select deptId, effdt, effStatus, deptDescr, dud from depts where unitId = '$unitId' and deptId = '$deptId' and effdt='$effdt'";
     $result = mysql_query($query) or die('Todo Query failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     $line = mysql_fetch_array($result, MYSQL_NUM);

     $deptId    = $line[0];
     $effdt     = $line[1];
     $effStatus = $line[2];
     $deptDescr = $line[3];
     $dud       = $line[4];
  }

    echo "<table><tr><td>";

  $nextSql  = "Select unitId, deptId, effdt from depts d where d.unitId = '$unitId' and d.deptId = (select max(deptId) from depts d1 where d1.unitId = d.unitId and d1.deptId < '$deptId') and d.effdt=(select max(effdt) from depts d2 where d2.unitId = d.unitId and d2.deptId = d.deptId)";
  $nextres  = mysql_query($nextSql) or die('Prev Key Query failed: ' . mysql_error());
  $nextline = mysql_fetch_array($nextres, MYSQL_NUM);
  $nextkey  = $nextline[1];
  if ($nextkey == NULL) {
     $nextSql   = "Select unitId, deptId, effdt from depts d where d.unitId = '$unitId' and d.deptId = (select max(deptId) from depts d1 where d1.unitId = d.unitId) and d.effdt=(select max(effdt) from depts d2 where d2.unitId = d.unitId and d2.deptId = d.deptId)";
     $nextres   = mysql_query($nextSql) or die('Prev Key Query failed: ' . mysql_error());
     $nextline  = mysql_fetch_array($nextres, MYSQL_NUM);
     $nextkey  = $nextline[1];
  }

   $json = '{"func":"formDepts.php","keys":{"unitId":"'.$nextline[0].'","deptId":"'.$nextline[1].'","effdt":"'.$nextline[2].'"},"func2":"formDeptEvents"}';
   if (($deptId !== 'new') && ($nextkey !== "")) {
       echo '<form name = "prevrec" ><input type="button" value="Prev dept (' . $nextkey. ')" id="deptPrevButt"';
       echo " json='$json'/></form>"; 
      }

  $nextSql  = "Select unitId, deptId, effdt from depts d where d.unitId = '$unitId' and d.deptId = (select min(deptId) from depts d1 where d1.unitId = d.unitId and d1.deptId > '$deptId') and d.effdt=(select max(effdt) from depts d2 where d2.unitId = d.unitId and d2.deptId = d.deptId)";
  $nextres  = mysql_query($nextSql) or die('Next Key Query failed: ' . mysql_error());
  $nextline = mysql_fetch_array($nextres, MYSQL_NUM);
  $nextkey  = $nextline[1];
  if ($nextkey == NULL) {
     $nextSql   = "Select unitId, deptId, effdt from depts d where d.unitId = '$unitId' and d.deptId = (select min(deptId) from depts d1 where d1.unitId = d.unitId) and d.effdt=(select max(effdt) from depts d2 where d2.unitId = d.unitId and d2.deptId = d.deptId)";
     $nextres   = mysql_query($nextSql) or die('Next Key Query failed: ' . mysql_error());
     $nextline  = mysql_fetch_array($nextres, MYSQL_NUM);
     $nextkey   = $nextline[1];
  }
   $json = '{"func":"formDepts.php","keys":{"unitId":"'.$nextline[0].'","deptId":"'.$nextline[1].'","effdt":"'.$nextline[2].'"},"func2":"formDeptEvents"}';

    echo "</td><td width='150'></td><td>";
    if (($deptId !== 'new') && ($nextkey !== "")) {
       echo '<form name = "nextrec" ><input type="button" value="Next dept (' . $nextkey. ')" id="deptNextButt"';
       echo " json='$json'/></form>"; 
//       echo ' onclick="getRec(' . "'formDepts','?unitId=" .$unitId. '&deptId=' .$nextkey. '&effdt=' .'2013-02-01'. "/','todoform')" .'"></form>';
      }
    echo "</td><td> $Action </td></tr></table>";
   
   
    echo '<form id="formDepts">'; 
    echo "<table width='750'>";
   
    if ($deptId == "xxnewxx")
       echo '<tr><td width="150">Dept Id:         </td> <td ><input type="text" size = "15" name="deptId"    id="deptId"    value="'.$deptId    .'" /></td><td></td></tr>';
    else
       echo '<tr><td width="150">Dept Id:         </td> <td ><input type="text" size = "15" name="deptId"    id="deptId"    value="'.$deptId    .'" readonly/></td><td></td></tr>';
    echo '<tr><td width="150">Effective Date:  </td> <td ><input type="text" size = "10" name="effdt"     id="effdt"     value="'.$effdt     .'" class="tcal tcalInput"/></td><td></td></tr>';

    echo "<tr><td width='150'>Eff Status:      </td> <td ><select name='effStatus' id='effStatus' value='$effStatus'>";
    $transList = "select t.fieldValue, t.descr from translates t where t.unitId = '$unitId' and fieldName = 'effStatus' and t.effStatus = 'A' and t.effdt = (select max(effdt) from translates st where st.unitId = t.unitId and st.fieldName = t.fieldName and st.fieldValue = st.fieldValue) order by t.descr";
    $transRes  = mysql_query($transList) or die('Get EC Method Types failed: ' . mysql_error());
    while ($transRec = mysql_fetch_array($transRes, MYSQL_NUM)) {
    	$fieldValue  = $transRec[0];
    	$descr       = $transRec[1];
        if ($fieldValue == $effStatus)
           echo "<option selected='yes' value='$fieldValue'>$descr </option>";
        else
           echo "<option  value='$fieldValue'>$descr </option>";
     }
    echo "</select></td>";

    echo '<tr><td width="150">Dept Name:       </td> <td ><input type="text" size = "50" name="deptDescr" id="deptDescr" value="'.$deptDescr .'"></td><td></td></tr>';
    echo '<tr><td width="150">DUD:             </td> <td ><input type="text" size = "8"  name="dud"       id="dud"  value="'.$dud  .'"></td><td></td></tr>';
    echo '<tr><td id="messages"></td></tr>';

    echo "</table>";                                                                          
    echo "</form>";

//    echo '<input value="Save Entry Now" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"saveDepts.php?unitId='. $unitId . '&deptId=' .$deptId. '","formDepts","messages")' . "'>";
    
    echo "<table id='tabButtons'><tr>";
//    echo '<td><input value="Save Entry Now" type="button" onclick="javascript:saveEmp()"></td>';  from employee page
    echo '<td><input value="Save Entry Now" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"saveDepts.php?unitId='. $unitId . '&deptId=' .$deptId. '","formDepts","statusRes")' . "'><td>";
    echo '<input type="button" value="Add New Dept" id="deptAddButt"';
    echo " json='$jsonAdd'/></td>"; 


    echo '<td id="statusRes"></td>';
    echo "</tr></table>";
    
    echo "<br>";
?>