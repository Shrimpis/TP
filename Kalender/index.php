
<?php 
    //-include("funktioner/dbh.inc.php");
    include("../Databas/dbh.inc.php");

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
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from anvandare";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                

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

        <!-- skapa kalendersida -->

        <h4>Skapa kalendersida</h4>

        <form action="funktioner/skapa.php" method="POST">
        <input type='hidden' name='funktion' value='skapaKalendersida'/>
        välj en användare:
            <select name="anvandarId">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from anvandare";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                

            ?>
            </select>
            <br>
            kalender:
            <select name="kalenderId">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from kalender";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['tjanstId'] . "'>" . $row['tjanstId'] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                

            ?>
            </select>
            <br>
            <input type="submit" value="skapa kalendersida">
        </form>
        <br>
        <br>
        
        <!-- skapa event -->

        <h4>Skapa kalenderevent</h4>

        <form action="funktioner/skapa.php" method="POST">
        <input type='hidden' name='funktion' value='skapaKalenderevent'/>
        välj en användare:
            <select name="anvandarId">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from anvandare";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                

            ?>
            </select>
            <br>
            kalender:
            <select name="kalenderId">
            <?php

            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from kalendersida";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                

            ?>
            </select>
            <br>
            Titel: <input type="text" name="titel">
            <br>
            Innehåll: <input type="text" name="innehall">
            <br>
            start: <input type="text" name="startTid">
            <br>
            slut: <input type="text" name="slutTid">
            <br>
            <input type="submit" value="skapa kalenderevent">
        </form>
        <br>
        <br>
        <!-- tabort kalender -->

        <h4>Tabort kalender</h4>

        <form action="funktioner/tabort.php" method="POST">
        <input type='hidden' name='funktion' value='tabortKalender'/>
        kalender:
            <select name="tjanstId">
            <?php
                $sql = "SELECT * from kalender";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['tjanstId'] . "'>" . $row['tjanstId'] . "</option>";
                    }
                } else {
                    echo "0 results";
                }
                

            ?>
            </select>
            <input type="submit" value="ta bort kalender">
        </form>
        <br>
        <br>
        <!-- tabort kalendersida -->

        <h4>Tabort kalendersida</h4>

        <form action="funktioner/tabort.php" method="POST">
        <input type='hidden' name='funktion' value='tabortKalendersida'/>
        kalendersida:
            <select name="sidId">
            <?php
                $sql = "SELECT * from kalendersida";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                    }
                } 
                

            ?>
            </select>
            <input type="submit" value="ta bort kalendersida">
        </form>
        <br>
        <br>
    </body>
</html>
