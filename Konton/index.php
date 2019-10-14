<!-- Konton -->
<div id="Konton" class="tab-pane fade in active">
                <h3>Konton</h3>
                <br>
                <!-- Skapa Konton -->

            <h4>Skapa ett konto:</h4>
                <!-- <form action="funktioner/skapaKonto.php" method="get"> -->
                <form action="funktioner/skapa.php" method="POST">
                <input type='hidden' name='funktion' value='skapaKonto'/>
                username:<input type="text" name="uname">
                <br><br>
                
                <input type="submit" value="Skapa Konto">
                </form>
                <br><br>
                <!-- Ta bort konton -->
            <h4>Ta bort ett konto:</h4>
            <form action="funktioner/tabort.php" method="post">
            <input type='hidden' name='funktion' value='tabortKonto'/>
            Välj ett konto:
                <select name="UID" id="UID">
                    <?php 
                        include('funktioner/dbh.inc.php');
                        $sql = "SELECT UID, anamn FROM anvandare WHERE aktiv=true";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["UID"] ."'>ID: ". $row["UID"]." | ". $row["anamn"]."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                        $conn->close();
                    ?>
                </select>
                <br><br>
                <input type="submit" value="Ta bort konto">
            </form>
            </div>
                
</div>