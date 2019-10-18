<?php


function tabortWikiSida(){
    include('dbh.inc.php');

    $sidID = $_POST["sidID"];

    $result = $conn->query("SELECT * FROM wikisidor WHERE id = '{$sidID}'");

    while($row = $result->fetch_assoc()){
        $sql = "INSERT INTO  sidversion(sidID, godkantAv, bidragsgivare, titel, innehall, datum)  VALUES ($row['id'], $row['godkantAv'], $row['bidragsgivare'], $row['titel'], $row['innehall'], $row['datum'])";
        
        $conn->query($sql);
  
    }

    

    //$sql= "INSERT INTO blogginlagg(bloggId, titel, innehall, datum) VALUES ('$blogID','$title','$innehall','$date')";

    $delSida = "DELETE FROM wikisidor WHERE id = '{$sidID}'";

    $conn->query($delSida);

    




}




















































?>