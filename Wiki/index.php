<?php 
    include("../Databas/dbh.inc.php");
    
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
    
        <!-- Ta bort en wiki -->

        <h4>Ta bort en wiki</h4>

        <form action="funktioner/tabort.php" method="POST">
        <input type='hidden' name='funktion' value='tabortWiki'/>
            <select name="wikiId">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
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

  
    <br><br>
     <!-- Ta bort en sida -->

     <h4>Ta bort en sida</h4>

     <form method="post" action="funktioner/tabort.php">
     <input type='hidden' name='funktion' value='tabortWikiSida'/>

            <select name="sidId">
                <?php
                $conn;
                    //-include("funktioner/dbh.inc.php");
                    $sql = "SELECT * FROM wikisidor";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['titel'] . "</option>";
                        }
                    } else { 
                        echo "0 results"; 
                    }
                    $conn->close();
                ?>
            </select>
            <input type="submit" value="Ta bort sida">
        </form>
<br>
<br>



        <!-- dölj en wiki -->

        <h4>Dölj en wiki</h4>

        <form action="funktioner/redigera.php" method="POST">
        <input type='hidden' name='funktion' value='hideWiki'/>
            <select name="wikiId">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from wiki";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id']. " Dolt: " . $row['dolt'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                $conn->close();
                
            ?>
            </select>
            <input type="submit" value="dölj wiki">
        </form>
        <br>
        <br>

        <!-- neka -->

        <h4>neka en uppdatering</h4>

        <form action="funktioner/nekawiki.php" method="POST">
        <input type='hidden' name='funktion' value='nekaUppdatering'/>
            <select name="id">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from wikiuppdatering";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . "id: " . $row['id']. " | sida som uppdateras: " . $row['sidId'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                $conn->close();
                
            ?>
            </select>
            <br>
            <input type="text" name="reason">
            <br>
            <select name="denier">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from anvandare";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . "id: " . $row['id']. " | anamn: " . $row['anamn'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                $conn->close();
                
            ?>
            </select>
            <br>
            <input type="submit" value="neka wiki">
        </form>
        <br>
        <br>

    </body>
</html>