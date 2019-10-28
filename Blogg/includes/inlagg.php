<!-- Skapa ett inlägg -->

<h4>Skapa ett inlägg</h4>

<?php
    include("../../Databas/dbh.inc.php");
?>

<form action="funktioner/skapa.php" method="POST">
<input type='hidden' name='funktion' value='skapaInlagg'/>
    Välj en blogg:
    <select name="bloggId">
        <?php
        $conn;
        //-include('funktioner/dbh.inc.php');
        $sql = "SELECT id, titel, anvandarId FROM tjanst";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>ID: " . $row["id"] . " | " . $row["titel"] . "</option>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>
    </select>
    <br>
    <br>
    Blogginläggs titel: <input type="text" name="Title"><br/><br/>
    <textarea id="inlaggtext" name="innehall" rows="10" cols="30"></textarea>
    <input type="submit" value="Skapa inlägg">
</form>
<br>
<br>


<!-- Redigera titel på ett inlägg -->

<h4>Redigera ett inlägg</h4>

<form action="funktioner/redigera.php" method="POST">
<input type='hidden' name='funktion' value='redigeraInlagg'/>
    Titel:
    <input type="text" name="Titel">

    <br>
    <br>
    Inlägg:
    <select name="inlaggsId" id="inlaggsId">
    <?php 
    $conn;
        //-include('funktioner/dbh.inc.php');
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
    <br>
    <textarea id="inlaggtext" name="innehall" rows="10" cols="30"></textarea>
    <br><br>
    <input type="submit" value="Redigera inlägg">
</form>
<br>
<br>


<!-- Ta bort ett inlägg -->

<h4>Ta bort ett inlägg</h4>

<form action="funktioner/tabort.php" method="POST">
<input type='hidden' name='funktion' value='tabortInlagg'/>
    Inlägg:
    <select name="inlaggsId">
    <?php 
    $conn;
        //-include('funktioner/dbh.inc.php');
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
    <br>
    <br>
    <input type="submit" value="Ta bort inlägg">
</form> 
<br>
<br>


<!-- Gilla ett inlägg -->

<h4>Gilla ett inlägg</h4>
            <form action="funktioner/skapa.php" method="POST">
            <input type='hidden' name='funktion' value='gillaInlagg'/>
            Välj ett inlägg:
            <select name="inlaggsId">
                <?php 
                $conn;
                    //-include('funktioner/dbh.inc.php');
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
                $conn;
                    //-include('funktioner/dbh.inc.php');
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
            <input type="submit" value="Gilla">
            </form>
            <br>
            <br>