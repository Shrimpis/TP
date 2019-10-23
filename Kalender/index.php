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
        välj en användare:
            <select name="anvandarId">
            <?php
                include("funktioner/dbh.inc.php");
                $sql = "SELECT * from anvandare";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                $conn->close();
                
            ?>
            </select>
            <br>
            titel: 
            <input type="text" name="titel">
            <br>
            <input type="submit" value="skapa kalender">
        </form>
        <br>
        <br>


    </body>
</html>