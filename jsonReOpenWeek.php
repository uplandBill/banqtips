<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");   
  $db_selected = mysql_select_db($dbname);
 
  $unitId  = $_GET['unitId'];
  $wkendDt = $_GET['wkendDt'];

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
       if (substr($wkendDt, 2, 1) == "/") {    //format difference in selection vs loading from DB
          $wkendDt = substr($wkendDt, 6, 4) .'-'. substr($wkendDt, 0, 2) .'-'. substr($wkendDt, 3, 2);
       } 
       //                      0         1                        2                        3            4
       $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u ";
       $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
       $getRes = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
       $rows   = mysql_num_rows($getRes);
       $recs   = mysql_fetch_array($getRes, MYSQL_NUM);
       $wkendDate = $recs[1];
       $wkEndForm = $recs[2];
       $unitName  = $recs[3];
       $csvFormat = $recs[4];
       if ($rows > 0){
          $result="Warning";
          $msg="A week is already open.  Close it to start a new week.";
       } else {
          $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u ";
          $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.wkendDate ='$wkendDt'";
          $getRes = mysql_query($getSQL) or die('select weekend date failed: ' . mysql_error());
          $rows   = mysql_num_rows($getRes);
          $recs   = mysql_fetch_array($getRes, MYSQL_NUM);
          if ($rows > 0){
             $result="Warning";
             $msg="Week has already been processed.";
          } else {
             $openWeek = "insert into wkendCal values('$unitId', '$wkendDt', 'O', 0, 0)";
             $openRes = mysql_query($openWeek) or die('Open week failed: ' . mysql_error());
             $result="Success";
             $msg="Week Opened";
          }
       }
    }
  }
  $resultsArr = compact("unitId", "result", "msg");
  echo json_encode($resultsArr);
?>