<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Provider - Ta bort blogg</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <p>Ta bort en blogg</p>
        <form action="funktioner/tabortblogg.php">
        Välj en blogg:
            <select name="BID" id="BID">
                <?php 
                    include('dbh.inc.php');
                    $sql = "SELECT BID, title, UID FROM blogg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["BID"] ."'>ID: ". $row["UID"]." | ". $row["title"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
            <input type="submit" value="Ta bort blogg">
        </form>
    </body>
</html>