<?php
  session_start();
  include("db.php5");

    $Action="Saved";
    $postCnt = 0;
    $sets = "";
    $inserts = "";
    foreach ($_POST as $postKey=>$postValue) {
    	$field = $postKey;
        echo "$postKey is $postCnt: $postValue<br/>";
        if ($postCnt > 0) {
           $sets = $sets . ", ";
           $inserts = $inserts . ", ";
        }
        $sets = $sets . $postKey . "='$postValue'";
        $inserts = $inserts . "'$postValue'";
        $postCnt++;
    }
    $sets = $sets . " ";

    $table = $_GET['table'];
    $where = stripslashes(urldecode($_GET['where']));
    echo "Sets set: $sets<br/>";
    echo "Where: $where<br/>";

    $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");		
    if ($where == "new") {
    	$colNames="";
        $db_selected = mysql_select_db('information_schema'); //$dbname);
        $getCols = "Select COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE, COLUMN_COMMENT from COLUMNS where TABLE_SCHEMA = 'averyrco_tipspay' and TABLE_NAME = '" .$table ."'";
        $result = mysql_query($getCols) or die('get fields failed: ' . mysql_error());
        $fieldsCnt = mysql_num_rows($result);
        $selectFields = "";
        $allFields=array();
        while ($fields  = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $column = $fields[COLUMN_NAME];
            $dataType = $fields[DATA_TYPE];
            $allFields[] = $fields;
            $decimals = $numPrec - $numbers;
            if ($colNames <> "")
               $colNamess = $colNamess . ", $column";
            else
               $colnames = "($column";
        }
        $colNamess = "$colNames) ";
    	
        $db_selected = mysql_select_db($dbname);
        $newrow  = "insert into $table $colNames values ($inserts)";
        $uploadres = mysql_query($newrow) or die('new row insert failed: ' . mysql_error());
        $TaskKey = $todonum;
        echo "Record Created";
     } else {              
         $db_selected = mysql_select_db($dbname);
         $configUpd = "update $table set " . $sets . $where;
         echo $configUpd;
         $upd1res = mysql_query($configUpd) or die('Update of config failed: ' . mysql_error());
         echo "Record Updated";
     }
?>