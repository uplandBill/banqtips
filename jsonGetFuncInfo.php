<?php
   //
   //  Given a unitId and eventNum, returns details and counts for the event
   //
   session_start();
   include("db.php5");

   $conn = new mysqli($hostname, $username, $password, $dbname);
   // check connection
   if ($conn->connect_error) {
     trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
   }

   error_reporting(E_ALL);

   // Prevent caching.
   header('Cache-Control: no-cache, must-revalidate');
   header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

   // The JSON standard MIME header.
   header('Content-type: application/json');
 
   //Return something like {"funcNumWk":"14","exists":"no","eventNum":"512","empCnt":"32"}

   // This ID parameter is sent by our javascript client.
   $json     = json_decode(file_get_contents('php://input'));
   $unitId   = $json->unitId;
   $eventNum = $json->eventNum;
   $callBack = $json->callBack;

//   $unitId = $_GET["unitId"];
//   $eventNum = $_GET["eventNum"];

   //init return values
   if ($callBack == "")
      $jsonFunc    = "event_details";
   else
      $jsonFunc    = $callBack;
   $exists         = "no";
   $wkendDate      = "not found";
   $funcDate       = "not found";
   $funcGroup      = "not found";
   $roomNum        = "not found";
   $funcType       = "not found";
   $funcNumWk      = "not found";
   $funcEmpCntsCnt = 0;
   $funcEmpGratsCnt= 0;
   $funcEmpsCnt    = 0;

   $eventSql = "select e.wkendDate, e.funcDate, e.funcGroup, e.roomNum, e.funcType, e.funcNumWk";
   $eventSql = $eventSql . " from events e Where e.unitId = '$unitId' and e.eventNum = $eventNum";
   $rs=$conn->query($eventSql);
   if ($rs === false) {
      $results = "SQL Error: " . $conn->error;
   } else {
      $rows = $rs->num_rows;
      $rs->data_seek(0);
      $row = 0;
      if ($rows == 1) {
        $exists = "yes";
        $recs = $rs->fetch_row();
        $wkendDate  = $recs[0];
        $funcDate   = $recs[1];
        $funcGroup  = $recs[2];
        $roomNum    = $recs[3];
        $funcType   = $recs[4];
        $funcNumWk  = $recs[5];
        $rs->free();

        $funcEmpCntsSql = "select count(*) from funcEmpCnts where eventNum = $eventNum";
        $rs=$conn->query($funcEmpCntsSql);
        $rows = $rs->num_rows;
        $rs->data_seek(0);
        if ($rows > 0) {
          $recs = $rs->fetch_row();
          $funcEmpCntsCnt = $recs[0];
        }
        $rs->free();
        $funcEmpGratsSql = "select count(*) from funcEmpGrats where eventNum = $eventNum";
        $rs=$conn->query($funcEmpCntsSql);
        $rows = $rs->num_rows;
        $rs->data_seek(0);
        if ($rows > 0) {
          $recs = $rs->fetch_row();
          $funcEmpGratsCnt = $recs[0];
        }
        $rs->free();

        $funcEmpsSql = "select count(*) from funcEmps where eventNum = $eventNum";
        $rs=$conn->query($funcEmpsSql);
        $rows = $rs->num_rows;
        $rs->data_seek(0);
        if ($rows > 0) {
          $recs = $rs->fetch_row();
          $funcEmpsCnt = $recs[0];
        }
        $rs->free();
      }
      $results = "success";
   }

   $topArr  = array();
   $arrLine = compact("jsonFunc", "eventNum", "funcNumWk", "funcDate", "roomNum", "exists", "eventNum", "funcEmpCntsCnt", "funcEmpGratsCnt", "funcEmpsCnt", "results");

   // Send the data.
   echo json_encode($arrLine);
?>