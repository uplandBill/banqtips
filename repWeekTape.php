<?php

//Report of daily of summary gratuities

//  Genereic json Get

  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");
 
  // Prevent caching.
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

  // This ID parameter is sent by our javascript client.
  $unitId   = $_GET['unitId'];

  if ($userId == "") {
    echo "Please Logon";
  } else {
    if ($unitId == "") {
      echo "Missing Parameters";
    } else {
      echo "<html><head><style>body {font: 12px Bookman, serif;} @media all {.page-break {display: none}} @media print {.page-break {display: block; page-break-after: always;}} td {text-align: right; } td.char {text-align: left;}";
      echo "table {width: 1100px;}";
      echo " .shadow {  -moz-box-shadow:3px 3px 5px 6px #666666;  -webkit-box-shadow: 3px 3px 5px 6px #666666;  box-shadow: 5px 5px 5px 6px #666666;}";
      echo " .shade {background-color: #C9DBDB;}";
      echo ".unitHead {width: 33%; text-align: center;}";
      echo ".headLeft {width: 33%; text-align: left;}";
      echo ".headRight {width: 33%; text-align: right;}";
      echo ".leftBuff {width: 300px;}";
      echo ".rightBuff {width: 200px;}";
      echo "h4, h5 {height: 20px;     margin: 0; padding: 0; border: 0;}";
      echo" </style></head><body>";
        
      include("comGetWkOpen.php");  // $wkendDate $wkEndForm $unitName $csvFormat $weekStatus 
      
      if ($wkendDate != "") {

        $funcGroupSql = "Select funcGroup, descr from funcGroups where unitId = '$unitId' order by funcGroup";
        $fgRes   = $db->query($funcGroupSql);
        $fgRows  = $fgRes->num_rows;
        $break = "N";
        while ($fgRec = $fgRes->fetch_row()) {
          $fgDescr   = $fgRec[1];
          $funcGroup = $fgRec[0];
          $printCnt  = 0;

          include("comGetGrats.php");

          $today = date("F d, Y");
          $pageCnt = 1;
          if ($break == "Y")
            echo "><span class='page-break'></span>";

          echo "<table class='fullReport'>";
          echo "<tr><td></td><td class='unitHead'><h2>$unitName</h2></td><td></td></tr>";
          echo "<tr><td class='headLeft'><h4>Tape - Audit</h4></td><td></td><td class='headRight'><h4>Run Date: $today</h4></td></tr>";
          echo "<tr><td class='headLeft'>$fgDescr</td><td></td><td class='headRight'><h4>Weekending Date: $wkEndForm</h4></td></tr>";
          echo "<tr><td class='headLeft'></td><td></td><td class='headRight'><h4>Page: $pageCnt</h4></td></tr>";
          echo "</table>";

          echo "<table>";
          echo "<tr><td>Date</td>";
          for ($i=1; $i<=$gratCnt; $i++) {
             echo "<td>". $gratsDescrs[$i] ."</td>";
          }
          echo "<td>Emp Totals</td>";
          echo "<td>Func Totals</td>";
          echo "<td>Audit</td>";
          echo "</tr>";
           
          $today = date("F d, Y");
          $pageCnt = 0;
          //                    0           1            2           3           4           5           6              7           8           9          10  
          //                      11          12          13                    14
          $wkSQL = "Select e.eventNum, e.funcNumWk, e.funcDate, e.roomNum, r.roomDescr, e.funcType, f.funcDescr, e.foodCheck, e.barCheck, e.foodBill, e.barBill,";
          $wkSQL = $wkSQL ." e.foodGrat, e.barGrat, e.totCovers, date_format(e.funcDate, '%M %d, %Y')";
          $wkSQL = $wkSQL ." from events e, rooms r, funcTypes f";
          $wkSQL = $wkSQL ." where e.unitId='$unitId' and e.wkendDate = '$wkendDate'";
          $wkSQL = $wkSQL ." and r.unitId = e.unitId and r.roomNum = e.roomNum  and f.unitId = e.unitId and f.funcType = e.funcType";
          $wkSQL = $wkSQL ." and f.funcGroup = '$funcGroup'";
          $wkSQL = $wkSQL ." order by funcDate, funcNumWk";
          $wkRes = $db->query($wkSQL);
          $rows  = $wkRes->num_rows;
          $prevDate = "";
          $weekTots = array();
           
          while ($recs = $wkRes->fetch_row()) {
            $eventNum = $recs[0];
            $funcDate = $recs[2];
            $gratsCnt = 0;
            $gratHead = "";
            $grat1 = "N";
            $grat2 = "N";
            $grat3 = "N";
            $gratHead1 = "";
            $gratHead2 = "";
            $gratHead3 = "";
            $printCnt++;
                 
            if ($funcDate != $prevDate) {
              if ($prevDate != "") {
                echo "<tr>";
                echo "<td>$prevDate</td>";
                $total = 0;
                for ($i=1; $i<=$gratCnt; $i++) {
                   echo "<td>". number_format($dailyArr[$i], 2) ."</td>";
                   $total = $total + $dailyArr[$i];
                }
                echo "<td>". number_format($total, 2) ."</td>";
                echo "<td>". number_format($totGrats, 2) ."</td>";
                $diff = $total - $totGrats;
                if ($diff > .01 || $diff < -0.01) {
                  echo "<td>***(". number_format($diff, 2) .")</td>";
                } else
                  echo "<td>&nbsp;</td>";
                echo "</tr>";
              }
              $prevDate = $funcDate;
              $dailyArr = array();
              $totGrats = 0;
            }
                 
            $gratsLine=array();
            for ($i=1; $i<=$gratCnt; $i++) {
              $gratType = $grats[$i];
              $gratSQL = "Select g.gratAmt from funcGrats g";
              $gratSQL = $gratSQL ." where g.unitId='$unitId' and g.eventNum = $eventNum and g.gratType = '$gratType'";
              $gratRes = $db->query($gratSQL);
              $gratRec = $gratRes->fetch_row();
              $gratAmt = $gratRec[0];
              $totGrats = $totGrats + $gratAmt;
              $weekTots[$gratCnt +1] = $weekTots[$gratCnt +1] + $gratAmt;
            
              $gratType = $grats[$i];
              $gratsWeek = "Select sum(e.gratAmt) from funcEmpGrats e, events f where f.unitId='$unitId' and f.eventNum = $eventNum and e.unitId = f.unitId";
              $gratsWeek = $gratsWeek ." and e.eventNum = f.eventNum and e.gratType = '$gratType'";
              $gratsRes = $db->query($gratsWeek);
              $gratsRec = $gratsRes->fetch_row();
              $gratAmt2=$gratsRec[0];
              $dailyArr[$i] = $dailyArr[$i] + $gratAmt2;
              $weekTots[$i] = $weekTots[$i] + $gratAmt2;
            }
          }

          if ($printCnt > 0) {
          echo "<tr>";
          echo "<td>$prevDate</td>";
          $total = 0;
          for ($i=1; $i<=$gratCnt; $i++) {
             echo "<td>". number_format($dailyArr[$i], 2) ."</td>";
             $total = $total + $dailyArr[$i];
          }
          echo "<td>". number_format($total, 2) ."</td>";
          echo "<td>". number_format($totGrats, 2) ."</td>";
          $diff = $total - $totGrats;
          if ($diff > .01 || $diff < -0.01) {
             echo "<td>***(". number_format($diff, 2) .")</td>";
             }
          else
             echo "<td>&nbsp;</td>";
          echo "</tr>";

          echo "<tr></tr>";
          echo "<tr>";
          echo "<td>Totals</td>";
          $total = 0;
          for ($i=1; $i<=$gratCnt; $i++) {
             echo "<td>". number_format($weekTots[$i], 2) ."</td>";
             $total = $total + $weekTots[$i];
          }
          echo "<td>". number_format($total, 2) ."</td>";
          echo "<td>". number_format($weekTots[$gratCnt +1], 2) ."</td>";
          $diff = $total - $weekTots[$gratCnt +1];
          if ($diff > .01 || $diff < -0.01) {
            echo "<td>***(". number_format($diff, 2) .")</td>";
          }
          else
            echo "<td>&nbsp;</td>";
          echo "</tr>";

          echo "</table>";
          $break = "Y";
          }
//          echo "</table><span class='page-break'></span>";
        } //end funcGroup loop
        echo "<script>window.print();</script></body>";
      } else {
        echo "No Open Week.";
      }
   }
 }
?>
