<?php
function erase_function($conn, $unitId, $eventNum) {
  if ($unitId == "" || $eventNum == 0) {
    return false;
  } else {
    $gridDel = "delete from funcEmps where unitId = '$unitId' and eventNum = $eventNum";
    $result = $conn->query($gridDel);
    if ($result === false) {
      return false;
    }

    $gridDel = "delete from funcEmpCnts where unitId = '$unitId' and eventNum = $eventNum";
    $result = $conn->query($gridDel);
    if ($result === false) {
      return false;
    }

    $gratsDel = "delete from funcEmpGrats where unitId = '$unitId' and eventNum = $eventNum";
    $result = $conn->query($gratsDel);
    if ($result === false) {
      return false;
    }
     
    $gratsDel = "delete from funcGrats where unitId = '$unitId' and eventNum = $eventNum";
    $result = $conn->query($gratsDel);
    if ($result === false) {
      return false;
    }

    $eventDel = "delete from events where unitId = '$unitId' and eventNum = $eventNum";
    $result = $conn->query($eventDel);
    if ($result === false) {
      return false;
    }

    return true;
    } 
}
?>