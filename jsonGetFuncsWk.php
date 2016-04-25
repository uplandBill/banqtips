<?php

  session_start();
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db_selected = mysql_select_db($dbname);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

// This ID parameter is sent by our javascript client.
$unitId = $_GET['unitId'];

//                      0         1                        2                        3            4
$getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat from wkendCal c, units u Where u.unitId='$unitId' and c.unitId=u.unitId and c.weekStatus = 'O'";
$result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
$recs   = mysql_fetch_array($result, MYSQL_NUM);
$wkendDate = $recs[1];
$wkEndForm = $recs[2];
$unitName  = $recs[3];
$csvFormat = $recs[4];

$gratTypes = array();
$miscCodes = array();
$miscTots = array();    //     0         1
$miscSql = "select distinct gratType, miscCode from gratTypes where unitId = '$unitId'"; 
$miscRes = mysql_query($miscSql) or die('select weekend dat failed: ' . mysql_error());
$miscCnt = 0;
while ($gratRec = mysql_fetch_array($miscRes, MYSQL_NUM)) {
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
$h1="Row";
$h2="Func Num";
$h3="Func Date";
$h4="Room Name";
$h5="Func Type";

$headArr=array("h1", "h2", "h3", "h4", "h5");
$topArr = array();
$nextHead = "h6";
//                     Load the different Grats used for the entire week
//                      0             1             2             3         4
$gratSQL = "Select g.gratType, gt.gratDescr, gt.dispOrder, gt.miscCode, count(*)";
$gratSQL = $gratSQL ." from events e, funcGrats g, gratTypes gt";
$gratSQL = $gratSQL ." where e.unitId='$unitId' and e.wkendDate ='$wkendDate'";
$gratSQL = $gratSQL ." and g.unitId = e.unitId and g.eventNum = e.eventNum";
$gratSQL = $gratSQL ." and gt.unitId = g.unitId and gt.gratType = g.gratType group by g.gratType, gt.gratDescr, gt.dispOrder order by 5 desc, 3 asc";
$gratRes = mysql_query($gratSQL) or die('select grats data failed: ' . mysql_error());
while ($gratRec = mysql_fetch_array($gratRes, MYSQL_NUM)) {
      $gratType  = $gratRec[0];
      $gratDescr = $gratRec[1];
      $miscCode  = $gratRec[3];
      $count     = $gratRec[4];
      if ($gratType != "X") {
         $gratCnt++;
         $grats[$gratCnt] = $gratType;
         $gratsDescrs[$gratCnt] = $gratDescr;
	 if ($gratCnt == 1) {
	    $h6 = $gratDescr;
	    array_push($headArr,"h6");
            $nextHead = "h7";
            $h7 = "Messages";
	 }
	 if ($gratCnt == 2) {
	    $h7 = $gratDescr;
	    array_push($headArr,"h7");
            $nextHead = "h8";
            $h8 = "Messages";
	 }
	 if ($gratCnt == 3) {
	    $h8 = $gratDescr;
	    array_push($headArr,"h8");
            $nextHead = "h9";
            $h9 = "Messages";
	 }
	 if ($gratCnt == 4) {
	    $h9 = $gratDescr;
	    array_push($headArr,"h9");
            $nextHead = "h10";
            $h10 = "Messages";
	 }
	 if ($gratCnt == 5) {
	    $h10 = $gratDescr;
	    array_push($headArr,"h10");
            $nextHead = "h11";
            $h11 = "Messages";
	 }
      }
}
    array_push($headArr, $nextHead);
    $topArr["0"] = compact($headArr);

//                      0         1           2           3            4          5           6           7            8     
$getSQL = "Select c.unitId, e.eventNum, e.funcNumWk, e.wkendDate, e.funcDate, e.roomNum, r.roomDescr, e.funcType, f.funcDescr";
$getSQL = $getSQL ." from events e, wkendCal c, rooms r, funcTypes f";
$getSQL = $getSQL ." where c.unitId='$unitId' and c.weekStatus = 'O' and e.unitId = c.unitId and e.wkendDate = c.wkendDate and r.unitId = e.unitId";
$getSQL = $getSQL ." and r.roomNum = e.roomNum  and f.unitId = e.unitId and f.funcType = e.funcType order by funcNumWk, eventNum";
$result = mysql_query($getSQL) or die('select emp event data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$arrSeq = 1;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
	$unitId        = $recs[0];
	$eventNum      = $recs[1];
	$funcNumWk     = $recs[2];
	$wkendDate     = $recs[3];
	$funcDate      = $recs[4];
	$roomNum       = $recs[5];
	$roomDescr     = $recs[6];
	$funcType      = $recs[7];
	$funcDescr     = $recs[8];
	
	$arrLine = array("unitId", "eventNum", "funcNumWk", "wkendDate", "funcDate", "roomNum", "roomDescr", "funcType", "funcDescr");
   
        $messages = "";
        $hasGrats="N";
        $gratsLine=array();
        for ($i=1; $i<=$gratCnt; $i++) {
           $gratType = $grats[$i];
           $gratSQL = "Select g.gratAmt from funcGrats g";
           $gratSQL = $gratSQL ." where g.unitId='$unitId' and g.eventNum = $eventNum and g.gratType = '$gratType'";
           $gratRes = mysql_query($gratSQL) or die('select grats data failed: ' . mysql_error());
           $gratRec = mysql_fetch_array($gratRes, MYSQL_NUM);
           $gratAmt = $gratRec[0];
             if ($gratAmt > 0) {
                $hasGrats="Y";
             }
	     if ($i == 1) {
	        $grat1 = $gratAmt;
	        array_push($arrLine,"grat1");
	     }
	     if ($i == 2) {
	        $grat2 = $gratAmt;
	        array_push($arrLine,"grat2");
	     }
	     if ($i == 3) {
	        $grat3 = $gratAmt;
	        array_push($arrLine,"grat3");
	     }
	     if ($i == 4) {
	        $grat4 = $gratAmt;
	        array_push($arrLine,"grat4");
	     }
	     if ($i == 5) {
	        $grat5 = $gratAmt;
	        array_push($arrLine,"grat5");
	     }
        }
	
	if ($hasGrats == "N") 
	   $messages = "No Gratuities Entered";
	array_push($arrLine,"messages");
	
	$prevSql = "Select max(funcNumWk) from events where unitId = '$unitId' and wkendDate ='$wkendDate' and funcNumWk < $funcNumWk";
        $prevRes = mysql_query($prevSql) or die('get prev func failed: ' . mysql_error());
        $rows = mysql_num_rows($prevRes); 
        if ($rows == 0)
           $prevFunc = 0;
        else {
           $prevRec = mysql_fetch_array($prevRes, MYSQL_NUM);
           $prevFunc = $prevRec[0];
        }
        $nextFunc = $prevFunc + 1;
        if ($nextFunc != $funcNumWk) {
           if ($messages != "")
              $messages = $messages ."<br>";
           $messages = $messages . "Gap in functions (". $prevFunc ." to ". $funcNumWk .")";
        }

	$topArr["$arrSeq"] = compact($arrLine);
	$arrSeq++;
}

// Send the data.
echo json_encode($topArr);

?>