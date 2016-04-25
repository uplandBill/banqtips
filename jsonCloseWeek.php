<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

  $unitId = $_GET['unitId'];

  // Prevent caching.
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
  
  // The JSON standard MIME header.
  header('Content-type: application/json');

  if ($userId == "") {
     $result="Error";
     $msg="Please Logon";
  } else {
    if ($unitId == "") {
       $result="Error";
       $msg="Missing Parameters";
    } else {
       //                      0         1                        2                        3            4
       $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u ";
       $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
       $getRes = $db->query($getSQL);
       $rows   = $getRes->num_rows;
       $recs   = $getRes->fetch_row();
       $wkendDate = $recs[1];
       $wkEndForm = $recs[2];
       $unitName  = $recs[3];
       $csvFormat = $recs[4];
       if ($rows > 0){
          $closeWeek = "update wkendCal set weekStatus='C' where unitId = '$unitId' and wkendDate = '$wkendDate'";
          $closeRes = $db->query($closeWeek);
          $result="Success";
          $msg="Week Closed";
       } else {
          $result="Warning";
          $msg="No open week found";
       }
    }
  }
  $resultsArr = compact("unitId", "result", "msg");
  echo json_encode($resultsArr);
?>
