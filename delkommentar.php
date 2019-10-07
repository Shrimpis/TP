<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testformulär</title>
    <meta name="description" content="testform">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php 

include("funktioner/dbh.inc.php");


?>
<form action="funktioner/delkomfunc.php" method="get">

<select name="KID">
<?php

    $sql = "SELECT * from kommentar";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "<option>" . $row['KID'] . "</option>";
    }
    
?>
</select>

<input type="submit">
</form>
<?php

    $conn->close();

?>

</body>
</html>