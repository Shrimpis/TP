<?php 
    include("../Databas/dbh.inc.php");
    
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
    <h4>Skapa wiki</h4>
    <br>
    <form action ="skapaWiki.php" method = "post">
  
        User ID: <input name="anvandarId" type="text" size="30"/><br>
        Title: <input name="titel" type="text" size="30"/><br>

        <input type="submit" value="Search"/>

       
    </form> 
    
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
                ?>
            </select>
            <input type="submit" value="Ta bort sida">
        </form>
<br>
<br>



        <!-- dölj en wiki -->

        <h4>Dölj en wiki</h4>

        <form action="funktioner/redigera.php" method="POST">
        <input type='hidden' name='funktion' value='doljWiki'/>
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
                
            ?>
            </select>
            <input type="submit" value="dölj wiki">
        </form>
        <br>
        <br>

        <!--Dölj wikisida-->

        <h4>Dölj en wikisida</h4>

        <form action = "funktioner/redigera.php" method = "POST">
     	
        <input type = "hidden" name="funktion" value = "doljWikiSida"/><br />
         <select name="id">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from wikisidor";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id']. " Dolt: " . $row['dolt'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                
            ?>
            </select>
        <br><br>
        
        <input type = "submit" value = "Dölj" />
        
    </form>

            <br>
            <br>

            <!-- privatiseraWiki -->
        <h4>gör en Wiki privat:</h4>
            <form action="funktioner/redigera.php" method="post">
            <input type='hidden' name='funktion' value='privatiseraWiki'/>
            Välj en Wiki:
                <select name="wikiId" id="wikiId">
                    <?php 
                        $conn;
                        $sql = "SELECT * FROM wiki INNER JOIN tjanst ON wiki.tjanstId = tjanst.id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='wiki.id'". $row["wiki.id"] ."'>Wiki: ".$row["titel"]." | privat: ".$row["privat"]."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                    ?>
                </select>
                <br><br>
                <select name="privat">
                    <option value=1>1</option>
                    <option value=0>0</option>
                </select>
                <br><br>
                <input type="submit" value="privatisera Wiki">
            </form>
            <br>
            <br>

            <h4>Lås wikisida</h4>

        <form action = "funktioner/redigera.php" method = "POST">
     	
        <input type = "hidden" name = "funktion" value="lasaWikiSida"/><br />
        <select name="id">
            <?php
            $conn;
                //-include("funktioner/dbh.inc.php");
                $sql = "SELECT * from wikisidor";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id']. " Last: " . $row['last'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                
            ?>
            </select>
        
        <br><br>
        
        <input type = "submit" value = "Post" />
        
    </form>
    <br><br>

        <!-- neka -->

        <h4>neka en uppdatering</h4>

        <form action="funktioner/redigera.php" method="POST">
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
                
            ?>
            </select>
            <br>
            <input type="text" name="anledning">
            <br>
            <select name="nekadAv">
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

                
            ?>
            </select>
            <br>
           
            <br>
            <input type="submit" value="neka wikiuppdatering">
        </form>
        <br>
        <br>
        <!-- söka -->

        <h4>sök efter titel</h4>

        <form action="funktioner/skapa.php" method="POST">
        <input type='hidden' name='funktion' value='sokFalt'/>
            
            <br>
            <input type="text" name="sok">
        
            <br>
            <input type="submit" value="sök">
        </form>
        <br>
        <br>
    </body>
</html>