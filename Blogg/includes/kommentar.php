<!-- Skapa en kommentar -->
<div>
<h4>Skapa en kommentar</h4>

<form action="funktioner/skapa.php">
<input type='hidden' name='funktion' value='skapaKommentar'/>
Välj att kommentera:
<select name="hierarchyID" id="hierarchyID">
    <option value="0">Ingen</option>
    <?php 
        include('funktioner/dbh.inc.php');
        $sql = "SELECT id, innehall FROM kommentar";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='". $row["id"] ."'>KID: ". $row["id"]." | ". $row["innehall"]."</option>";
        }
        echo "</table>";
        } else { echo "0 results"; }
        $conn->close();
    ?>
</select>
<br><br>
Välj ett inlägg:
<select name="inlaggsId">
    <?php 
        include('funktioner/dbh.inc.php');
        $sql = "SELECT id, bloggId, titel FROM blogginlagg";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='". $row["id"] ."'>BloggID: ". $row["bloggId"]." | ". $row["titel"]."</option>";
        }
        echo "</table>";
        } else { echo "0 results"; }
        $conn->close();
    ?>
</select>
<br><br>
Välj en användare:
<select name="anvandarId">
    <?php 
        include('funktioner/dbh.inc.php');
        $sql = "SELECT id, anamn FROM anvandare";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='". $row["id"] ."'>AnvändareID: ". $row["id"]." | ". $row["anamn"]."</option>";
        }
        echo "</table>";
        } else { echo "0 results"; }
        $conn->close();
    ?>
</select>
<br><br>
<textarea id="kommentartext" name="text" rows="10" cols="30"></textarea>
<br><br>
<input type="submit" value="Skapa Kommentar">
</form>
<br>
<br>


<!-- Redigera kommentar -->

<h4>Redigera kommentar</h4>

<form action="funktioner/redigera.php" method="POST">
    <input type='hidden' name='funktion' value='redigeraKommentar'/>
    <textarea name="text" rows="10" cols="30">ny text</textarea>
    <br>
    <select name="KID">
    <?php
    include('funktioner/dbh.inc.php');
    $sql = "SELECT * from kommentar";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='". $row["id"] ."'>KID: ". $row['id']."</option>";
        }
        echo "</table>";
        } else { echo "0 results"; }
    
    ?>
    </select>
    <br>
    <input type="submit" value="Redigera kommentar">
</form>
<br>
<br>

<!-- Ta bort en kommentar -->

<h4>Ta bort en kommentar</h4>

<form action="funktioner/tabort.php" method="POST">
<input type='hidden' name='funktion' value='tabortKommentar'/>
    <select name="KID">
    <?php
        include("funktioner/dbh.inc.php");
        $sql = "SELECT * from kommentar";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['id'] . " | " . $row['innehall'] . "</option>";
            }
        } else { 
            echo "0 results"; 
        }
        $conn->close();
        
    ?>
    </select>
    <input type="submit" value="Ta bort kommentaren">
</form>
<br>
<br>
<!-- Gilla ett inlägg -->

<h4>flagga en kommentar</h4>
            <form action="funktioner/skapa.php" method="POST">
            <input type='hidden' name='funktion' value='flaggaKommentar'/>
            Välj en kommentar:
            <select name="kommentarsid">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id,innehall FROM kommentar";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>kommentar: ". $row["id"]." | ". $row["innehall"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
            Välj en användare:
            <select name="anvandarID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, anamn FROM anvandare";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>AnvändareID: ". $row["id"]." | ". $row["anamn"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
            <input type="submit" value="flagga">
            </form>
            <br>
            <br>

                <form action="funktioner/redigera.php" method="post">
                <input type='hidden' name='funktion' value='censureraKommentar'/>
                    
                    Kommentar ID: <input type = "text" name = "id"  /><br />
                    
                    <br>
                
                    <input type = "submit" value = "censurera" />
                    
                    
                </form>
                

            
</div>