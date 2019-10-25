<!-- privatiseraWiki -->
<h4>gör en Wiki privat:</h4>
            <form action="funktioner/redigera.php" method="post">
            <input type='hidden' name='funktion' value='privatiseraWiki'/>
            Välj en Wiki:
                <select name="WikiId" id="WikiId">
                    <?php 
                        include('funktioner/dbh.inc.php');
                        $sql = "SELECT * FROM Wiki INNER JOIN tjanst ON Wiki.tjanstId = tjanst.id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>Wiki: ".$row["titel"]." | privat: ".$row["privat"]."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                        $conn->close();
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