<?php
//status 0 = väntande, 1 = accepterad, 2 = nekad

include(db.inc.php);

if(isset($_GET["userID"])){

$id = $_GET["userID"];

  $sql = "SELECT * FROM kalenderevent where id = $id AND status=0";
  $result = $conn->query($sql);

  

}
