<?php
        include("db.php5");
	$db = new mysqli($hostname, $username, $password, $dbname);
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySql DB";
	}
//      mysql_connect($hostname, $username, $password) OR DIE ("Could not connec to DB ");
//      mysql_select_db($dbname);
     	$query = "Select userId, userName, userStat, userType from users";
        $logQry = $db->query($query);
//     	$rows = mysql_num_rows($result);
	echo "Rows: " . $logQry->num_rows ."<br/>";
	while ($row = $logQry->fetch_row()) {
		echo $row[0] . " " . $row[1] . "<br/>";
	}
?>
