<?php
  session_start();
  include("db.php5");
 
  $table = $_GET['table'];
  $nWhere = stripslashes($_GET['where']);
  echo "edit function: $func Action: $action table:$table<br/>";
  echo "Where: $nWhere<br/>";

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
  $db_selected = mysql_select_db('information_schema'); //$dbname);

  $isEffdt = "Select 'Y' from KEY_COLUMN_USAGE where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."' And COLUMN_NAME='effdt'";
  $getCols = "Select COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE, COLUMN_COMMENT from COLUMNS where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."'";
  $getKeys = "Select COLUMN_NAME From KEY_COLUMN_USAGE Where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."' Order By ORDINAL_POSITION";
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
  while ($keys  = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $column = $keys[COLUMN_NAME];
      $keyList[] = $keys[COLUMN_NAME];
  }
  echo "nWhere: $keyList[0] <br/>";

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
      $comment = $fields[COLUMN_COMMENT];
      $allFields[] = $fields;
      $decimals = $numPrec - $numbers;
      echo "$column: $dataType Len:$colLength Prec:$numbers.$decimals<br/>";
      if ($selectFields <> "")
         $selectFields = $selectFields . ", $column";
      else
         $selectFields = "Select $column";
  }
  echo "Table has $fieldsCnt fields <br/>";
  
  echo '<form id="updateKey1" name="updateKey1">'; // action="tododets.php5?todo='. $TaskKey .'&action=save"'. '" method="post">';
  echo "<table width='750'>";
  $func = "get1"; //.$keyCnt;

  if ($nWhere == "new") {
  } else {
     $selectFields = $selectFields . " From $table $nWhere";
     $db_selected = mysql_select_db($dbname);
     $result = mysql_query($selectFields) or die('select fields failed: ' . mysql_error());
     $rows = mysql_num_rows($result);
     $tableData = mysql_fetch_array($result, MYSQL_NUM);
  }
  

  for ($i=0; $i<=$fieldsCnt - 1; $i++) {
  	$colName = $allFields[$i][COLUMN_NAME];
  	$colComm = $allFields[$i][COLUMN_COMMENT];
  	if ($colComm <> "")
  	   echo "<tr><td width='150'>$colComm </td>";
  	else
  	   echo "<tr><td width='150'>$colName </td>";
      
       $isKey = "N";
       foreach ($keyList as $keyCol) {
       	 if ($keyCol == $colName)
       	    $isKey = "Y";
       }
       if (($isKey == "Y") && ($nWhere <> "new"))
       	    echo "<td >$tableData[$i] &nbsp;&nbsp;[key]</td>";
       	 else
            echo '<td ><input type="text" size = "' .$allFields[$i][CHARACTER_MAXIMUM_LENGTH]. '" name="' .$allFields[$i][COLUMN_NAME]. '"  value="' .$tableData[$i]. '"></td>';
        
       echo "</tr>";
     }

    echo "</table>";
    echo "</form>";
    echo '<input value="Save this Config" type="button" onclick=' . "'javascript:xmlhttpPost(" . '"saveKey1.php5?table='. $table . '&where=' . urlencode($nWhere).'","updateKey1")' . "'>";
    
    echo "<br>";
    echo '<FORM Name = "newtodo" ><INPUT TYPE="BUTTON" VALUE="ADD New Config" ONCLICK="get1(' . "'$table','new')" . '"> </FORM>';
    echo "<br>";
    echo '<FORM Name = "deltodo" ><INPUT TYPE="BUTTON" VALUE="DELETE this Config" ONCLICK="window.location.href=' ."'tododelete.php5?todo=" .$TaskKey. "&NextTask=". $nexttask ."'" .'"></FORM>';
?>