<?php
  session_start();

  $unitId   = $_GET['unitId'];
  $eventNum = $_GET['eventNum'];

  include("db.php5");
//                      0         1                    2                             3            
  $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
  $result = $db->query($getSQL);
  $recs = $result->fetch_row();
  
//  echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
//  echo "table {width: 1300px;}";
//  echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
//  echo " .shade {background-color: #C9DBDB;}";
//  // #CBCBCB;}";
//  // #C9DBDB;}";
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
  
  $eventClause = "";
  if ($eventNum != "all" && $eventNum != NULL)
     $eventClause = " and e.eventNum = '$eventNum' ";
  
  $wkendDate = $recs[1];
  $wkEndForm = $recs[2];
  $unitName = $recs[3];
  $today = date("F d, Y");

  echo "<table border='1'>";
  $funcSql = "Select e.eventNum, e.funcNumWk, e.funcType, t.funcDescr from events e, funcTypes t";
  $funcSql = $funcSql ." where e.unitId = '$unitId' and e.wkendDate = '$wkendDate' $eventClause and t.unitId = e.unitId and t.funcType = e.funcType";
  $funcRes = $db->query($funcSql);
  $funcRows = $funcRes->num_rows;
  echo "<p>Checking " . $funcRows . " events.";
  $discreps=0;
  while ($funcRec = $funcRes->fetch_row()) {
     $eventNum  = $funcRec[0];
     $funcNumWk = $funcRec[1];
     $funcType  = $funcRec[2];
     $funcDescr = $funcRec[3];

     $empSql = "Select e.empSeq, e.emplid, n.name, n.emplClass, e.emplClass, e.eeType, e.baseWage, n.payGrp, e.payGrp, p.emplClass";
     $empSql = $empSql ." from funcEmps e, employees n, employeeTypes t, payGrp p";
     $empSql = $empSql ." where e.unitId = '$unitId' and e.eventNum = $eventNum and n.unitId = e.unitId and n.emplid = e.emplid and n.effdt = (select max(effdt) from employees n2 where n2.emplid = n.emplid and n2.effdt <= '$wkendDate')";
     $empSql = $empSql ." and t.unitId = e.unitId and t.eeType = e.eeType and t.eeBaseWage = 'Y'";
     $empSql = $empSql ." and p.unitId = e.unitId and p.payGrp = e.payGrp order by e.empSeq ";
     $empRes = $db->query($empSql);
     $empRows = $empRes->num_rows;
     while ($empRec = $empRes->fetch_row()) {
        $empSeq    = $empRec[0];
        $emplid    = $empRec[1];
        $name      = $empRec[2];
        $ec        = $empRec[3];
        $ec2       = $empRec[4];
        $eeType    = $empRec[5];
        $baseWage  = $empRec[6];
        $payGrp    = $empRec[7];
        $payGrp2   = $empRec[8];
        $emplClass = $empRec[9];
   
        $bwSql = "Select baseWage from baseWages b where unitId = '$unitId' and emplClass = '$emplClass' and funcType = $funcType";
        $bwSql = $bwSql ." and effdt = (Select Max(effdt) from baseWages b2 where b2.unitId = b.unitId and b2.effdt <= '$wkendDate')";
        $bwRes = $db->query($bwSql);
        $bwRows = $bwRes->num_rows;
        $bwRec = $bwRes->fetch_row();
        $baseWage2 = $bwRec[0];
        
        if ($baseWage != $baseWage2) {
           echo "<tr><td class='char back1'>";
//           echo "<a href='javascript:void(0);' onclick='fillArea(\"$unitId\", \"auditEmpBW\", \"&emplid=$emplid\")'>$emplid</a></td>";
           echo '<a onclick="clearRight(); hide_right(); main_wide(); fillArea'. "('" . $unitId . "','auditEmpBW','&emplid=". $emplid ."','listarea', add_new_butts); "     . '" href="javascript:void(0);">'. $emplid ."</a>";
           echo "<td class='char back1'>$name / $ec / $payGrp</td>";
	   echo "<td>$eventNum : $funcNumWk</td><td>$payGrp</td><td>$funcDescr</td><td>$emplClass : $ec</td><td class='back2'>$baseWage</td><td class='back3'>$baseWage2</td></tr>";
	   $discreps += 1;
        }
     
     }
  }
  echo "</table>";
  echo $discreps . " discrepancies found.";
?>
