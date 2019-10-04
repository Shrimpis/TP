<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testformulär för inlägg</title>
    <meta name="description" content="testform">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
        let rutaOrdning = 0;

        function laggTillTextruta(id) {

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.id = "huvudruta" + id;

            let rubrik = document.createElement("div");
            let rubrikInnehall = document.createTextNode("Rubrik Paragraf: ");
            let rubrikInput = document.createElement("input");
            rubrikInput.type = "text";
            rubrikInput.name = "rubrik" + rutaOrdning;
            rubrik.appendChild(rubrikInnehall);
            rubrik.appendChild(rubrikInput);
            ruta.appendChild(rubrik);

            let breakLine = document.createElement("br");
            rubrik.appendChild(breakLine);
            rubrik.appendChild(breakLine);

            let text = document.createElement("div");
            let textInnehall = document.createTextNode("Text Paragraf: ");
            let textInput = document.createElement("textarea");
            textInput.name = "text" + rutaOrdning;
            textInput.placeholder = "Skriv in ett inlägg här...";
            text.appendChild(textInnehall);
            text.appendChild(breakLine);
            text.appendChild(textInput);
            ruta.appendChild(text);
            body.appendChild(ruta);

        }
    </script>
</head>

<body>
    <?php

    include("funktioner/dbh.inc.php");

    ?>
    <form action="skapainlagg.php" method="get">
        Välj en blogg:
        <select name="BID" id="BID">
            <?php
            $sql = "SELECT BID, title, UID FROM blogg";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["BID"] . "'>ID: " . $row["UID"] . " | " . $row["title"] . "</option>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }

            ?>
        </select>
        <br /><br />

        Blogginläggs titel: <input type="text" name="Title"><br /><br />
        <div id="rutor-container">
            <div class="ruta text">
                <div class="ruta text rubrik">
                    Rubrik Paragraf: <input type="text" name="rubrik"><br /><br />
                </div>
                <div class="ruta innertext">
                    Text Paragraf: <textarea name="text" placeholder="Skriv in ett inlägg här..."></textarea><br /><br />
                </div>
            </div>
        </div>
        <input type="button" name="textRuta" value="Lägg till Textruta" onclick="laggTillTextruta()"><br /><br />
        <input type="button" name="bildRuta" value="Lägg till Bildruta"><br /><br />
        <input type="submit">
    </form>
    <?php

    $conn->close();

    ?>

</body>

</html>