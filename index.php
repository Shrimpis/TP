<?php 
    include("funktioner/dbh.inc.php");
    
    session_start();
    
    
    if(isset($_SESSION["licens"])){
        
    }else{
        header("location: funktioner/loginForm.php");
    }
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

        <script type="text/javascript">
        let rutaOrdning = 0;

        function laggTillTextruta() {

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.name = "textruta";

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

        function laggTillBildruta(){

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.name = "bildruta";

            let bild = document.createElement("div");
            let bildInnehall = document.createTextNode("Bild: ");
            let bildInput = document.createElement("input");
            bildInput.type = "text";
            bildInput.name = "bild" + rutaOrdning;
            bild.appendChild(bildInnehall);
            bild.appendChild(bildInput);
            ruta.appendChild(bild);
            body.appendChild(ruta);

        }

    </script>

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
            <br>

            <!-- Skapa blogg -->

            <h4>Skapa en Blogg:</h4>
                <form action="funktioner/skapaBlogg.php" method="get">
                Namn:<input type="text" name="Titel">
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
                <input type="submit" value="Skapa Blogg">
                </form>
                <br><br>

            <!-- Redigera titel på en blogg -->

            <h4>Redigera titel på ett inlägg</h4>

            <form action="funktioner/redigerablogg.php" method="get">
                Titel:
                <input type="text" name="Titel">
                <br>
                <br>
                Blogg:
                <select name="BID" id="BID">
                <?php 
                    include('funktioner/dbh.inc.php');
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
                <input type="submit" value="Redigera titel">
            </form>
            <br>
            <br>

            <!-- Ta bort blogg -->

            <h4>Ta bort en Blogg:</h4>

            <form action="funktioner/tabort.php?tabortBlogg">
            Välj en blogg:
                <select name="BID" id="BID">
                    <?php 
                        include('funktioner/dbh.inc.php');
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

            </div>
            <div id="Inlagg" class="tab-pane fade">

            <!-- Skapa ett inlägg -->

            <h4>Skapa ett inlägg</h4>

            <form action="funktioner/skapainlagg.php" method="get">
                Välj en blogg:
                <select name="BID" id="BID">
                    <?php
                    include('funktioner/dbh.inc.php');
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
                <br>
                <br>

                Blogginläggs titel: <input type="text" name="Title"><br /><br />
                <div id="rutor-container">
                    <div class="ruta text">
                        <div class="ruta text rubrik">
                            Rubrik Paragraf: <input type="text" name="rubrik"><br /><br />
                        </div>
                        <div class="ruta innertext">
                            Text Paragraf: 
                            <br>
                            <textarea name="text" placeholder="Skriv in ett inlägg här..."></textarea><br /><br />
                        </div>
                    </div>
                </div>
                <input type="button" name="textRuta" value="Lägg till Textruta" onclick="laggTillTextruta()"><br /><br />
                <input type="button" name="bildRuta" value="Lägg till Bildruta" onclick="laggTillBildruta()"><br /><br />
                <input type="submit" value="Skapa inlägg">
            </form><br><br>

            <!-- Redigera titel på ett inlägg -->

            <h4>Redigera titel på ett inlägg</h4>

            <form action="funktioner/inlaggredfunktion.php" method="get">
                Titel:
                <input type="text" name="Titel">
                <br>
                <br>
                Inlägg:
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
                <input type="submit" value="Redigera titel">
            </form>
            <br>
            <br>

            <!-- Ta bort ett inlägg -->

            <h4>Ta bort ett inlägg</h4>

            <form action="funktioner/tabortinlagg.php" method="get">
                Inlägg:
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
                <br>
                <br>
                <input type="submit" value="Ta bort inlägg">
            </form> 
            <br><br>

            <!-- Gilla ett inlägg -->

            <h4>Gilla ett inlägg</h4>
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
            <br>
            <br>

            <!-- Redigera textruta -->

            <h4>Redigera textruta</h4>

            <form action="funktioner/redigeratextruta.php" method="get">
                <input type="text" name="Text">
                <input type="text" name="ordning">
                <br>
                <select name="RID">
                <?php
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT * from textruta";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["RID"] ."'>RID: ". $row['RID']."</option>";
                        }
                        echo "</table>";
                        } else { echo "0 results"; }
                    
                ?>
                </select>
                <br>

                <input type="submit" value="Redigera textruta">
            </form>
            <br>
            <br>

            <!-- Ta bort en ruta -->

            <h4>Ta bort en textruta</h4>

            <form action="funktioner/taborttextruta.php" method="get">
            <select name="RID">
            <?php
                include('funktioner/dbh.inc.php');
                $sql = "SELECT * from rutor";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option>" . $row['RID'] . "</option>";
                }
                $conn->close();
                
            ?>
            </select>
            <br>
            <br>
            <input type="submit" value="Ta bort textruta">
            </form>

            </div>
            <div id="Kommentar" class="tab-pane fade">

            <!-- Skapa en kommentar -->

            <h4>Skapa en kommentar</h4>

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
        <br>
        <br>
        <!-- Redigera kommentar -->

        <h4>Redigera kommentar</h4>

        <form action="funktioner/redigerakommentar.php" method="get">
        <textarea name="text" rows="10" cols="30">ny text</textarea>
        <br>
        <select name="KID">
        <?php
        include('funktioner/dbh.inc.php');
        $sql = "SELECT * from kommentar";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='". $row["KID"] ."'>KID: ". $row['KID']."</option>";
            }
            echo "</table>";
            } else { echo "0 results"; }
        
        ?>
        </select>
        <br>

        <input type="submit" value="Redigera kommentar">
        </form>
        <br>
        <br>

        <!-- Ta bort en kommentar -->

        <h4>Ta bort en kommentar</h4>

        <form action="funktioner/delkomfunc.php" method="get">
            <select name="KID">
            <?php
                include("funktioner/dbh.inc.php");
                $sql = "SELECT * from kommentar";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['KID'] . "'>" . $row['KID'] . " | " . $row['text'] . "</option>";
                    }
                } else { 
                    echo "0 results"; 
                }
                $conn->close();
                
            ?>
            </select>
            <input type="submit" value="Ta bort kommentaren">
        </form>

        </div>
        </div>
        </div>
    </body>
</html>