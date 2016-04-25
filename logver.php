<?php
     session_start();

     $user = $_POST["user"];
     $pswd = $_POST["pswd"];
     if ($user && $pswd) {
        include("db.php5");
     	mysql_connect($hostname, $username, $password) OR DIE (" ");
     	mysql_select_db($dbname);
     	$query = "Select userId, userName, active, userType from users where userId = '$user' and password = password('$pswd')";
     	$result = mysql_query($query) or die("Password check failed".mysql_error());
     	$rows = mysql_num_rows($result);
     	if ($rows == 1) {
     	   $row=mysql_fetch_row($result);
     	   $userId   = $row[0];
     	   $userName = $row[1];
     	   $userStat = $row[2];
     	   $userType = $row[3];
     	   $_SESSION['userId']=$userId;
     	   $_SESSION['userStat']=$userStat;
     	   $_SESSION['userType']=$userType;
           echo "success";
//     	   header('Location: configs.html');
     	}
     	else {
     	   $_SESSION['userId']="";
     	   $_SESSION['userStat']="";
     	   $_SESSION['userType']="";
	   echo '<form method="post" action = "logver.php5">';
	   echo 'Enter your username <input type ="text" name="user" size="20" value="<?php echo $user;?>"><br/>';
	   echo 'Enter your password <input type ="password" name="pswd" size="15"> <br/>';
	   echo '<input type="submit" value="Click to login">';
	   echo '<input type="reset" value="Click to reset">';
	   echo '</form><div>Logon Failed</div>';
     	}
     } else {
     	if ($_SESSION["userId"] != "") {
     	   echo "ok";
        }
     	else
     	   if ($user || $pswd) {
     	      $_SESSION['userId']="";
     	      $_SESSION['userStat']="";
     	      $_SESSION['userType']="";
     	   	echo "lacking";
     	      }
     	   else {
     	      echo "nothing";
     	      $_SESSION['userId']="";
     	      $_SESSION['userStat']="";
     	      $_SESSION['userType']="";
     	   }
     }
?>
