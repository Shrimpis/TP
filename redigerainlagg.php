<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testformulär</title>
    <meta name="description" content="testform">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<form action="funktioner/inlaggredfunktion.php" method="get">
<input type="text" name="Titel">
<select name="IID">
<?php
    include("funktioner/dbh.inc.php");
    $sql = "SELECT * from blogginlagg";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "<option>" . $row['IID'] . "</option>";
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
