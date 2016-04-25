<?php
  session_start();
  include("db.php5");

  $unitId = $_GET['unitId'];
  $func = $_GET['func'];
  echo "Unit: " . $unitId . "<br/>";

 // $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
  $db = new mysqli($hostname, $username, $password, $dbname);
  if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySql DB";
  }
 // $db_selected = mysql_select_db($dbname);

  $effSql = "Select distinct effdt from baseWages e where e.unitId = '$unitId' order by effdt desc";
  $effRes = $db->query($effSql);
  echo "Rows: " . $effRes->num_rows ."<br/>";
  echo "DB:" . $dbname . "<br/>";
  echo "Host:" . $hostname . "<br/>";
//  $effRows = mysql_num_rows($effRes);
  while ($effRec = $effRes->fetch_row()) {
     $effdt = $effRec[0];
     echo "<table border='1'>";
     echo "<tr><td colspan=4>$effdt</td></tr>";

     $classSql = "Select distinct emplClass from payGrp";
     $classRows = $db->query($classSql);
     while ($classRec = $classRows->fetch_row()) {
        $emplClass = $classRec[0];
        echo "<tr><td>$emplClass</td>";
   
        $pgSql = "Select payGrp from payGrp where unitId = '$unitId' and emplClass = '$emplClass'";
        $pgRes = $db->query($pgSql);
        echo "<td>";
        while ($pgRec = $pgRes->fetch_row()) {
            $pagGrp = $pgRec[0];
            echo "$pagGrp<br/>";
        }
        echo "</td><td>";
   
        echo "<table border='1'>";
        $catSql = "Select distinct funcCat from funcTypes where unitId = '$unitId'";
        $catRes = $db->query($catSql);
        while ($catRec = $catRes->fetch_row()) {
            $funcCat = $catRec[0];
            echo "<tr><td>$funcCat</td><td>";
   
            $funcSql = "Select funcType, funcDescr from funcTypes where unitId = '$unitId' and funcCat = '$funcCat'";
            $funcRes = $db->query($funcSql);
            $funcList = " (";
            $comma = "";
            while ($funcRec = $funcRes->fetch_row()) {
               $funcList = $funcList . $comma;
               $funcType = $funcRec[0];
               $funcDescr = $funcRec[1];
               echo "$funcDescr<br/>";
               $funcList = $funcList . $funcType;
               $comma = ", ";
            }
            $funcList = $funcList . ") ";
            echo "</td><td>";
   
            $bwSql = "Select distinct baseWage from baseWages where unitId = '$unitId' and effdt = '$effdt' and emplClass = '$emplClass' and funcType in $funcList";
            $bwRes = $db->query($bwSql);
            echo "<table border='1'>";
            while ($bwRec = $bwRes->fetch_row()) {
                   $baseWage = $bwRec[0];
                   echo "<tr><td>$baseWage</td>";
                   echo "<td>";
                   $bfSql = "Select b.funcType, t.funcDescr, b.emplClass from baseWages b, funcTypes t where b.unitId = '$unitId' and b.effdt = '$effdt' and b.emplClass = '$emplClass' and b.baseWage = $baseWage and b.funcType in $funcList and t.unitId = b.unitId and t.funcType = b.funcType order by b.funcType";
                   $bfRes = $db->query($bfSql);
                   while ($bfRec = $bfRes->fetch_row()) {
                          $funcType  = $bfRec[0];
                          $funcDescr = $bfRec[1];
                          $bwec      = $bfRec[2];
                          echo "$funcDescr($funcType) - $bwec<br/>";
                   }
                   echo "</td>";
                   echo "</tr>";
            }
            echo "</table>";
            echo "</td>";
        }
       echo "</table></td>";
       echo "</tr>";
     }
     echo "</table><br/>";
  }
?>
