<?php

//Report of functions for the week, detailing each employee, their pay, and totals for the function.

//  Genereic json Get

   session_start();
   $userId=$_SESSION['userId'];
   include("db.php5");
 
   // Prevent caching.
   header('Cache-Control: no-cache, must-revalidate');
   header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
   
   // This ID parameter is sent by our javascript client.
   $unitId   = $_GET['unitId'];
   $eventNum = $_GET['eventNum'];
   
   if ($userId == "") {
      echo "Please Logon";
   } else {
     if ($unitId == "") {
         echo "Missing Parameters";
      } else {
         //                      0         1                    2                             3            
        $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
        $result = $db->query($getSQL);
        $recs = $result->fetch_row();
        
        echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
        echo "table {width: 1300px;}";
        echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
        echo " .shade {background-color: #C9DBDB;}";
        // #CBCBCB;}";
        // #C9DBDB;}";
        echo ".unitHead {width: 33%; text-align: center;}";
        echo ".headLeft {width: 33%; text-align: left;}";
        echo ".headRight {width: 33%; text-align: right;}";
        echo ".leftBuff {width: 300px;}";
        echo ".rightBuff {width: 200px;}";
        echo "h4, h5 {height: 20px;     margin: 0; padding: 0; border: 0;}";
        echo" </style></head><body>";
        
        if ($eventNum != "all" && $eventNum != NULL)
           $eventWhere = " and eventNum = '$eventNum' ";
        
        $wkendDate = $recs[1];
        $wkEndForm = $recs[2];
        $unitName = $recs[3];
        $today = date("F d, Y");
        $pageCnt = 0;
        //                    0           1            2           3           4           5           6              7           8           9          10         11          12          13                 14                         15
        $getSQL = "Select e.eventNum, e.funcNumWk, e.funcDate, e.roomNum, r.roomDescr, e.funcType, f.funcDescr, e.foodCheck, e.barCheck, e.foodBill, e.barBill, e.foodGrat, e.barGrat, e.totCovers, date_format(e.funcDate, '%M %d, %Y'), e.numBodies, e.rateDate";
        $getSQL = $getSQL ." from events e, rooms r, funcTypes f where e.unitId='$unitId' $eventWhere and e.wkendDate = '$wkendDate' and r.unitId = e.unitId and r.roomNum = e.roomNum  and f.unitId = e.unitId and f.funcType = e.funcType order by funcNumWk";
        $result = $db->query($getSQL);
        $rows = $result->num_rows;
        
       echo "rows:" . $rows; 
        while ($recs = $result->fetch_row()) {
              $eventNum  = $recs[0];
              $grats = array();
              $gratsCnt = 0;
              $gratHead = "";
              $grat1 = "N";
              $grat2 = "N";
              $grat3 = "N";
              $gratHead1 = "";
              $gratHead2 = "";
              $gratHead3 = "";
              //                      0          1           2           3           4           5           6            7
              $gratSQL = "Select g.eventNum, g.gratSeq, g.gratType, gt.gratDescr, g.checkNum, g.checkAmt, g.gratAmt, g.gratAddl";
              $gratSQL = $gratSQL . " from funcGrats g, gratTypes gt where g.unitId='$unitId' and g.eventNum = $eventNum and gt.unitId = g.unitId and gt.gratType = g.gratType order by g.gratSeq";
              $gratRes = $db->query($gratSQL);
              while ($gratRec = $gratRes->fetch_row()) {
                    $gratSeq   = $gratRec[1];
                    $gratType  = $gratRec[2];
                    $gratDescr = $gratRec[3];
                    $checkNum  = $gratRec[4];
                    $checkAmt  = $gratRec[5];
                    $gratAmt   = $gratRec[6];
                    $gratAddl  = $gratRec[7];
                    if ($gratType != "X") {
                       $gratHead = $gratHead . "<th>" . $gratDescr . " Grat</th>";
                       $gratsCnt++;
        // <td class='char'><h5>Food Check #: $recs[7]</h5></td><td class='char'><h5>Bar Check #: $recs[8]</h5></td>
                       $gratHead1 = $gratHead1 . "<td class='char'><h5>$gratDescr Check#: $checkNum </h5></td> ";
                       $gratHead2 = $gratHead2 . "<td class='char'><h5>$gratDescr Amount: $checkAmt</h5></td> ";
                       $gratHead3 = $gratHead3 . "<td class='char'><h5>$gratDescr Gratuity: $gratAmt</h5></td> ";
                       if ($gratSeq == 0)
                          $grat1 = "Y";
                       if ($gratSeq == 1) 
                          $grat2 = "Y";
                       if ($gratSeq == 2) 
                          $grat3 = "Y";
                    }
              }
              
              $cntsHead="";
              $sep="";
              $cntsSQL = "Select c.eeType, t.eeTypeDescr, t.eeTypePlr, c.numBodies from funcEmpCnts c, employeeTypes t where c.unitId = '$unitId' and c.eventNum = $eventNum and c.numBodies > 0 and t.unitId = c.unitId and t.eeType = c.eeType and t.effdt = (select max(effdt) from employeeTypes t2 where t2.unitId = t.unitId and t2.eeType = t.eeType) order by c.numBodies desc";
              $cntsRes = $db->query($cntsSQL);
              while ($cntsRec = $cntsRes->fetch_row()) {
                 if ($cntsRec[3] > 1)
                   $cntsHead = $cntsHead . $sep . $cntsRec[3] ." $cntsRec[2]";
                 else
                   $cntsHead = $cntsHead . $sep . $cntsRec[3] ." $cntsRec[1]";
                 $sep="; ";
              }
        
        //                           0       1         2        3           4             5          6            7            8             9           10            11           12           13           14           15          16           17             18             19          20          21         22        23           24          25         26           27
              $detsSQL = "Select e.emplid, n.name, e.empSeq, e.eeType, t.eeTypeDescr, e.payGrp, e.emplClass, e.grat1Rate, e.grat1Group, e.grat1Cut, e.grat2Rate, e.grat2Group, e.grat2Cut, e.grat3Rate, e.grat3Group, e.grat3Cut, e.getSetup, e.getClear, e.getExtra, e.eeBaseWage, e.coversAllowed, e.eeCovers, e.eeWeight, e.baseWage, e.hours, e.setupAmt, e.clearAmt, e.extraAmt,  e.totalPay from funcEmps e, employees n, employeeTypes t where e.eventNum = $recs[0] and n.unitId = e.UnitId and n.emplid = e.emplid and t.unitId = e.unitId and t.eeType = e.eeType and t.effdt = (select max(effdt) from employeeTypes t2 where t2.unitId = t.unitId and t2.eeType = t.eeType) order by empSeq";
              $detsResult = $db->query($detsSQL);
              $rows = $detsResult->num_rows;
        
              $lineCnt = 0;
              $printCnt = 0;
              $eeCoversT  = 0;
              $eeWeightT  = 0;
              $baseWageT  = 0;
              $hoursT     = 0;
              $setupAmtT  = 0;
              $clearAmtT  = 0;
              $extraAmtT  = 0;
              $grat1CutT  = 0;
              $grat2CutT  = 0;
              $grat3CutT  = 0;
              $totalPayT  = 0;
              $totalWagesT= 0;
               
              $eventEmpCnt = 0;
              if ($pageCnt > 0)
                 echo "</table><span class='page-break'></span>";
              while ($detsRecs = $detsResult->fetch_row()) {
        
                if ($lineCnt == 0) {
                   $pageCnt++;
                   echo "<table>";
                   echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
                   echo "<tr><td class='headLeft'><h4>Function Details</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
                   echo "<tr><td class='headLeft'><h4>Function Date: $recs[14]</h4></td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
        //           echo "<tr><td class='headLeft'><h4>Function Number: $recs[1]</h4></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
                   echo "</table>";
                   echo "<table>";
                   echo "<tr><td class='leftBuff char'><h4>Function Number: $recs[1]</h4></td> <td class='char'><h5> Room: $recs[4] $recs[6]</h5></td> $gratHead1 <td class='rightBuff'><h4>Page: $pageCnt</h4></td></tr>";
        //           echo "<tr><td class='leftBuff'></td><td class='char'><h5> Room: $recs[4] $recs[6]</h5></td> $gratHead1  <td class='rightBuff'></td></tr>";
                   echo "<tr><td class='leftBuff char'><h4>Rate Date: $recs[16]</h4></td><td class='char'><h5>Tip Covers: $recs[13]</h5></td> $gratHead2 <td class='rightBuff'></td></tr>";
//                   echo "<tr><td class='leftBuff'></td><td class='char'><h5>Tip Covers: $recs[13]</h5></td> $gratHead2 <td class='rightBuff'></td></tr>";
                   echo "<tr><td class='leftBuff'></td><td class='char'><h5>$cntsHead</h5></td> $gratHead3<td class='rightBuff'></td></tr>";
                   echo "<tr></tr>";
                   echo "</table>";
                   
                   echo "<table>";
                   echo "<tr><th width='200px'>Employee</th><th>Emplid</th><th>Role</th><th>Covers</th><th>Base Wage</th><th>Hours</th><th>Setup</th><th>Clear</th><th>Extra</th><th>Total</th>$gratHead<th>Total Pay</th></tr>";
                  }
        
                $lineCnt++;
                
                $emplid         = $detsRecs[0];
                $name           = $detsRecs[1];
                $empSeq         = $detsRecs[2];
                $eeType         = $detsRecs[3];
                $eeTypeDescr    = $detsRecs[4];
                $payGrp         = $detsRecs[5];
                $emplClass      = $detsRecs[6];
                $grat1Rate      = $detsRecs[7];
                $grat1Group     = $detsRecs[8];
                $grat1Cut       = $detsRecs[9];
                $grat2Rate      = $detsRecs[10];
                $grat2Group     = $detsRecs[11];
                $grat2Cut       = $detsRecs[12];
                $grat3Rate      = $detsRecs[13];
                $grat3Group     = $detsRecs[14];
                $grat3Cut       = $detsRecs[15];
                $getSetup       = $detsRecs[16];
                $getClear       = $detsRecs[17];
                $getExtra       = $detsRecs[18];
                $eeBaseWage     = $detsRecs[19];
                $coversAllowed  = $detsRecs[20];
                $eeCovers       = $detsRecs[21];
                $eeWeight       = $detsRecs[22];
                $baseWage       = $detsRecs[23];
                $hours          = $detsRecs[24];
                $setupAmt       = $detsRecs[25];
                $clearAmt       = $detsRecs[26];
                $extraAmt       = $detsRecs[27];
                $totalPay       = $detsRecs[28];
                
                if ($lineCnt / 2 == round($lineCnt /2, 0)) {
                        $className = "shade";
                } else {
                        $className = "";
                }
                
                $totalWages = $baseWage + $setupAmt + $clearAmt + $extraAmt;
                
                echo "<tr class='$className'><td width='200px' class='char'>$name</td><td class='char'>$emplid</td>";
                echo "<td class='char'>$eeTypeDescr</td><td class='numfld'>";
                echo number_format($eeCovers,0) ."</td><td class='numfld'>";
                echo number_format($baseWage,2) ."</td><td class='numfld'>";
                echo number_format($hours,2) ."</td><td class='numfld'>";
                echo number_format($setupAmt,2) ."</td><td class='numfld'>";
                echo number_format($clearAmt,2) ."</td><td class='numfld'>";
                echo number_format($extraAmt,2) ."</td><td class='numfld'>";
                echo number_format($totalWages,2) ."</td><td class='numfld'>";
                if ($grat1 == "Y")
                   echo number_format($grat1Cut,2) ."</td><td class='numfld'>";
                if ($grat2 == "Y")
                   echo number_format($grat2Cut,2) ."</td><td class='numfld'>";
                if ($grat3 == "Y")
                   echo number_format($grat3Cut,2) ."</td><td class='numfld'>";
                echo number_format($totalPay,2) ."</td></tr>";
                $eventEmpCnt = $eventEmpCnt + 1;
                $printCnt++;
                $eeCoversT  = $eeCoversT + $eeCovers;
                $eeWeightT  = $eeWeightT + $eeWeight;
                $baseWageT  = $baseWageT + $baseWage;
                $hoursT     = $hoursT    + $hours;
                $setupAmtT  = $setupAmtT + $setupAmt;
                $clearAmtT  = $clearAmtT + $clearAmt;
                $extraAmtT  = $extraAmtT + $extraAmt;
                $grat1CutT  = $grat1CutT + $grat1Cut;
                $grat2CutT  = $grat2CutT + $grat2Cut;
                $grat3CutT  = $grat3CutT + $grat3Cut;
                $totalPayT  = $totalPayT + $totalPay;
                $totalWagesT= $totalWagesT+ $totalWages;
                
                if ($lineCnt == 30) {
                        echo "</table><span class='page-break'></span>";
                   $lineCnt = 0;
                }
             }
             if ($className == "shade") {
                $className = "";
                } else {
                $className = "shade";
                }
             if ($eventEmpCnt > 0) {
                echo "<tr class='$className'><td width='200px' class='char'></td><td></td><td class='char'>Totals</td><td class='numfld'>";
                echo number_format($eeCoversT,0) ."</td><td class='numfld'>";
                echo number_format($baseWageT,2) ."</td><td class='numfld'>";
                echo number_format($hoursT,2) ."</td><td class='numfld'>";
                echo number_format($setupAmtT,2) ."</td><td class='numfld'>";
                echo number_format($clearAmtT,2) ."</td><td class='numfld'>";
                echo number_format($extraAmtT,2) ."</td><td class='numfld'>";
                echo number_format($totalWagesT,2) ."</td><td class='numfld'>";
                if ($grat1 == "Y")
                   echo number_format($grat1CutT,2) ."</td><td class='numfld'>";
                if ($grat2 == "Y")
                   echo number_format($grat2CutT,2) ."</td><td class='numfld'>";
                if ($grat3 == "Y")
                   echo number_format($grat3CutT,2) ."</td><td class='numfld'>";
                echo number_format($totalPayT,2) ."</td></tr>";
             }
        
             echo "</table>";
        }
        echo "<script>window.print();</script></body></html>";
     }
   }
?>
