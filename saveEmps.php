<?php
  session_start();
  include("db.php5");

  // test line added

  $unitId    = $_POST['unitId'];
  $emplid    = $_POST['emplid'];
  $effdt     = $_POST['effdt'];
  $name      = $_POST['name'];
  $deptId    = $_POST['deptId'];
  $locId     = $_POST['locId'];
  $emplStatus= $_POST['emplStatus'];
  $eeType    = $_POST['eeType'];
  $emplClass = $_POST['emplClass'];
  $payGrp    = $_POST["payGrp"];
  $jobcode   = $_POST["jobcode"];

  if ($locId == "")
     $locId = " ";
  if ($emplClass == "")
     $emplClass = " ";
  if ($name == "")
     $name = " ";

  if (substr($effdt, 2, 1) == "/") {    //format difference in selection vs loading from DB
     $effdt = substr($effdt, 6, 4) .'-'. substr($effdt, 0, 2) .'-'. substr($effdt, 3, 2);
  }

  if ($emplid == "xnewx")
     echo "Please assign an employee id before saving.";
  else
    if ($name == " " || $name=="")
       echo "Please enter a name before saving.";
    else
       if ($unitId == "")
          echo "Error: Missing Unit Id";
       else
          if ($emplid == "")
             echo "Error: Missing Emplid";
          else 
             if ($effdt == "0000-00-00")
                echo "Error: Missing Effective Date";
             else {
                 $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
                 $db_selected = mysql_select_db($dbname);
              
                 $updEe  = "replace into employees (unitId, emplid, effdt, name, deptId, locId, emplStatus, eeType, emplClass, payGrp, jobcode) ";
                 $updEe  = $updEe . "values('$unitId', '$emplid', '$effdt', '$name', '$deptId', '$locId', '$emplStatus', '$eeType', '$emplClass', '$payGrp', '$jobcode')";
                 $updateRes = mysql_query($updEe) or die('update employee failed: ' . mysql_error());
                 echo "Saved:$emplid-$effdt";
             }
?>