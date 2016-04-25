<?php
  $hostname="127.0.0.1:3306";
  $username="banqtips";
  $password="Dc@20015";
  $dbname="banqtips";

  $db = new mysqli($hostname, $username, $password, $dbname);
  if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySql DB";
  }

?>
