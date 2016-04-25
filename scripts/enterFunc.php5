<?php
  session_start();
  include("db.php5");
 
  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
 
  $unitId = $_GET['unitId'];
  $func = $_GET['func'];
  echo "Enter function, unit $unitId, func: $func <br/>";

  echo "<div class='funcForm' id='funcForm'>";
  echo '<form id="enterFunc" name="enterFunc">';
  echo "<table width='750'>";

  $editOn="N";
  if ($func == "start") {
     $editOn="Y";
     $funcDate   = "";
     $roomNum    = "";
     $funcType   = "";
     $funcNumWk  = "";
     $foodCheck  = "";
     $barCheck   = "";
     $defCovers  = "0";
     $defSetup   = "0";
     $defClear   = "0";
     $defExtra   = "0";    
  }

  if ($func == "entered") {
     $editOn="Y";
     $funcDate   = $_POST[funcDate];
     $roomNum    = $_POST[roomNum];
     $funcType   = $_POST[funcType];
     $funcNumWk  = $_POST[funcNumWk];
     $foodCheck  = $_POST[foodCheck];
     $foodBill   = $_POST[foodBill];
     $foodGrat   = $_POST[foodGrat];
     $barCheck   = $_POST[barCheck];
     $barBill    = $_POST[barBill];
     $barGrat    = $_POST[barGrat];
     $defCovers  = $_POST[defCovers];
     $defSetup   = $_POST[defSetup];
     $defClear   = $_POST[defClear];
     $defExtra   = $_POST[defExtra];    
  }

  if ($editOn = "Y") {
     echo "<tr><td>Function Date   </td><td><input type='text' size = '10' name='funcDate'    id='funcDate'    value='$funcDate' class='tcal tcalInput'/></td></tr>";
     echo "<tr><td>Room            </td><td><input type='text' size = '10' name='roomNum'     id='roomNum'     value='$roomNum'/>   </td></tr>";
     echo "<tr><td>Function Type   </td><td><input type='text' size = '10' name='funcType'    id='funcType'    value='$funcType'/>  </td></tr>";
     echo "<tr><td>Function Num    </td><td><input type='text' size = '10' name='funcNumWk'   id='funcNumWk'   value='$funcNumWk'/> </td></tr>";
     echo "<tr><td>Food Check#     </td><td><input type='text' size = '10' name='foodCheck'   id='foodCheck'   value='$foodCheck'/> </td>";
     echo "<td>Food Bill Amount    </td><td><input type='text' class='numfld' size = '10' name='foodBill'    id='foodBill'   value='$foodBill'/> </td>";
     echo "<td>Food Gratuity Amount    </td><td><input type='text' class='numfld' size = '10' name='foodGrat'   id='foodGrat'   value='$foodGrat'/> </td>";
     echo "</tr>";
     echo "<tr><td>Bar Check#      </td><td><input type='text' size = '10' name='barCheck'    id='barCheck'    value='$barCheck'>  </td>";
     echo "<td>Bar Bill Amount    </td><td><input type='text' class='numfld' size = '10' name='barBill'    id='barBill'   value='$barBill'/> </td>";
     echo "<td>Bar Gratuity Amount    </td><td><input type='text' class='numfld' size = '10' name='barGrat'   id='barGrat'   value='$barrat'/> </td>";
     echo "</tr>";
     echo "<tr><td>Default Covers  </td><td><input type='text' class='numfld' size = '10' name='defCovers'   id='defCovers'   value='$defCovers'/>  </td></tr>";
     echo "<tr><td>Default Setup   </td><td><input type='text' class='numfld' size = '10' name='defSetup'    id='defSetup'    value='$defSetup'/>   </td>";
     echo "<td>Default Clear   </td><td><input type='text' class='numfld' size = '10' name='defClear'    id='defClear'    value='$defClear'/>   </td><";
     echo "<td>Default Extra   </td><td><input type='text' class='numfld' size = '10' name='defExtra'    id='defExtra'    value='$defExtra'/>   </td></tr>";
     echo "<tr><td></td><td></td></tr>";
     $getAddButtons = "Select eeType, eeTypeDescr From employeeTypes Where unitId = '$unitId' and addButton = 'Y'";
     $result = mysql_query($getAddButtons) or die('get add buttons failed: ' . mysql_error());
     echo '<tr>';
     while ($eeTypes = mysql_fetch_array($result, MYSQL_NUM)) {
         echo '<td><form name = "add' . $eeTypes[0] . '" >';
         echo '<input type="button" value="Add ' .$eeTypes[1]. '" onclick="add_eeTypes(' . "'$eeTypes[1]'". ');">';
         echo "</form></td>";
     }
     echo '</tr>';
     echo "</table>";
     echo "</form>";
     echo "<div class='empGrid'>";
     echo "<table id='empGrid'><tr><th>Row</th><th>Emplid</th><th>Employee</th><th>Role</th><th></th><th>Food Rate</th><th>Bar Rate</th><th>Base</th><th>Hours</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Food</th><th>Bar</th><th>Total</th></tr>";
     echo "</table></div>";
  }
    echo '<input value="Save this Function" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"enterFunc.php5?unitId='. $unitId . '&func=entered","enterFunc");' . "'>";
    echo "</div><div class='empCounts' id='empCounts'><table id='tabEmpCnts'></table></div>";
    
    echo "<br>";
    echo '<FORM Name = "newtodo" ><INPUT TYPE="BUTTON" VALUE="ADD New Config" ONCLICK="set_events2()"> </FORM>';
    echo "<br>";
    echo '<FORM Name = "deltodo" ><INPUT TYPE="BUTTON" VALUE="DELETE this Config" ONCLICK="window.location.href=' ."'tododelete.php5?todo=" .$TaskKey. "&NextTask=". $nexttask ."'" .'"></FORM>';

?>