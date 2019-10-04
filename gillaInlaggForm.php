<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Provider - Gilla ett inlägg</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <p><strong>Gilla ett inlägg</strong></p>
        <form action="funktioner/gillaInlagg.php">
            Välj ett inlägg:
            <select name="IID" id="IID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT IID, BID, title FROM blogginlagg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["IID"] ."'>BloggID: ". $row["BID"]." | ". $row["title"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
            Välj en användare:
            <select name="UID" id="UID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT UID, fnamn, enamn FROM anvandare";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["UID"] ."'>AnvändareID: ". $row["UID"]." | ". $row["fnamn"]." ". $row["enamn"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
            <input type="submit" value="Gilla">
        </form>
    </body>
</html>