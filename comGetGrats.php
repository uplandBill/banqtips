<?php
$gratTypes = array();
$miscCodes = array();
$miscTots = array();    //     0         1
$miscSql = "select distinct gratType, miscCode from gratTypes where unitId = '$unitId'"; 
$miscRes = $db->query($miscSql);
$miscCnt = 0;
while ($gratRec = $miscRes->fetch_row()) {
    $miscCnt++;
    $gratType = $gratRec[0];
    $miscCode = $gratRec[1];
    $gratTypes[$miscCnt] = $gratType;
    $miscCodes[$miscCnt] = $miscCode;
    $miscTots[$miscCode] = 0;
}

$grats = array();
$gratsDescrs = array();
$gratTots = array();
$gratCnt = 0;
//                     Load the different Grats used for the entire week
//                      0             1             2             3         4
$gratSQL = "Select g.gratType, gt.gratDescr, gt.dispOrder, gt.miscCode, count(*)";
$gratSQL = $gratSQL ." from events e, funcGrats g, gratTypes gt, funcTypes ft";
$gratSQL = $gratSQL ." where e.unitId='$unitId' and e.wkendDate ='$wkendDate'";
$gratSQL = $gratSQL ." and g.unitId = e.unitId  and g.eventNum = e.eventNum";
$gratSQL = $gratSQL ." and ft.unitId = e.unitId and ft.funcType = e.funcType";
if ($funcGroup != NULL)
  $gratSQL = $gratSQL ." and ft.funcGroup = '$funcGroup'";
$gratSQL = $gratSQL ." and gt.unitId = g.unitId and gt.gratType = g.gratType group by g.gratType, gt.gratDescr, gt.dispOrder order by 5 desc, 3 asc";
$gratRes = $db->query($gratSQL);
while ($gratRec = $gratRes->fetch_row()) {
      $gratType  = $gratRec[0];
      $gratDescr = $gratRec[1];
      $miscCode  = $gratRec[3];
      $count     = $gratRec[4];
      if ($gratType != "X") {
         $gratCnt++;
         $grats[$gratCnt] = $gratType;
         $gratsDescrs[$gratCnt] = $gratDescr;
         $repHeads = $repHeads . "<th>" . $gratDescr . "</th>";
      }
}
?>
