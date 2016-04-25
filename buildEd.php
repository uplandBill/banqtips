<?php
  session_start();
  include("db.php5");
 
  $table = $_GET['table'];
  $func  = $_GET['funcName'];
  echo "edit function: $func <br/>";

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db('information_schema'); //$dbname);

  $isEffdt = "Select 'Y' from KEY_COLUMN_USAGE where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."' And COLUMN_NAME='effdt'";
  $getCols = "Select COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE from COLUMNS where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."'";
  $getKeys = "Select COLUMN_NAME From KEY_COLUMN_USAGE Where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."'";
  $getNonKeyFlds = "Select COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE from COLUMNS where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."' And COLUMN_NAME Not IN ($getKeys)";
  
  $result = mysql_query($isEffdt) or die('effdt check failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  if ($rows == 0) {
     $isEffdt = "N"; 
     } else {
     $isEffdt = "N"; 
     $line = mysql_fetch_array($result, MYSQL_NUM);
     $effRes = $line[0];
     if ($effRes == 'Y')
        $isEffdt = "Y"; 
  }
  echo "Table $table is Effective Dated:  $isEffdt <br/>";

  $keyList = array();
  $result = mysql_query($getKeys) or die('get keys failed: ' . mysql_error());
  $keyCnt = mysql_num_rows($result);
  echo "Table $table has $keyCnt key fields. <br/>";
  $key1Where = "Where";
  while ($keys  = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $column = $keys[COLUMN_NAME];
      $key1Where = "$key1Where $column = '$key1'";
      $keyList[] = $keys[COLUMN_NAME];
  }

  $result = mysql_query($getCols) or die('get fields failed: ' . mysql_error());
  $fieldsCnt = mysql_num_rows($result);
  echo "Found $rows field(s) <br/>";
  $selectFields = "";
  $allFields=array();
  while ($fields  = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $column = $fields[COLUMN_NAME];
      $dataType = $fields[DATA_TYPE];
      $colLength= $fields[CHARACTER_MAXIMUM_LENGTH];
      $numPrec = $fields[NUMERIC_PRECISION];
      $numbers = $fields[NUMERIC_SCALE];
      $allFields[] = $fields;
      $decimals = $numPrec - $numbers;
      echo "$column: $dataType Len:$colLength Prec:$numbers.$decimals<br/>";
      if ($selectFields <> "")
         $selectFields = $selectFields . ", $column";
      else
         $selectFields = "Select $column";
  }
  
  echo "Table has $fieldsCnt fields <br/>";
  $selectFields = $selectFields . " From $table";
  if ($keyCnt > 0)
     $selectFields = $selectFields . " Order By 1";
  if ($keyCnt > 1)
     $selectFields = $selectFields . " ,2";
  if ($keyCnt > 2)
     $selectFields = $selectFields . " ,3";
  echo "$selectFields <br/>";
  
  if ($funcName == 'edDepts') {
  }
  
  $db_selected = mysql_select_db($dbname);
  $result = mysql_query($selectFields) or die('select fields failed: ' . mysql_error());
  $rows = mysql_num_rows($result);
  echo "Table has $rows rows of data.<br/>";
  
  $func = "get1"; //.$keyCnt;

  echo "<table  border='2' cellpadding='2'><tr>";
  for ($i=0; $i<=$fieldsCnt - 1; $i++) {
  	$colName = $allFields[$i][COLUMN_NAME];
  	echo "<th>$colName </th>";
     }
  echo "</tr>";
  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
  	echo "<tr>";
        $nWhere = "Where ";
        $line = array_reverse($line);
        $cells="";
        $fieldCnt = 0;
  	foreach ($line as $colName=>$fieldVal) {
  	       $isKey = "N";
  	       $fieldCnt++;
               foreach ($keyList as $keyCol) {
       	           if ($keyCol == $colName)
       	               $isKey = "Y";
                    }
                if ($isKey == "Y")
                   if ($nWhere == "Where ")
                      $nWhere = $nWhere . "$colName = '$fieldVal' ";
                   else
                      $nWhere = $nWhere . "and $colName = '$fieldVal' " ;
  		if ($fieldCnt == $fieldsCnt) {
//  		   echo "<td><a href='$func.php5'> $fieldVal </a> </td>";
//  		   $linkIt = "<td><a onclick='" .$func. '("' .$table . '","' . urlencode($nWhere) . '")' . '" href="javascript:void(0);">' ."$fieldVal</a></td>";
//      	   echo '<td> <a onclick="buildEd('  ."'$table','$edFunc')"                    .'" href="javascript:void(0);">' .$tableName . "</a></td>";
  		   $linkIt = '<td><a onclick="get1(' ."'$table','" . urlencode($nWhere) . "')" .'" href="javascript:void(0);">' ."$fieldVal</a></td>";
  		   $cells = $linkIt . $cells;
  	           }
  		else
  		   $cells = "<td> $fieldVal </td>$cells";
  	}
  	echo "$cells<td>$nWhere</td>";
  	echo "</tr>";
  }
  echo "</table>";
?>