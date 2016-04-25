<?php
  session_start();
  $userId = $_SESSION['userId'];
  include("db.php5");

  require('incEraseFunc.php');

  $conn = new mysqli($hostname, $username, $password, $dbname);
  // check connection
  if ($conn->connect_error) {
     trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
  }

  error_reporting(E_ALL);
  date_default_timezone_set('America/New_York');
 
// The JSON standard MIME header.
//  header('Content-type: application/json');

  $json  = json_decode(file_get_contents('php://input'));
  $unitId   = $json->unitId;
  $eventNum = $json->eventNum;
  $result = "fail";

  if ($userId == "") {
     echo "Please Logon";
  } else {
  	if ($unitId == "" || $eventNum=="") {
       echo "Missing Parameters";
    } else {
       $getWkSql = "Select e.wkendDate from events e, wkendCal w where e.unitId = '$unitId' and e.eventNum = $eventNum and w.unitId = e.unitId and w.wkendDate = e.wkendDate";
       $rs=$conn->query($getWkSql);
       if ($rs === false) {
          echo('Wrong SQL: ' . $getWkSql . ' Error: ' . $conn->error); //, E_USER_ERROR);
       } else {
         $rows = $rs->num_rows;
         $rs->data_seek(0);
         $row = 0;
         while ($recs = $rs->fetch_row()) {
           $wkendDate = $recs[0];
         }

        if (erase_function($conn, $unitId, $eventNum))
          $result = "true";
        else
          $result = "false";


    }
  }

  $resultsArr = compact("result");
  echo json_encode($resultsArr); 
}
?>