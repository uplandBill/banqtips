<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $extra  = $_GET['extra'];
  $func = $_GET['func'];

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db($dbname);
//                   0           1           2          3          
//                                                      0          1         2
  $eelist = "Select e.name, t.eeTypeDescr, e.emplid, t.eeType, e.payGrp, e.emplClass from employees e, employeeTypes t, depts d where e.unitId='$unitId' and t.unitId = e.unitId and t.eeType = e.eeType and d.unitId = e.unitId and d.deptId = e.deptId and d.effdt = (select max(effdt) from depts d1 where d1.unitId = d.unitId and d1.deptid = d.deptid) order by eeTypeDescr, name";
  $result = mysql_query($eelist) or die('select ee list failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  if ($extra == "y") {
     echo "<div id='empListButts' lcass='empListButts'><img src='./images/allButton.gif'/><img src='./images/waitButton.gif' id='waitButton'/><img src='./images/capButton.gif' id='capButtton'/></div>";
     echo "<div class='empListing' id='empListing'>";
     }
   else
     echo "<div class='empListing' id='empListingx'>";

  if ($extra == "y") 
     echo "<table class='empList' id='empList'>";
  else
     echo "<table class='empList' id='empList2'>";
  $rowcl=1;
  $empScrolls=array();
  $prevLetter=0;
  $rowCount=0;
  while ($ee = mysql_fetch_array($result, MYSQL_NUM)) {
  	if ($ee[3] == "Y")
  	   $covers = "covers";
  	else
  	   $covers = "";
        if ($extra == "y") 
           echo "<tr><td class='row$rowcl multiVal $covers' id='$ee[2]' empid='$ee[2]' name='$ee[3]:$ee[4]:$ee[5]'>$ee[0]: $ee[1]</td></tr>";
        else
           echo "<tr><td class='row$rowcl multiVal $covers' id='p$ee[2]' empid='$ee[2]' name='$ee[3]:$ee[4]:$ee[5]'>$ee[0]: $ee[1]</td></tr>";
  	$rowcl = 3 - $rowcl;
  	$firstLet = ord(strtoupper(substr($ee[0],0,1))) - 64;
  	if ($firstLet <> $prevLetter) {
  	   $empScrolls[$firstLet]=$rowCount;
 //	   echo "<td>".substr($ee[0],0,1)." - ".$rowCount."</td>";
 //    $rowCount++;
  	}
  	$rowCount=$rowCount+1;
  	$prevLetter=$firstLet;
  }
  echo "</table>";
  echo "</div>";
  
  if ($extra == "y") {
     echo "<div id='empAlphas' class='empAlphas' listid='empListing'><img class='empChars' letter='0' src='./images/letterA.png'/>";
     for ($i=2; $i<27; $i++) {
       if ($empScrolls[$i]>0) {
         echo "<img class='empChars' letter='$empScrolls[$i]' src='./images/letter" .chr($i + 64). ".png'/>";
       }
     }
       echo "</div>";
   }
?>