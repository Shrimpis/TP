<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Provider - Skapa en Kommentar</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <p><strong>Skapa en kommentar</strong></p>
        <form action="funktioner/skapaKommentar.php">
        Välj att kommentera:
            <select name="hierarchyID" id="hierarchyID">
                <option value="0">Ingen</option>
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT KID, text FROM kommentar";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["KID"] ."'>KID: ". $row["KID"]." | ". $row["text"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
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
            <textarea name="text" rows="10" cols="30">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</textarea>
            <br><br>
            <input type="submit" value="Skapa Kommentar">
        </form>
    </body>
</html>