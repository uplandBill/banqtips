<?php
//
//  This procedure will get the next, sequential, function number for a new (unsaved) function.  The function number
//  is based on what function group the function belongs to.  Function Group is based on the function type.
//

  session_start();
  include("db.php5");

  // Prevent caching.
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
  header("Access-Control-Allow-Origin: *");
  header('Content-type: application/json');

  $nextFunc = 0;
  $funcGroup = 0;
  $db2 = new mysqli($hostname, $username, $password, $dbname);
  if($db2->connect_errno > 0) {
    $result = "Error";
    $message = "Could not open DB:" . $db2->connect_error;
  } else {

    $unitId   = $_GET['unitId'];
    $funcType = $_GET['funcType'];
    $eventNum = $_GET['eventNum'];
  
    $currDate = date("Y-m-d");  //Current date in yyyy-mm-dd

    //                   0        1             2          3          4
    $openWeek = "select 'Y', c.wkendDate, u.defGrat1, u.defGrat2, u.defGrat3 from wkendCal c, units u where c.unitId = '$unitId' and c.weekStatus='O' and u.unitId = c.unitId";
    $rs = $db2->query($openWeek);

    $rows = 0;  
    if ($rs === false) {
      $result = "Error";
      $message = "Get current week SQL error:" . $db2->error;
    } else {
       $rows = $rs->num_rows;
    }
    
    if ($rows > 0) {
      $rs->data_seek(0);
      $row = $rs->fetch_row();
      $wkEndDate = $row[1];
      $rs->free();
//
//    If the event has already been saved, get the saved function type and group.  When switching back to same group, keep that function number.
//
      if ($eventNum !== "new") {
        $currSql = "select e.funcNumWk, t.funcGroup from events e, funcTypes t where e.unitId = '$unitId' and e.eventNum = $eventNum and t.unitId = e.unitId and t.funcType = e.funcType";
        $rs = $db2->query($currSql);
        $rows = $rs->num_rows;
        if ($rows > 0) {
          $rs->data_seek(0);
          $row = $rs->fetch_row();
          $currFuncNumWk = $row[0];
          $currFuncGroup = $row[1];
        } else {
          $currFuncType  = 0;
          $currFuncGroup = 0;
        }
      } else {
        $currFuncType  = 0;
        $currFuncGroup = 0;
      }
//
//    Get the func group for the newly selected function type.
//
      $funcTypeSql = "select funcGroup from funcTypes t where t.unitId = '$unitId' and t.funcType = '$funcType'";
      $rs = $db2->query($funcTypeSql);
      if ($rs === false) {
        $result = "Error";
        $message = "Get Next Func Group SQL error:" . $db2->error;
      } else {
        $rs->data_seek(0);
        $rows = $rs->num_rows;
        if ($rows > 0) {
          $row = $rs->fetch_row();
          $funcGroup = $row[0];
        } else {
          $result = "Error";
          $message = "Function Type not found.";          
        }
      }
//
//    Get the max func number for the week, for the func group aligned with new func type
//
      if ($funcGroup <> 0) {
        $nextFuncSql = "select max(e.funcNumWk) from wkendCal c, events e, funcTypes t";
        $nextFuncSql = $nextFuncSql ." where c.unitId = '$unitId' and c.weekStatus='O'";
        $nextFuncSql = $nextFuncSql ." and e.unitId = c.unitId and e.wkendDate = c.wkendDate";
        $nextFuncSql = $nextFuncSql ." and t.unitId = e.unitId and t.funcType = e.funcType";
        $nextFuncSql = $nextFuncSql ." and t.funcGroup = '$funcGroup'";
        $rs = $db2->query($nextFuncSql);
        if ($rs === false) {
          $result = "Error";
          $message = "Get Next Func SQL error:" . $db2->error;
        } else {
          $rs->data_seek(0);
          $rows = $rs->num_rows;
          if ($rows > 0) {
            $row = $rs->fetch_row();
            $nextFunc = $row[0] + 1;
            $result = "Success";
            $message = "Next is plus 1";
          } else {
            $nextFunc = 1;
            $result = "Success";
            $message = "Next is first";
          }
        } 
      } else {
        $result = "Error";
        $message = "Valid Func Group not found";        
      }

      if ($currFuncGroup == $funcGroup) {
        $nextFunc = $currFuncNumWk;
        $message = "Next is orig num";
        }
      else
        $nextFunc = $nextFunc;
    
    } else {
      $result = "Error";
      $message = "No open week found";
    }
  
    $rs->free();
    $db2->close();
  }
  $resultsArr = compact("result", "message", "nextFunc", "funcGroup", "eventNum", "currFuncGroup");
  echo json_encode($resultsArr); 
?>