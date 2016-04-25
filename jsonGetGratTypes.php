<?php
  session_start();
  include("db.php5");

  //$unitId   = $_GET["unitId"];
  //$effdt    = $_GET["effdt"];
  error_reporting(E_ALL);
 
 // The JSON standard MIME header.
  header('Content-type: application/json');

  $json  = json_decode(file_get_contents('php://input'));
  $unitId = $json->unitId;
  $effdt  = $json->effdt;

  if ($unitId == "" || $effdt == "") {
    $msg = "Error: missing parms";
    echo "Error";
  } else {
     $topArr = array();
     //                    0         1            2           3          4           5
     $getSQL = "Select g.eeType, g.gratType, g.groupType, g.cutRate, g.netAcct, t.gratDescr from empGroups g, gratTypes t where g.unitId='$unitId' ";
//     $getSQL = $getSQL . "and g.effdt = (select max(effdt) from empGroups g2 where g2.unitId = g.unitId and g2.eeType = g.eeType and g2.gratType = g.gratType) ";
     $getSQL = $getSQL . "and t.unitId = g.unitId and t.gratType = g.gratType and g.effdt='$effdt'";
     $getSQL = $getSQL . "order by g.eeType, t.dispOrder";
     $rs=$db->query($getSQL);
     if ($rs === false) {
        echo('Wrong SQL: ' . $getSQL . ' Error: ' . $db->error); //, E_USER_ERROR);
     } else {
       $rows = $rs->num_rows;
       $rs->data_seek(0);
       $row = 0;
       while ($recs = $rs->fetch_row()) {
         $eeType          = $recs[0];
         $gratType        = $recs[1];
         $groupType       = $recs[2];
         $cutRate         = $recs[3];
         $netAcct         = $recs[4];
         $gratDescr       = $recs[5];
         $arrLine       = compact("eeType","gratType","groupType","cutRate","netAcct","gratDescr");
         $row++;

         $topArr[$row]=$arrLine;
       }
       echo json_encode($topArr);
    }
    $rs->free();
  }
?>
