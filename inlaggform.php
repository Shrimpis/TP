<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testformulär för inlägg</title>
    <meta name="description" content="testform">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<script type="text/javascript">
        funtion laggTillTextruta(){

             

        }
    </script>-->
</head>
<body>
<?php 

    include("dbh.inc.php");
    $conn;

?>
<form action="skapainlagg.php" method="get">
<input type="text" name="Titel">
<textarea name="inlagg" placeholder="Skriv in ett inlägg här..."></textarea>
<input type="button" value="Lägg till textruta">
<?php 
    $sql = "SELECT * from blogg";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
    echo "<option>". "" . "</option>";
}
?>
<input type="submit">
</form>
<?php
    
    $conn->close();

?>

</body>
</html>