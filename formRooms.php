<?php
  session_start();
  include("db.php5");

  $jsonIn  = json_decode(file_get_contents('php://input'));

  foreach ($jsonIn as $jkey => $jsonSet) {
     if ($jkey == "keys") {
        $unitId  = $jsonSet->unitId;
        $roomNum = $jsonSet->roomNum;
     }
  }

//  $unitId = $_GET['unitId'];
//  $roomNum = $_GET['roomNum'];
//  $effdt  = $_GET['effdt'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $jsonAdd = '{"func":"formRooms.php","keys":{"unitId":"' .$unitId. '","roomNum":"new"},"func2":"formButtEvents"}';
  if ($roomNum == 'new') {
      $roomNum    = "xxnewxx";
      $roomDescr = "New Room Name";
  } else {
     $query = "Select roomNum, roomDescr from rooms where unitId = '$unitId' and roomNum = '$roomNum'";
     $result = mysql_query($query) or die('Rooms select failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     $line = mysql_fetch_array($result, MYSQL_NUM);

     $roomNum   = $line[0];
     $roomDescr = $line[1];
  }

  echo "<table><tr><td>";

  $nextSql  = "Select unitId, roomNum from rooms d where d.unitId = '$unitId' and d.roomNum = (select max(roomNum) from rooms d1 where d1.unitId = d.unitId and d1.roomNum < '$roomNum')";
  $nextres  = mysql_query($nextSql) or die('Prev Key Query failed: ' . mysql_error());
  $nextline = mysql_fetch_array($nextres, MYSQL_NUM);
  $nextkey  = $nextline[1];
  if ($nextkey == NULL) {
     $nextSql   = "Select unitId, roomNum from rooms d where d.unitId = '$unitId' and d.roomNum = (select max(roomNum) from rooms d1 where d1.unitId = d.unitId)";
     $nextres   = mysql_query($nextSql) or die('Prev Key Query failed: ' . mysql_error());
     $nextline  = mysql_fetch_array($nextres, MYSQL_NUM);
     $nextkey  = $nextline[1];
  }

   $json = '{"func":"formRooms.php","keys":{"unitId":"'.$nextline[0].'","roomNum":"'.$nextline[1].'"},"func2":"formButtEvents"}';
   if (($roomNum !== 'new') && ($nextkey !== "")) {
       echo '<form name = "prevrec" ><input type="button" value="Prev Room (' . $nextkey. ')" id="editPrevButt"';
       echo " json='$json'/></form>"; 
      }

  $nextSql  = "Select unitId, roomNum from rooms d where d.unitId = '$unitId' and d.roomNum = (select min(roomNum) from rooms d1 where d1.unitId = d.unitId and d1.roomNum > '$roomNum')";
  $nextres  = mysql_query($nextSql) or die('Next Key Query failed: ' . mysql_error());
  $nextline = mysql_fetch_array($nextres, MYSQL_NUM);
  $nextkey  = $nextline[1];
  if ($nextkey == NULL) {
     $nextSql   = "Select unitId, roomNum from rooms d where d.unitId = '$unitId' and d.roomNum = (select min(roomNum) from rooms d1 where d1.unitId = d.unitId)";
     $nextres   = mysql_query($nextSql) or die('Next Key Query failed: ' . mysql_error());
     $nextline  = mysql_fetch_array($nextres, MYSQL_NUM);
     $nextkey   = $nextline[1];
  }
   $json = '{"func":"formRooms.php","keys":{"unitId":"'.$nextline[0].'","roomNum":"'.$nextline[1].'"},"func2":"formButtEvents"}';

    echo "</td><td width='150'></td><td>";
    if (($roomNum !== 'new') && ($nextkey !== "")) {
       echo '<form name = "nextrec" ><input type="button" value="Next Room (' . $nextkey. ')" id="editNextButt"';
       echo " json='$json'/></form>"; 
//       echo ' onclick="getRec(' . "'formRooms','?unitId=" .$unitId. '&roomNum=' .$nextkey. '&effdt=' .'2013-02-01'. "/','todoform')" .'"></form>';
      }
    echo "</td><td> $Action </td></tr></table>";
   
   
    echo '<form id="formRooms">'; 
    echo "<table width='750'>";
   
    if ($roomNum == "xxnewxx")
       echo '<tr><td width="150">Room Number:     </td> <td ><input type="text" size = "5" name="roomNum"    id="roomNum"    value="'.$roomNum    .'" /></td><td></td></tr>';
    else
       echo '<tr><td width="150">Room Number:     </td> <td ><input type="text" size = "5" name="roomNum"    id="roomNum"    value="'.$roomNum    .'" readonly/></td><td></td></tr>';
//    echo '<tr><td width="150">Effective Date:  </td> <td ><input type="text" size = "10" name="effdt"     id="effdt"     value="'.$effdt     .'" class="tcal tcalInput"/></td><td></td></tr>';

//    echo "<tr><td width='150'>Eff Status:      </td> <td ><select name='effStatus' id='effStatus' value='$effStatus'>";
//    $transList = "select t.fieldValue, t.descr from translates t where t.unitId = '$unitId' and fieldName = 'effStatus' and t.effStatus = 'A' and t.effdt = (select max(effdt) from translates st where st.unitId = t.unitId and st.fieldName = t.fieldName and st.fieldValue = st.fieldValue) order by t.descr";
//    $transRes  = mysql_query($transList) or die('Get EC Method Types failed: ' . mysql_error());
//    while ($transRec = mysql_fetch_array($transRes, MYSQL_NUM)) {
//    	$fieldValue  = $transRec[0];
//    	$descr       = $transRec[1];
//        if ($fieldValue == $effStatus)
//           echo "<option selected='yes' value='$fieldValue'>$descr </option>";
//        else
//           echo "<option  value='$fieldValue'>$descr </option>";
//     }
    echo "</select></td>";

    echo '<tr><td width="150">Room Name:       </td> <td ><input type="text" size = "50" name="roomDescr" id="roomDescr" value="'.$roomDescr .'"></td><td></td></tr>';
    echo '<tr><td id="messages"></td></tr>';

    echo "</table>";                                                                          
    echo "</form>";

    echo "<table id='tabButtons'>";
    echo "<tr>";
    echo '<td><input value="Save Entry Now" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"saveRooms.php?unitId='. $unitId . '&roomNum=' .$roomNum. '","formRooms","statusRes")' . "'><td>";
    echo '<input type="button" value="Add New Room" id="editAddButt"';
    echo " json='$jsonAdd'/></td>"; 
    echo '<td id="statusRes"></td>';
    echo "</tr></table>";
    
    echo "<br>";
?>