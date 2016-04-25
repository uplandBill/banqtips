<?php
  session_start();
  $userId=$_SESSION['userId'];
  include("db.php5");

  $db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to BanqTips DB.");
  $db_selected = mysql_select_db($dbname);

  $unitId    = $_GET['unitId'];

  if ($userId == "") {
     echo "Please Logon";
  } else {
  	if ($unitId == "") {
       echo "Missing Parameters";
    } else {
       echo "<div class='listarea'>";
       echo "<p>Unit: <span id='unitId'>$unitId</span></p>";
       $Weekending = substr($wkendDate,0,4).substr($wkendDate,5,2).substr($wkendDate,8,2);
       $today = date("F d, Y");
       echo "<table border='1'>";
       
       $funcSQL = "Select funcType, funcDescr, defCovers, funcCat from funcTypes e where e.unitId= '$unitId' order by funcType";
       $funcRes = mysql_query($funcSQL) or die('select funcs failed: ' . mysql_error());
       while ($funcRec = mysql_fetch_array($funcRes, MYSQL_NUM)) {
           $funcType = $funcRec[0];
           echo "<tr>";
           echo "<td>"; 
           echo $funcType ." - ". $funcRec[1];
           echo "</td>";
           echo "<td>"; 
           echo $funcRec[2];
           echo "</td>";
           echo "<td>";
           echo "<table border='1'>";
           
           $eeSQL = "Select distinct c1.eeType, t1.eeTypeDescr from calcComps c1, employeeTypes t1 where c1.unitId= '$unitId' and c1.funcType = $funcType And t1.unitId = c1.unitId and t1.eeType = c1.eeType";
           $eeSQL = $eeSQL ." order by c1.eeType";
           $eeRes = mysql_query($eeSQL) or die('get employees failed: ' . mysql_error());
           while ($eeRec   = mysql_fetch_array($eeRes, MYSQL_NUM)) {
           	 $eeType      = $eeRec[0];
           	 $eeTypeDescr = $eeRec[1];
           	 echo "<tr>";
                 echo "<td>";
                 echo $eeType ." - ". $eeTypeDescr;
                 echo "</td>";
                 echo "<td>";
                 echo "<table border='1'>";

                 $gtSQL = "Select distinct c2.gratType, t2.gratDescr, c2.calcMeth, m2.compDescr, m2.compDescrShrt from calcComps c2, gratTypes t2, calcMeths m2 where c2.unitId= '$unitId' and c2.funcType = $funcType And c2.eeType = '$eeType'";
                 $gtSQL = $gtSQL ." And t2.unitId = c2.unitId and t2.gratType = c2.gratType and m2.compMethod = c2.calcMeth";
                 $gtSQL = $gtSQL ." order by c2.gratType";
                 $gtRes = mysql_query($gtSQL) or die('get grats failed: ' . mysql_error());
                 while ($gtRec   = mysql_fetch_array($gtRes, MYSQL_NUM)) {
                        $gratType      = $gtRec[0];
                        $gratDescr     = $gtRec[1];
                        $calcMeth      = $gtRec[2];
                        $compDescr     = $gtRec[3];
                        $compDescrShrt = $gtRec[4];
                        echo "<tr>";
                        echo "<td>";
                        echo $gratType ." - ". $gratDescr;
                        echo "</td>";
                        echo "<td>";
                        echo $compDescrShrt;
                        echo "</td>";
                        $rtSQL = "Select ";
                        echo "</tr>";
                 }
                 echo "</table>";
                 echo "</td>";
                 echo "</tr>";
           }
           echo "</table>";
           echo "</td>";
           echo "</tr>";
       }
       echo "</table>";
       echo "</div>";
    }
  }
?>