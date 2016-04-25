<?php
  session_start();
  include("db.php5");
 
  $unitId = $_GET['unitId'];
  $extra  = $_GET['extra'];
  $func = $_GET['func'];

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

  $topArr=array();
  
  $buttArr=array();
  $aButt=array();
  
  $aButt["img"]  = "./images/allButton.gif";
  $aButt["opt"]  = "A";
  $buttArr["b1"] = $aButt;
  
  $aButt["img"]  = "./images/waitButton.gif";
  $aButt["opt"]  = "3";
  $buttArr["b2"] = $aButt;

  $aButt["img"]  = "./images/capButton.gif";
  $aButt["opt"]  = "1";
  $buttArr["b3"] = $aButt;
  
  $aButt["img"]  = "./images/barButton.png";
  $aButt["opt"]  = "4";
  $buttArr["b4"] = $aButt;
  
  $topArr["buttons"] = $buttArr;
  
  //                  0         1             2         3         4         5
  $eelist = "Select e.name, t.eeTypeDescr, e.emplid, t.eeType, e.payGrp, e.emplClass from employees e, employeeTypes t, depts d";
  $eelist =  $eelist ." where e.unitId='$unitId' and e.emplStatus = 'A' and t.unitId = e.unitId and t.eeType = e.eeType and d.unitId = e.unitId and d.deptId = e.deptId";
  $eelist =  $eelist ." and d.effdt = (select max(effdt) from depts d1 where d1.unitId = d.unitId and d1.deptid = d.deptid)";
  $eelist =  $eelist ." order by substr(name,1,1), eeTypeDescr, name";
  $result = $db->query($eelist);
  $rows = $result->num_rows;

  $empList=array();     
  $empScrolls=array();
  $prevLetter=0;
  $rowCount=0;
  while ($ee = $result->fetch_row()) {
       $name    = $ee[0];
       $role    = $ee[1];
       $emplid  = $ee[2];
       $type    = $ee[3];
       $payGrp  = $ee[4];
       $class   = $ee[5];
       
       $arrLine = compact("name", "role", "type", "payGrp", "class");
       $empList[$emplid] = $arrLine;

  	$firstLet = strtoupper(substr($ee[0],0,1));
  	$rowCount++;
  	if ($firstLet <> $prevLetter) {
  	   $empScrolls[$firstLet]=$rowCount;
//  	   echo "<p>$firstLet - $rowCount</p>";
  	}
  	$prevLetter=$firstLet;
  }
  $topArr["empList"]=$empList;
  $topArr["letters"]=$empScrolls;
  
  
  echo json_encode($topArr);

//  if ($extra == "y") {
//     echo "<div id='empAlphas'><img class='empChars' letter='0' src='./images/letterA.png'/>";
//     for ($i=2; $i<27; $i++) {
//       if ($empScrolls[$i]>0) {
//         echo "<img class='empChars' letter='$empScrolls[$i]' src='./images/letter" .chr($i + 64). ".png'/>";
//       }
//     }
//       echo "</div>";
//   }
?>
