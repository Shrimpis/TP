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

    include("dbh.inc.php");
    $conn;


?>
<form action="skapaBlogg.php" method="get">
<input type="text" name="Titel">
<select name="Anvandare">
<?php

    $sql = "SELECT * from anvandare";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "<option value=" . $row['UID'] . ">" . $row['fnman'] . " " . $row['enamn'] . "</option>";
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
