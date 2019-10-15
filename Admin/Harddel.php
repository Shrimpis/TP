<!-- harddel konto (Sadmin) -->

<h4>harddel konto (Sadmin)</h4>


<form action="funktioner/tabort.php" method="POST">
<input type='hidden' name='funktion' value='harddelkonto'/>

    <br>
    <select name="anvandarid">
    <?php
        include('funktioner/dbh.inc.php');
        $sql = "SELECT * FROM anvandare INNER JOIN anvandarroll ON anvandare.id = anvandarroll.anvandarId WHERE anvandarroll.rollId = 1";
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
    <input type="submit" value="delete konto">
</form>
<br>
<br>