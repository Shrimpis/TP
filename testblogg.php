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

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "the_provider";
    $conn = new mysqli($servername, $username, $password, $dbname);

?>
<form action="dest.php">
<input type="text" name="title">
<select name="Anvandare">
<?php
$sql = "SELECT UID from anvandare";
$result = $conn->query($sql);
for(int i=0;i<$result->num_row;i++){
    echo $row['UID']"<br>";
}
$conn->close();
?>
</select>

<input type="submit">
</form>
<?php

 function createBlog(){
    $title = ;
    $usrid = ;
    $sql = "INSERT into blogg(title,UID) VALUES($title)";
 }

?>

</body>
</html>
