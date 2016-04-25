<?php
  session_start();
  $userId = $_SESSION['userId'];
  include("db.php5");

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

  if ($userId == "") {
     echo "Please Logon";
  } else {
  	if ($unitId == "" || $eventNum=="") {
       echo "Missing Parameters";
    } else {
       $getWkSql = "Select e.wkendDate, e.funcNumWk, e.funcType, f.funcDescr from events e, wkendCal w, funcTypes f where e.unitId = '$unitId' and e.eventNum = $eventNum and w.unitId = e.unitId and w.wkendDate = e.wkendDate and f.unitId = e.unitId and f.funcType = e.funcType";
       $rs=$conn->query($getWkSql);
       if ($rs === false) {
          echo('Wrong SQL: ' . $getWkSql . ' Error: ' . $conn->error); //, E_USER_ERROR);
       } else {
         $rows = $rs->num_rows;
         $rs->data_seek(0);
         $row = 0;
         while ($recs = $rs->fetch_row()) {
           $wkendDate = $recs[0];
           $funcNumWk = $recs[1];
           $funcDescr = $recs[3];
         }
       echo "<div class='listarea'>";
       if (substr($wkendDate,4,1) == "-")
          $wkendDate = $wkendDate;
       else
          if (substr($wkendDate,2,1) == "/")
             $wkendDate = substr($wkendDate,6,4) ."-". substr($wkendDate,0,2) ."-". substr($wkendDate,3,2);
          else
             $wkendDate = substr($wkendDate,0,4) ."-". substr($wkendDate,4,2) ."-". substr($wkendDate,6,2);
       echo "<p>Unit: <span id='unitId'>$unitId</span><br/>Function: $eventNum Func Number for week: $funcNumWk  The function is type: $funcDescr</p>";
       echo "<p>Week Ending: <span id='wkendDate'>$wkendDate</span><br/>";
       if ($rows > 0){
          $Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
          $today = date("F d, Y");
          echo "Today is " .$today. "<br/>";
//          $today = new DateTime(date, new DateTimeZone('Pacific/Chatham'));
//          $date->modify('+'.$numDays.' day');
//          $endDate = $date->format('Y-m-d');
          
          $SQL = "Select count(*) from events e where e.unitId= '$unitId' and e.wkendDate = '$wkendDate'";
          $result = $conn->query($SQL);
          if ($result === false) {
             echo('Bad SQL: ' . $SQL . ' Error: ' . $conn->error); //, E_USER_ERROR);
          } else {
            $rows = $result->num_rows;
            $result->data_seek(0);
            $rec = $result->fetch_row();
            echo "  Number of events for week: $rec[0]</p>";
          }
          $result->free();
          	 
          $SQL = "Select count(*) from funcGrats fg where fg.unitId= '$unitId' and fg.eventNum = $eventNum";
          $result = $conn->query($SQL);
          if ($result === false) {
             echo('Bad SQL: ' . $SQL . ' Error: ' . $conn->error); //, E_USER_ERROR);
          } else {
            $rows = $result->num_rows;
            $result->data_seek(0);
            $rec = $result->fetch_row();
            echo "  Number of gratuity entries: $rec[0]<br/>";
          }
          $result->free();
             
          $SQL = "Select count(*) from funcEmps fe where fe.unitId= '$unitId' and fe.eventNum = $eventNum";
          $result = $conn->query($SQL);
          if ($result === false) {
             echo('Bad SQL: ' . $SQL . ' Error: ' . $conn->error); //, E_USER_ERROR);
          } else {
            $rows = $result->num_rows;
            $result->data_seek(0);
            $rec = $result->fetch_row();
            echo "  Number of assigned employees: $rec[0]<br/>";
          }
          $result->free();

          $SQL = "Select count(*) from funcEmpCnts ec where ec.unitId= '$unitId' and ec.eventNum = $eventNum";
          $result = $conn->query($SQL);
          if ($result === false) {
             echo('Bad SQL: ' . $SQL . ' Error: ' . $conn->error); //, E_USER_ERROR);
          } else {
            $rows = $result->num_rows;
            $result->data_seek(0);
            $rec = $result->fetch_row();
            echo "  Number of employee counts: $rec[0]<br/>";
          }
          $result->free();
          
          $SQL = "Select count(*) from funcEmpGrats eg where eg.unitId= '$unitId' and eg.eventNum = $eventNum";
          $result = $conn->query($SQL);
          if ($result === false) {
             echo('Bad SQL: ' . $SQL . ' Error: ' . $conn->error); //, E_USER_ERROR);
          } else {
            $rows = $result->num_rows;
            $result->data_seek(0);
            $rec = $result->fetch_row();
            echo "  Number of gratuity entries: $rec[0] <br/>";
          }
          $result->free();

          echo "<input type='button' id='deleteButton' func='$eventNum' unitid='$unitId' value='Click to Delete'/>";

          echo "</div>";
       } else {       
          echo "<span id='currWeekStat'>Status: There was no week found.</span></p>";
       }
    }
  }
}
?>