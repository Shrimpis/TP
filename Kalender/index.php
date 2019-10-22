<?php 
    include("funktioner/dbh.inc.php");
    
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
    
        <!-- skapa kalender -->

        <h4>Skapa kalender</h4>

        <form action="funktioner/skapa.php" method="POST">
        <input type='hidden' name='funktion' value='skapaKalender'/>
            <select name="wikiId">
            <?php
                include("funktioner/dbh.inc.php");
                $sql = "SELECT * from wiki";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['tjanstId'] . "'>" . $row['tjanstId'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                $conn->close();
                
            ?>
            </select>
            <input type="submit" value="Ta bort wiki">
        </form>
        <br>
        <br>


    </body>
</html>