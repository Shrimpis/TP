<?php 
    include("funktioner/dbh.inc.php");
    
    session_start();
 
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"></script>
        <script src="js/visaBlogg.js"></script>
        
        <script src="js/skapainlagg.js"></script>
    </head>
    <body onload="init()">
    <div class="container">
        <h2>The Provider</h2>
        <p>Blogg Funktioner</p>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#Blogg">Blogg</a></li>
            <li><a data-toggle="tab" href="#VisaBlogg">Visa Blogg</a></li>
            <li><a data-toggle="tab" href="#Inlagg">Inlägg</a></li>
            <li><a data-toggle="tab" href="#Kommentar2">Kommentar</a></li>
        </ul>
        <div class="tab-content">
            <div id="Blogg" class="tab-pane fade in active">
            <h3>Blogg</h3>
            <br>
            <!-- Skapa blogg -->

            <h4>Skapa en Blogg:</h4>
                <form action="funktioner/skapa.php" method="POST">
                <input type='hidden' name='funktion' value='skapaBlogg'/>
                Namn:<input type="text" name="Titel">
                <br><br>
                Välj en användare:
                <select name="UID" id="UID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, fnamn, enamn FROM anvandare";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>AnvändareID: ". $row["id"]." | ". $row["fnamn"]." ". $row["enamn"]."</option>";
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
            <form action="funktioner/redigera.php" method="POST">
                <input type='hidden' name='funktion' value='redigeraBlogg'/>
                Titel:
                <input type="text" name="Titel">
                <br>
                <br>
                Blogg:
                <select name="BID" id="BID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, titel, anvandarId FROM blogg";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>ID: ". $row["anvandarId"]." | ". $row["titel"]."</option>";
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
            <form action="funktioner/tabort.php" method="post">
            <input type='hidden' name='funktion' value='tabortBlogg'/>
            Välj en blogg:
                <select name="BID" id="BID">
                    <?php 
                        include('funktioner/dbh.inc.php');
                        $sql = "SELECT id, titel, anvandarId FROM blogg";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["id"] ."'>ID: ". $row["anvandarId"]." | ". $row["titel"]."</option>";
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
            <!-- Visa Blogg -->
            <div id="VisaBlogg" class="tab-pane fade in active">
                <h3>Visa Blogg</h3>
                <br>
                <div id="bloggContainer" class="bloggContainer">
                    <div id="headerContainer" class="headerContainer"></div>
                    <br>
                    <div id="skribentContainer" class="skribentContainer"></div>
                    <br>
                    <h4><strong>Inlägg i bloggen:</strong></h4>
                    <div id="bloggInlaggContainer" class="bloggInlaggContainer"></div>
                    <br>
                    <strong>Kommentarer:</strong>
                    <div id="kommentarContainer" class="kommentarContainer"></div>
                </div>
            </div>
            <div id="Inlagg" class="tab-pane fade">
            <!-- Skapa ett inlägg -->

            <h4>Skapa ett inlägg</h4>

            <form action="funktioner/skapainlagg.php" method="get">
            <form action="funktioner/skapa.php" method="POST">
            <input type='hidden' name='funktion' value='skapaInlagg'/>
                Välj en blogg:
                <select name="BID" id="BID">
                    <?php
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, titel, anvandarId FROM blogg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>ID: " . $row["anvandarId"] . " | " . $row["titel"] . "</option>";
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
                            <textarea id="inlaggtext" name="text" placeholder="Skriv in ett inlägg här..."></textarea><br /><br />
                        </div>
                    </div>
                </div>
                <input type="button" name="textRuta" value="Lägg till Textruta" onclick="laggTillTextruta()"><br /><br />
                <input type="button" name="bildRuta" value="Lägg till Bildruta" onclick="laggTillBildruta()"><br /><br />
                <input type="submit" value="Skapa inlägg">
            </form><br><br>
            <!-- Redigera titel på ett inlägg -->

            <h4>Redigera titel på ett inlägg</h4>

            <form action="funktioner/redigera.php" method="get">
            <form action="funktioner/redigera.php" method="POST">
            <input type='hidden' name='funktion' value='redigeraInlagg'/>
                Titel:
                <input type="text" name="Titel">
                <br>
                <br>
                Inlägg:
                <select name="IID" id="IID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, bloggId, titel FROM blogginlagg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>BloggID: ". $row["bloggId"]." | ". $row["titel"]."</option>";
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

            <form action="funktioner/tabort.php" method="get">
            <form action="funktioner/tabort.php" method="POST">
            <input type='hidden' name='funktion' value='tabortInlagg'/>
                Inlägg:
                <select name="IID" id="IID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, bloggId, titel FROM blogginlagg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>BloggID: ". $row["bloggId"]." | ". $row["titel"]."</option>";
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
            <form action="funktioner/skapa.php">
            <input type='hidden' name='funktion' value='gillaInlag'/>
            Välj ett inlägg:
            <select name="IID" id="IID">
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, bloggId, titel FROM blogginlagg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>BloggID: ". $row["bloggId"]." | ". $row["titel"]."</option>";
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
                    $sql = "SELECT id, fnamn, enamn FROM anvandare";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>AnvändareID: ". $row["id"]." | ". $row["fnamn"]." ". $row["enamn"]."</option>";
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
<<<<<<< HEAD
            <!-- Redigera textruta -->

            <h4>Redigera textruta</h4>

            <form action="funktioner/redigera.php" method="get">
            <form action="funktioner/redigera.php" method="POST">
            <input type='hidden' name='funktion' value='redigeraTextruta'/>
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

            <form action="funktioner/tabort.php" method="get">
            <form action="funktioner/tabort.php" method="POST">
            <input type='hidden' name='funktion' value='tabortTextruta'/>
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
            <div id="Kommentar2" class="tab-pane fade">
=======
            <div id="Kommentar" class="tab-pane fade">
>>>>>>> master
            <!-- Skapa en kommentar -->

            <h4>Skapa en kommentar</h4>

            <form action="funktioner/skapaKommentar.php">
            <form action="funktioner/skapa.php">
            <input type='hidden' name='funktion' value='skapaKommentar'/>
            Välj att kommentera:
            <select name="hierarchyID" id="hierarchyID">
                <option value="0">Ingen</option>
                <?php 
                    include('funktioner/dbh.inc.php');
                    $sql = "SELECT id, innehall FROM kommentar";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>KID: ". $row["id"]." | ". $row["innehall"]."</option>";
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
                    $sql = "SELECT id, bloggId, titel FROM blogginlagg";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>BloggID: ". $row["bloggId"]." | ". $row["titel"]."</option>";
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
                    $sql = "SELECT id, fnamn, enamn FROM anvandare";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] ."'>AnvändareID: ". $row["id"]." | ". $row["fnamn"]." ". $row["enamn"]."</option>";
                    }
                    echo "</table>";
                    } else { echo "0 results"; }
                    $conn->close();
                ?>
            </select>
            <br><br>
            <textarea id="kommentartext" name="text" rows="10" cols="30"></textarea>
            <br><br>
            <input type="submit" value="Skapa Kommentar">
        </form>
        <br>
        <br>
        <!-- Redigera kommentar -->

        <h4>Redigera kommentar</h4>

        <form action="funktioner/redigera.php" method="get">
        <form action="funktioner/redigera.php" method="POST">
            <input type='hidden' name='funktion' value='redigeraKommentar'/>
            <textarea name="text" rows="10" cols="30">ny text</textarea>
            <br>
            <select name="KID">
            <?php
            include('funktioner/dbh.inc.php');
            $sql = "SELECT * from kommentar";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='". $row["id"] ."'>KID: ". $row['id']."</option>";
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

        <form action="funktioner/tabort.php" method="get">
        <form action="funktioner/tabort.php" method="POST">
        <input type='hidden' name='funktion' value='tabortKommentar'/>
            <select name="KID">
            <?php
                include("funktioner/dbh.inc.php");
                $sql = "SELECT * from kommentar";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . " | " . $row['innehall'] . "</option>";
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
    
    <script>
        var simplemde = new SimpleMDE({ element: document.getElementById("inlaggtext") });
        var simplemde = new SimpleMDE({ element: document.getElementById("kommentartext") });
    </script>
</html>