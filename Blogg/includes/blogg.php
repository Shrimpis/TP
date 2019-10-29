<h3>Blogg</h3>
    <br>

    <!-- Skapa blogg -->

    <h4>Skapa en Blogg:</h4>
        <form action="funktioner/skapa.php" method="POST">
        <input type='hidden' name='funktion' value='skapaBlogg'/>
        Namn:<input type="text" name="Titel">
        <br><br>
        Välj en användare:
        <select name="anvandarId">
        <?php 
            $conn;
            $sql = "SELECT id, anamn FROM anvandare";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["id"] ."'>AnvändareID: ". $row["id"]. " | ". $row["anamn"]."</option>";
            }
            echo "</table>";
            } else { echo "0 results"; }
            
        ?>
        </select>
        <br><br>
        <input type="submit" value="Skapa Blogg">
        </form>
        <br>
        <br>


        <!-- Redigera titel på en blogg -->

        <h4>Redigera titel på en blogg</h4>
            <form action="funktioner/redigera.php" method="POST">
                <input type='hidden' name='funktion' value='redigeraBlogg'/>
                Titel:
                <input type="text" name="Titel">
                <br>
                <br>
                Blogg:
                <select name="bloggId">
                <?php 
                    $conn;
                    $sql = "SELECT id, titel, anvandarId FROM tjanst";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>ID: ". $row["anvandarId"]." | ". $row["titel"]."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                        
                ?>
                </select>
                <br><br>
                <input type="submit" value="Redigera titel">
            </form>
            <br>
            <br>


            <!-- Ta bort blogg -->
            <h4>Ta bort en Blogg:</h4>
            <form action="funktioner/tabort.php" method="post">
            <input type='hidden' name='funktion' value='tabortBlogg'/>
            Välj en blogg:
                <select name="bloggId" id="bloggId">
                    <?php 
                        $conn;
                        $sql = "SELECT id, titel, anvandarId FROM tjanst";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>ID: ". $row["anvandarId"]." | ". $row["titel"]."</option>";
                        }
                        } else { echo "0 results"; }
                        
                    ?>
                </select>
                <br><br>
                <input type="submit" value="Ta bort blogg">
            </form>
            <br>
            <br>

            <!-- privatiserablogg -->
            <h4>gör en Blogg privat:</h4>
            <form action="funktioner/redigera.php" method="post">
            <input type='hidden' name='funktion' value='privatiseraBlogg'/>
            Välj en blogg:
                <select name="bloggId" id="bloggId">
                    <?php 
                        $conn;
                        $sql = "SELECT * FROM blogg INNER JOIN tjanst ON blogg.tjanstId = tjanst.id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row['blogg.id'] ."'>Blogg: ".$row["titel"]." | privat: ".$row["privat"]."</option>";
                        }
                        }
                        
                    ?>
                </select>
                <br><br>
                <select name="privat">
                    <option value=1>1</option>
                    <option value=0>0</option>
                </select>
                <br><br>
                <input type="submit" value="privatisera blogg">
            </form>
            <br>
            <br>


            <!-- flaggablogg -->
            <h4>flagga en elak blogg:</h4>
            <form action="funktioner/skapa.php" method="post">
            <input type='hidden' name='funktion' value='flaggaBlogg'/>
            Välj en blogg:
                <select name="bloggid" id="bloggid">
                    <?php 
                        $conn;
                        $sql = "SELECT id, titel, anvandarId FROM tjanst";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>ID: ". $row["anvandarId"]." | ".$row["titel"]."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                        
                    ?>
                </select>
                <br><br>
                <select name="anvandarID">
                    <?php 
                    $conn;
                        $sql = "SELECT id FROM anvandare";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>anvandarID: ".$row["id"]."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                        
                    ?>
                </select>
                <br><br>
                <input type="submit" value="flagga blogg">
            </form>
            <br>
            <br>


                sök efter en blogg

                <form action="funktioner/skapa.php" method="post">
                    <input type='hidden' name='funktion' value='sokfalt'/>
            
                    <input name="sok" type="text" size="30" placeholder="Search..."/>

                    <input type="submit" value="Search"/>

                
                </form> 
            <br>
            <br>
                    
                        
