<?php
  session_start();
  include("db.php5");

  $userType = $_GET['user'];
  if ($userType == 'user')
     $userType = "userConfig = 'Y'";
  if ($userType == "admin")
     $userType = "adminConfig = 'Y'";
   $NextKey = "";
   date_default_timezone_set('America/New_York');
   $currentDT=date('Y-m-d H:i:s');
   echo "<h2> Configs as of $currentDT</h2>";

// header("Content-type: image/jpg");
// $im = @ImageCreate (100, 200) or die ("Cannot Initialize new GD image stream");
// $background_color = ImageColorAllocate ($im, 234, 234, 234);
// $text_color = ImageColorAllocate ($im, 233, 14, 91);
// imageline ($im,0,0,50,100,$text_color);
// ImagePng ($im); 

	$db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
	$db_selected = mysql_select_db($dbname);
	
	$query = "Select tableName, tableDescr, edFunc from configs where " .$userType. " order by tableName";
//	echo $query;
	$result = mysql_query($query) or die('To Do Query failed: ' . mysql_error());
	$rows = mysql_num_rows($result);
    $prevGroup="";
    $first="Y";

       echo "<table border='2' cellpadding='2'>";
       echo "<tr>";
       echo "<th width='40'>  Table Name   </th>";
       echo "<th width='150'> Description   </th>";
       echo "</tr>";

      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
       $tableName=$line[tableName];
       $tableDescr=$line[tableDescr];
       $edFunc=$line[edFunc];

  	   echo "<tr>";
  	   echo '<td> <a onclick="buildEd('."'$tableName','$edFunc')".'" href="javascript:void(0);">' .$tableName . "</a></td>";
  	   echo "<td> $tableDescr   </td>";
  	   if ($offset < 1)
  	     echo "<td bgcolor='red' align='center'> $offset     </td>";
  	   else
     	   echo "<td align='center'> $offset     </td>";
  	   
//  	   $dt   = strtotime("$estend"); 
//       $dtf =date('l h:i A', $dt);
//  	   echo "<td> $dtf </td>";

  	   echo "</tr>";
	  }
 	  echo "</table>";
?>