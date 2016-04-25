<?php
       //                      0         1                        2                        3            4             5
       $getSQL = "Select c.unitId, c.wkendDate, date_format(c.wkendDate, '%M %d, %Y'), u.unitName, u.csvFormat, c.weekStatus from wkendCal c, units u ";
       $getSQL = $getSQL ." Where u.unitId='$unitId' and c.unitId=u.unitId and c.wkendDate = '$wkendDate'";
       $result = mysql_query($getSQL) or die('select weekend dat failed: ' . mysql_error());
       $rows   = mysql_num_rows($result);
       $recs   = mysql_fetch_array($result, MYSQL_NUM);
       $wkendDate  = $recs[1];
       $wkEndForm  = $recs[2];
       $unitName   = $recs[3];
       $csvFormat  = $recs[4];
       $weekStatus = $recs[5];
?>