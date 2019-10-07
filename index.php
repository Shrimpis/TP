<?php 
    include("funktioner/dbh.inc.php");
?>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Provider - Blogg</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    </head>
    <body>
    <div class="container">
        <h2>The Provider</h2>
        <p>Blogg Funktioner</p>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#Blogg">Blogg</a></li>
            <li><a data-toggle="tab" href="#Inlagg">Inlägg</a></li>
            <li><a data-toggle="tab" href="#Kommentar">Kommentar</a></li>
        </ul>

        <div class="tab-content">
            <div id="Blogg" class="tab-pane fade in active">
            <h3>Blogg</h3>
            <p>Skapa en Blogg:</p>
                <form action="funktioner/skapaBlogg.php" method="get">
                <input type="text" name="Titel">
                <select name="Anvandare">
                <?php
                    $sql = "SELECT * from anvandare";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<option value=" . $row['UID'] . ">" . $row['fnman'] . " " . $row['enamn'] . "</option>";
                    }
                ?>
                </select>
                <input type="submit">
                </form>
            </div>
            <div id="Inlagg" class="tab-pane fade">
            <h3>Inlägg</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
            <div id="Kommentar" class="tab-pane fade">
            <h3>Kommentar</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
        </div>
        </div>
    </body>
</html>