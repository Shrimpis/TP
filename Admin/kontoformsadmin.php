<!-- Redigera konto -->

<?php
    include("../Databas/dbh.inc.php");
?>

<h4>Redigera kontoredigerare (User)</h4>


<form action="funktioner/redigera.php" method="POST">
<input type='hidden' name='funktion' value='redigeraKonto'/>
    anamn<input type="text" name="anamn">
    <br>
    losenord<input type="text" name="losenord">
    <br>
    <select name="anvandarid">
    <?php
        $conn;
        //-include("../Databas/dbh.inc.php");
        $sql = "SELECT * from anvandare where aktiv = true";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>id: ". $row['id']."</option>";
            }
            echo "</table>";
        } else { echo "0 results"; }
        
        
    ?>
    </select>
    <br>
    

    <input type="submit" value="Redigera Konto">
</form>
<br>
<br>
<!-- Skapa konto -->

<h4>Skapa konton för din tjänst (Sadmin)</h4>


<form action="funktioner/skapa.php" method="post">
<input type='hidden' name='funktion' value='skapaAKonto'/>
    <input type="text" name="anamn">
    
    <br>
    <select name="rollid">
    <?php
        $conn;
        //-include("../Databas/dbh.inc.php");
        $sql = "SELECT * from roll where id != 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>Roll: ". $row['rollNamn']."</option>";
            }
            echo "</table>";
            } else { echo "0 results"; }
        
    ?>
    </select>
    <br>
    <select name="tjanst">
    <?php
        $conn;
        $sql = "SELECT * from tjanst";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>Roll: ". $row['rollNamn']."</option>";
            }
            echo "</table>";
            } else { echo "0 results"; }
        
    ?>
    </select>
    <br>
    <input type="submit" value="Skapa Konto">
</form>
<br>
<br>
<!-- avaktivera konto (Sadmin) -->

<h4>avaktivera konto (Sadmin)</h4>


<form action="funktioner/tabort.php" method="POST">
<input type='hidden' name='funktion' value='tabortKonto'/>

    <br>
    <select name="anvandarid">
    <?php
        $conn;
        //-include("../Databas/dbh.inc.php");
        $sql = "SELECT * from anvandare where aktiv = true";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>id: ". $row['id']."</option>";
            }
            echo "</table>";
        } else { echo "0 results"; }
        
        
    ?>
    </select>
    <br>
    <input type="submit" value="avaktivera konto">
</form>
<br>
<br>
<!-- avaktivera konto (Sadmin) -->

<h4>harddel konto (TP)</h4>


<form action="funktioner/tabort.php" method="POST">
<input type='hidden' name='funktion' value='harddelkonto'/>

    <br>
    <select name="kontoID">
    <?php
        $conn;
        //-include("../Databas/dbh.inc.php");
        $sql = "SELECT * from anvandare where aktiv = true";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>id: ". $row['id']."</option>";
            }
            echo "</table>";
        } else { echo "0 results"; }
        
        
    ?>
    </select>
    <br>
    <input type="submit" value="harddel konto">
</form>
<br>
<br>
<!-- Redigera konto (user) -->

<h4>Redigera kontoredigerare (Sadmin)</h4>


<form action="funktioner/redigera.php" method="POST">
<input type='hidden' name='funktion' value='redigeraRoll'/>

    <br>
    <select name="anvandarid">
    <?php
        $conn;
        //-include("../Databas/dbh.inc.php");
        $sql = "SELECT * from anvandare where aktiv = true";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>id: ". $row['id']."</option>";
            }
            echo "</table>";
        } else { echo "0 results"; }
        
        
    ?>
    </select>
    <br>
    <select name="rollid">
    <?php
    $sql2 = "SELECT * from roll where id != 1";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while($row = $result2->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>Roll: ". $row['rollNamn']."</option>";
            }
            echo "</table>";
        } else { echo "0 results"; }
    ?>
    </select>
    <br>
    <input type="submit" value="Redigera roll">
</form>
<br>
<br>