<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testformulär för inlägg</title>
    <meta name="description" content="testform">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<script type="text/javascript">
        function laggTillTextruta(){

             

        }
    </script>-->
</head>
<body>
<?php 

    include("funktioner/dbh.inc.php");

?>
<form action="funktioner/skapainlagg.php" method="get">
    Välj en blogg:
        <select name="BID" id="BID">
            <?php 
                $sql = "SELECT BID, title, UID FROM blogg";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["BID"] ."'>ID: ". $row["UID"]." | ". $row["title"]."</option>";
                    }
                    echo "</table>";
                } else { echo "0 results"; }
                $conn->close();
            ?>
        </select>

    Blogginläggs titel: <input type="text" name="Title"><br/>
    <input type="text" name="rubrik" name="rubrik">
    <textarea name="inlagg" placeholder="Skriv in ett inlägg här..."></textarea>
    <input type="text" name="bild">
    <input type="button" name="textRuta">
    <input type="button" name="bildRuta">
    <input type="submit">
</form>
<?php
    
    // $conn->close();

?>

</body>
</html>