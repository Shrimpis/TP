<?php
$anamn = "SELECT anvandare.id, anvandare.anamn, kundrattigheter.id FROM anvandare INNER JOIN kundrattigheter ON anvandare.id=kundrattigheter.kontoID WHERE kundrattigheter.id='". $row["id"] ."'";

$anamnResult = mysqli_query($conn,$anamn); 
    while ($anvandare_row = mysqli_fetch_array($anamnResult)) {
        echo $anvandare_row['anamn'];
    }


?>