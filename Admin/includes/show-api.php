<?php
$api = "SELECT * FROM api WHERE rattighetId='". $row["id"] ."'";

$apiResult = mysqli_query($conn,$api); 
    while ($row9 = mysqli_fetch_array($apiResult)) {
        echo $row9['nyckel'];
    }


?>