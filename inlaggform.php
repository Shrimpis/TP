<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testformulär för inlägg</title>
    <meta name="description" content="testform">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
        let rutaOrdning = 1;

        function laggTillTextruta() {

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.name = "textruta";

            let rubrik = document.createElement("div");
            let rubrikInnehall = document.createTextNode("Rubrik Paragraf: ");
            let rubrikInput = document.createElement("input");
            rubrikInput.type = "text";
            rubrikInput.name = "rubrik";
            rubrik.appendChild(rubrikInnehall);
            rubrik.appendChild(rubrikInput);
            ruta.appendChild(rubrik);

            let breakLine = document.createElement("br");
            rubrik.appendChild(breakLine);
            rubrik.appendChild(breakLine);

            let text = document.createElement("div");
            let textInnehall = document.createTextNode("Text Paragraf: ");
            let textInput = document.createElement("textarea");
            textInput.name = "text";
            textInput.placeholder = "Skriv in ett inlägg här...";
            text.appendChild(textInnehall);
            text.appendChild(breakLine);
            text.appendChild(textInput);
            ruta.appendChild(text);
            body.appendChild(ruta);

        }

        function laggTillBildruta(){

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.name = "bildruta";

            let bild = document.createElement("div");
            let bildInnehall = document.createTextNode("Bild: ");
            let bildInput = document.createElement("input");
            bildInput.type = "text";
            bildInput.name = "bild";
            bild.appendChild(bildInnehall);
            bild.appendChild(bildInput);
            ruta.appendChild(bild);
            body.appendChild(ruta);

        }

    </script>
</head>

<body>
    <?php

    include("funktioner/dbh.inc.php");

    ?>
    <form action="funktioner/bloggInlagg.php" method="post">
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

        Blogginläggs titel: <input type="text" name="title"><br /><br />
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
        <input type="button" name="bildRuta" value="Lägg till Bildruta" onclick="laggTillBildruta()"><br /><br />
        <input type="submit">
    </form>
    <?php

    $conn->close();

    ?>

</body>

</html>