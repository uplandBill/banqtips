<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

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
    	 if ($wkendDt=="") {
          $result="Error";
          $msg="A week ending date is required.";
    	 } else {
 	  if (substr($wkendDt,4,1) == "-")
             $wkendDt = $wkendDt;
          else
             if (substr($wkendDt,2,1) == "/")
                $wkendDt = substr($wkendDt,6,4) ."-". substr($wkendDt,0,2) ."-". substr($wkendDt,3,2);
             else
                $wkendDt = substr($wkendDt,0,4) ."-". substr($wkendDt,4,2) ."-". substr($wkendDt,6,2);
          $getWeDay = "select wkendDay from units where unitId = '$unitId'";
          $result   = $db->query($getWeDay);
          $weData   = $result->fetch_row();
          $wkendDay = $weData[0];
          $enteredWeDay = date('l', strtotime($wkendDt));
          // echo "New Weekending date is $wkendDate let's validate $enteredWeDay<br/>";
          if ($wkendDay <> $enteredWeDay) {
             $result="Error";
             $msg="Date Entered is not a " .$wkendDay;
          } else {
             //                      0         1                        2                        3            4
             $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u ";
             $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
             $getRes = $db->query($getSQL);
             $rows   = $getRes->num_rows;
             $recs   = $getRes->fetch_row();
             $wkendDtO  = $recs[1];
             $wkEndForm = $recs[2];
             $unitName  = $recs[3];
             $csvFormat = $recs[4];
             $msg="";
             if ($rows > 0){  // week is open
                $result="Warning";
                $msg="Week End $wkendDtO was closed.";
                $updSQL = "Update wkendCal set weekStatus = 'C' Where unitId='$unitId' and wkendDate = '$wkendDtO'";
                $updRes = $db->query($updSQL);
             } 
             $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u ";
             $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.wkendDate ='$wkendDt'";
             $getRes = $db->query($getSQL);
             $rows   = $getRes->num_rows;
             $recs   = $getRes->fetch_row();
             if ($rows > 0){
                $updSQL = "Update wkendCal set weekStatus = 'O' Where unitId='$unitId' and wkendDate = '$wkendDt'";
                $updRes = $db->query($updSQL);
                $result="Success";
                $msg=$msg."Week is re-opened.";
             } else {
                $openWeek = "insert into wkendCal values('$unitId', '$wkendDt', 'O', 0, 0)";
                $openRes = $db->query($openWeek);
                $result="Success";
                $msg=$msg."New Week, $wkendDt, Opened";
             }
          }
       }
    }
  }
  $resultsArr = compact("unitId", "result", "msg");
  echo json_encode($resultsArr);
?>
