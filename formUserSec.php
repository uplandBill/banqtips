<?php
  session_start();
  include("db.php5");

  $jsonIn  = json_decode(file_get_contents('php://input'));

  foreach ($jsonIn as $jkey => $jsonSet) {
     if ($jkey == "keys") {
        $userid  = $jsonSet->userid;
     }
  }

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

  $jsonAdd = '{"func":"formUserSec.php5","keys":{"userid":"xxnewxx"},"func2":"formUserSecEvents"}';
  if ($userid == 'new') {
      $userid    = "xxnewxx";
      $userName = "New User Name";
  } else {
     $query = "Select userid, userName, password, userStat, userType, userMaint, email from users where userid = '$userid'";
     $result = mysql_query($query) or die('users select failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     $line = mysql_fetch_array($result, MYSQL_NUM);

     $userid    = $line[0];
     $userName  = $line[1];
     $password  = $line[2];
     $userStat  = $line[3];
     $userType  = $line[4];
     $userMaint = $line[5];
     $email     = $line[6];
  }

  echo "<table><tr><td>";

  $nextSql  = "Select userid from users d where d.userid = (select max(userid) from users d1 where d1.userid < '$userid')";
  $nextres  = mysql_query($nextSql) or die('Prev Key Query failed: ' . mysql_error());
  $nextline = mysql_fetch_array($nextres, MYSQL_NUM);
  $nextkey  = $nextline[0];
  if ($nextkey == NULL) {
     $nextSql   = "Select userid from users d where d.userid = (select max(userid) from users d1)";
     $nextres   = mysql_query($nextSql) or die('Prev Key Query failed: ' . mysql_error());
     $nextline  = mysql_fetch_array($nextres, MYSQL_NUM);
     $nextkey  = $nextline[0];
  }

   $json = '{"func":"formUserSec.php5","keys":{"userid":"'.$nextline[0].'"},"func2":"formUserSecEvents"}';
   if (($userid !== 'new') && ($nextkey !== "")) {
       echo '<input type="button" value="Prev User (' . $nextkey. ')" id="editPrevButt"';
       echo " json='$json'/>"; 
      }

  $nextSql  = "Select userid from users d where d.userid = (select min(userid) from users d1 where d1.userid > '$userid')";
  $nextres  = mysql_query($nextSql) or die('Next Key Query failed: ' . mysql_error());
  $nextline = mysql_fetch_array($nextres, MYSQL_NUM);
  $nextkey  = $nextline[0];
  if ($nextkey == NULL) {
     $nextSql   = "Select userid from users d where d.userid = (select min(userid) from users)";
     $nextres   = mysql_query($nextSql) or die('Next Key Query failed: ' . mysql_error());
     $nextline  = mysql_fetch_array($nextres, MYSQL_NUM);
     $nextkey   = $nextline[0];
  }
   $json = '{"func":"formUserSec.php5","keys":{"userid":"'.$nextline[0].'"},"func2":"formUserSecEvents"}';

    echo "</td><td width='150'></td><td>";
    if (($userid !== 'new') && ($nextkey !== "")) {
       echo '<input type="button" value="Next User (' . $nextkey. ')" id="editNextButt"';
       echo " json='$json'/>"; 
      }
    echo "</td><td> $Action </td></tr></table>";
   
   
    echo '<form id="formUserSec">'; 
    echo "<table width='750'>";
   
    if ($userid == "xxnewxx")
       echo '<tr><td width="150">User Login Id:  </td> <td ><input type="text" size = "15" name="userid"    id="userid"    value="'.$userid    .'" /></td><td></td></tr>';
    else
       echo '<tr><td width="150">User Login Id:  </td> <td ><input type="text" size = "15" name="userid"    id="userid"    value="'.$userid    .'" readonly/></td><td></td></tr>';
    echo '<tr><td width="150">User Name:         </td> <td ><input type="text" size = "50" name="userName"  id="userName"  value="'.$userName .'"></td>';
    echo '<td><input type="text" class="hidden" size = "1" name="password" id="password"  value="'.$password .'"></td>';
    echo '</tr>';
    echo "<tr><td width='150'>User Status:       </td> <td ><select name='userStat' id='userStat' value='$userStat'>";
       if ($userStat == "A")
           echo "<option selected='yes' value='A'>Active</option>";
       else
           echo "<option  value='A'>Active</option>";
       if ($userStat == "I")
           echo "<option selected='yes' value='I'>In-Active</option>";
       else
           echo "<option  value='I'>In-Active</option>";
    echo "</select></td>";

    echo "<tr><td width='150'>User Type:         </td> <td ><select name='userType' id='userType' value='$userType'>";
       if ($userType == "admin")
           echo "<option selected='yes' value='admin'>Administrator</option>";
       else
           echo "<option  value='admin'>Administrator</option>";
       if ($userType == "user")
           echo "<option selected='yes' value='user'>Pay Master</option>";
       else
           echo "<option  value='user'>Pay Master</option>";
    echo "</select></td>";

    echo "<tr><td width='150'>User Maintenance:  </td> <td ><select name='userMaint' id='userMaint' value='$userMaint'>";
       if ($userMaint == "Y")
           echo "<option selected='yes' value='Y'>Yes</option>";
       else
           echo "<option  value='Y'>Yes</option>";
       if ($userMaint == "N")
           echo "<option selected='yes' value='N'>No</option>";
       else
           echo "<option  value='N'>No</option>";
    echo "</select></td>";

    echo '<tr><td width="150">Email Address:     </td> <td ><input type="text" size = "50" name="email"  id="email"  value="'.$email .'"></td><td></td></tr>';

    echo '<tr><td id="messages"></td></tr>';

    echo "</table>";                                                                          
    
    echo "<table id='secUnits'>";
    echo "<tr><th>Unit Id</th></tr>";

    $unitSql  = "Select unitId from secUnits where userid = '$userid'";
    $unitRes  = mysql_query($unitSql) or die('Sec Units select failed: ' . mysql_error());
    while ($nextUnit = mysql_fetch_array($unitRes, MYSQL_NUM)) {
    	echo '<tr>'; 
    	echo '<td><input type="text" size = "10" name="unitId"    id="unitId"    value="' .$nextUnit[0]. '" /></td>';
    	echo "<td><img src='./images/letterX.png'/></td>";
    	echo '</tr>';
       }

    echo "</table>";
    echo "<img src='./images/addUnitRow.png' id='addUnitRow'/>";
    echo "</form>";

    echo "<table id='tabButtons'>";
    echo "<tr>";
    echo '<td><input value="Save Entry Now" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"saveUser.php5?userid='. $userid . '","formUserSec","statusRes")' . "'><td>";
    echo '<input type="button" value="Add New User" id="editAddButt"';
    echo " json='$jsonAdd'/></td>"; 
    echo '<td id="statusRes"></td>';
    echo "</tr></table>";
    
    echo "<br>";
?>