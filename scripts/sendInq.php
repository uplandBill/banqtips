<?php

  $hostname = "wmrnet.db.9582380.hostedresource.com";
  $username = "wmrnet";
  $password = "Dc_20015";
  $dbname = "wmrnet";

  $item = $_GET[item];

  $db2 = new mysqli($hostname, $username, $password, $dbname);
  if($db2->connect_errno > 0) {
    die('Unable to connect to database [' . $db2->connect_error . ']');
  }

  $itemEntry = "Select title, descr, userid from items where item = '$item'";
  
  if (!$result = $db2->query($itemEntry)) 
     die('Error getting Item Entry ['. $db2->error . ']' );
  $rows = $result->num_rows;
  
  if ($rows == 1) {

     $result->data_seek(0);
     $rec = $result->fetch_row();
     $title  = $rec[0];
     $descr  = $rec[1];
     $userid = $rec[2];

     echo "<div class='inquiryForm'>";
     echo "<table>";
     echo "<tr><td class='formLabel'>Your eMail:</td><td> <input id='sendEmail' type='text'></td></tr>";
     echo "<tr><td class='formLabel'>Subject: </td><td><input id=subject' type='text' value = 're: $title'></td></tr>";
     echo "<tr><td class='formLabel'>Message: </td><td><textarea rows='5' cols='60'> </textarea></td></tr>";
     echo "<tr><td><input id ='sendButton' type='button' user='$userid' value='Send'/></td></tr>";
     echo "</table></div>";
  }  
?>