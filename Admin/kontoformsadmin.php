<!-- Redigera konto -->

<h4>Redigera kontoredigerare</h4>


<form action="funktioner/redigera.php" method="POST">
<input type='hidden' name='funktion' value='redigeraKonto'/>
    <input type="text" name="anamn">
    <input type="text" name="losenord">
    <br>
    <select name="UID">
    <?php
        include('funktioner/dbh.inc.php');
        $sql = "SELECT * from anvandare where aktiv = true";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["UID"] ."'>UID: ". $row['UID']."</option>";
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

<h4>Skapa konton för din tjänst</h4>


<form action="funktioner/skapa.php" method="post">
<input type='hidden' name='funktion' value='skapaAKonto'/>
    <input type="text" name="anamn">
    
    <br>
    <select name="rollid">
    <?php
        include('funktioner/dbh.inc.php');
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
    <input type="submit" value="Skapa Konto">
</form>
<br>
<br>