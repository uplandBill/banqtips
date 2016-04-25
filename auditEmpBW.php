<?php
  session_start();
  include("db.php5");

  $unitId   = $_GET['unitId'];
  $emplid = $_GET['emplid'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

//                      0         1                    2                             3            
  $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
  $result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
  $recs = mysql_fetch_array($result, MYSQL_NUM);
  
//  echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
//  echo "table {width: 1300px;}";
//  echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
//  echo " .shade {background-color: #C9DBDB;}";
//  echo ".unitHead {width: 33%; text-align: center;}";
//  echo ".headLeft {width: 33%; text-align: left;}";
//  echo ".headRight {width: 33%; text-align: right;}";
//  echo ".leftBuff {width: 300px;}";
//  echo ".rightBuff {width: 200px;}";
//  echo "h4, h5 {height: 20px;     margin: 0; padding: 0; border: 0;}";
//  echo ".back1 {background-color: #99FFCC}";
//  echo ".back2 {background-color: #FFFF66}";
//  echo ".back3 {background-color: #31a5d8}";
//  echo" </style></head><body>";
  
  $wkendDate = $recs[1];
  $wkEndForm = $recs[2];
  $unitName = $recs[3];
  $today = date("F d, Y");

  $empSql = "Select e.name, e.effdt, e.deptid, e.locid, e.eeType, t.eeTypeDescr, e.emplClass, e.payGrp from employees e, employeeTypes t";
  $empSql = $empSql ." where e.emplid = '$emplid' and e.unitId = '$unitId' and e.effdt = (select max(effdt) from employees e2 where e2.emplid = e.emplid and e2.effdt <= '$wkendDate')";
  $empSql = $empSql ." and t.unitId = e.unitId and t.eeType = e.eeType and t.effdt = (select max(effdt) from employeeTypes t2 where t2.unitId = t.unitId and t2.eeType = t.eeType and t2.effdt <= e.effdt)";
  $empRes = mysql_query($empSql) or die('select empployees failed: ' . mysql_error());
  $empRec = mysql_fetch_array($empRes, MYSQL_NUM);
  $name        = $empRec[0];
  $effdt       = $empRec[1];
  $deptid      = $empRec[2];
  $locid       = $empRec[3];
  $eeType      = $empRec[4];
  $eeTypeDescr = $empRec[5];
  $emplClass   = $empRec[6];
  $payGrp      = $empRec[7];

  echo "<strong>$emplid: $name  $emplClass/$payGrp  $eeTypeDescr</strong>";

  echo "<table border='1' width='500'>";
  $funcSql = "Select e.eventNum, f.funcNumWk, f.funcType, t2.funcDescr, e.eeType, t.eeTypeDescr, e.payGrp, e.baseWage";
  $funcSql = $funcSql ." from funcEmps e, events f, employeeTypes t, funcTypes t2";
  $funcSql = $funcSql ." where e.unitId = '$unitId' and e.emplid = '$emplid' and f.wkendDate = '$wkendDate' and e.eventNum = f.eventNum";
  $funcSql = $funcSql ." and t.unitId = e.unitId and t.eeType = e.eeType and t.effdt = (select max(effdt) from employeeTypes t2 where t2.unitId = t.unitId and t2.eeType = t.eeType and t2.effdt <= f.wkendDate)";
  $funcSql = $funcSql ." and t2.unitId = e.unitId and t2.funcType = f.funcType";
  $funcSql = $funcSql ." order by f.funcNumWk";
  $funcRes = mysql_query($funcSql) or die('select events failed: ' . mysql_error());
  $funcRows = mysql_num_rows($funcRes);
  while ($funcRec = mysql_fetch_array($funcRes, MYSQL_NUM)) {
     $eventNum     = $funcRec[0];
     $funcNumWk    = $funcRec[1];
     $funcType     = $funcRec[2];
     $funcDescr    = $funcRec[3];
     $eeType2      = $funcRec[4];
     $eeTypeDescr2 = $funcRec[5];
     $payGrp2      = $funcRec[6];
     $baseWage     = $funcRec[7];

     echo "<tr>";
     echo "<td class='char back1'>$eventNum </td>";
     echo "<td class='char back1'>$funcNumWk</td>";
     echo "<td class='char back1'>$funcDescr </td>";
     echo "<td class='char back1'>$eeTypeDescr2</td>";
     echo "<td class='char back1'>$payGrp2  </td>";
     echo "<td class='char back1'>$baseWage </td>";

     $empSql = "Select n.name, n.payGrp, p.emplClass from employees n, employeeTypes t, payGrp p";
     $empSql = $empSql ." where n.unitId = '$unitId' and n.emplid ='$emplid' and t.unitId = n.unitId and t.eeType = $eeType and t.eeBaseWage = 'Y'";
     $empSql = $empSql ." and p.unitId = n.unitId and p.payGrp = '$payGrp2'";
     $empRes = mysql_query($empSql) or die('select employees failed: ' . mysql_error());
     $empRows = mysql_num_rows($empRes);
     echo "<td class='back2'>";
     while ($empRec = mysql_fetch_array($empRes, MYSQL_NUM)) {
        $name       = $empRec[0];
        $payGrp3    = $empRec[1];
        $emplClass3 = $empRec[2];
        echo "$emplClass3<br/>";
     }
   
     $bwSql = "Select baseWage from baseWages b where unitId = '$unitId' and emplClass = '$emplClass3' and funcType = $funcType";
     $bwSql = $bwSql. " and effdt = (Select Max(effdt) from baseWages b2 where b2.unitId = b.unitId and b2.effdt <= '$wkendDate')";
     $bwRes = mysql_query($bwSql) or die('select base wage failed: ' . mysql_error());
     $bwRows = mysql_num_rows($bwRes);
     $bwRec = mysql_fetch_array($bwRes, MYSQL_NUM);
     $baseWage4 = $bwRec[0];
     
     echo "<td class='back3'>$baseWage4</td>";
     if ($baseWage != $baseWage4) 
        echo "<td class='char back3'>Off</td>";
     else
        echo "<td class='char back3'>&nbsp</td>";
//     echo "<td><a href='./formFuncEmps.php5?unitId=$unitId&eventNum=$eventNum&emplid=$emplid'>Edit</a></td>";
//     echo "<td><a href='javascript:void(0);' onclick='fillArea(\"$unitId\", \"formFuncEmps\", \"&eventNum=$eventNum&emplid=$emplid\")'>Edit</a></td>";
     echo '<td><a onclick="clearRight(); hide_right(); main_wide(); fillArea'. "('" . $unitId . "','formFuncEmps','&eventNum=". $eventNum ."&emplid=". $emplid ."','listarea', add_new_butts); "     . '" href="javascript:void(0);">'. "Edit" ."</a></td>";
     echo "</tr>";
     }
  echo "</table>";
?>