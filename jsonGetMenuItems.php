<?php


// This ID parameter is sent by our javascript client.
$unitId = $_GET['unitId'];
$menuId = $_GET['menuId'];
$userId = $_GET['userId'];


//  Genereic json Get

  session_start();
  include("db.php5");

$db2 = mysql_connect($hostname, $username, $password) OR DIE ("Could not conenct to Tips DB.");
$db_selected = mysql_select_db($dbname);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

//                    0           1           2         3             4             5             6        7        8
$getSQL = "Select i.menuId, i.menuItemId, m.divId,  i.dispOrder, i.menuItemDescr, i.menuItemFunc, i.parm2, i.parm3, i.parm4 from secMenus s, menuItems i, menus m where s.unitId='$unitId' and s.userId = '$userId' and s.menuId = '$menuId' and i.menuId = s.menuId and i.menuItemId = s.menuItemId and m.menuId = s.menuId order by i.dispOrder";
$result = mysql_query($getSQL) or die('select menu items data failed: ' . mysql_error());
$rows = mysql_num_rows($result);

$topArr = array();
$arrSeq = 1;

while ($recs = mysql_fetch_array($result, MYSQL_NUM)) {
     $menuId        = $recs[0];
     $menuItemId    = $recs[1];
     $divId         = $recs[2];
     $menuItemDescr = $recs[4];
     $menuItemFunc  = $recs[5];
     $parm2         = $recs[6];
     $parm3         = $recs[7];
     $parm4         = $recs[8];
     $arrLine       = compact("menuItemDescr", "divId", "menuItemFunc", "parm2", "parm3", "parm4");

     $topArr["$menuItemId"] = $arrLine;
     $arrSeq++;
}

// Send the data.
echo json_encode($topArr);

?>