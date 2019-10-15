<?php 
    include('funktioner/dbh.inc.php');
    $sql = "SELECT id, blogg, wiki, kalender, aktiv FROM kund";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo 
        "
        <div id='accordion'>
            <div class='card'>
            <div class='card-header' id='headingThree'>
                <h5 class='mb-0'>
                <button class='btn btn-link collapsed' data-toggle='collapse' data-target='#Kund". $row["id"] ."' aria-expanded='false' aria-controls='collapseThree'>
                    Kund #". $row["id"] ."
                </button>
                </h5>
            </div>
            <div id='Kund". $row["id"] ."' class='collapse' aria-labelledby='Kund". $row["id"] ."' data-parent='#accordion'>
                <div class='card-body'>";

                echo "
                <p>Tjänster:</p>
                <form action='funktioner/aktivera.php' method='POST'>
                  <div class='form-check'>
                  <input name='funktion' type='hidden' value='aktiveraTjanst'>
                  <input name='id' type='hidden' value='". $row["id"] ."'>
                  ";

                $blogg = mysqli_query($conn, "SELECT blogg FROM kund WHERE id=". $row["id"] ." AND blogg = 1");
                $wiki = mysqli_query($conn, "SELECT wiki FROM kund WHERE id=". $row["id"] ." AND wiki = 1");
                $kalender = mysqli_query($conn, "SELECT kalender FROM kund WHERE id=". $row["id"] ." AND kalender = 1");

                //Kollar om blogg tjänsten är aktiverad
                    if($blogg->num_rows == 0){
                        echo "<input name='bloggCheck' type='checkbox' class='form-check-input' id='CheckBlogg'>";
                    } else {
                        echo "<input name='bloggCheck' type='checkbox' class='form-check-input' id='CheckBlogg' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckBlogg'>Blogg</label><br>";

                //Kollar om wiki tjänsten är aktiverad
                    if($wiki->num_rows == 0){
                        echo "<input name='wikiCheck' type='checkbox' class='form-check-input' id='CheckWiki'>";
                    } else {
                        echo "<input name='wikiCheck' type='checkbox' class='form-check-input' id='CheckWiki' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckWiki'>Wiki</label><br>";

                //Kollar om kalender tjänsten är aktiverad
                    if($kalender->num_rows == 0){
                        echo "<input name='kalenderCheck' type='checkbox' class='form-check-input' id='CheckKalender'>";
                    } else {
                        echo "<input name='kalenderCheck' type='checkbox' class='form-check-input' id='CheckKalender' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckKalender'>Kalender</label><br>";

                    echo "
                  </div>
                  <button type='submit' class='btn btn-primary btn-sm' style='margin-top:4px;margin-bottom:30px;'>Spara tjänst</button>
                </form>";
                
                //Kollar om ett superadmin konto redan är skapat
                $superadmin = mysqli_query($conn, "SELECT superadmin FROM kund WHERE id=". $row["id"] ." AND superadmin = 1");

                if($blogg->num_rows != 0 || $wiki->num_rows != 0 || $kalender->num_rows != 0){
                    
                    if($superadmin->num_rows == 0){

                        echo 
                        "
                        <p>Skapa konto för Superadmin:</p>
                    
                        <form action='funktioner/skapa.php' method='POST'>
                        <input type='hidden' name='funktion' value='skapaKonto'/>
                        <input type='hidden' name='rollid' value='1'/>
                            <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text' id='basic-addon1'><i class='fas fa-user'></i></span>
                            </div>
                            <input type='text' class='form-control' placeholder='Användarnamn' aria-label='Användarnamn' name='anamn' aria-describedby='basic-addon1'>
                            </div>
                            <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text' id='basic-addon1'><i class='fas fa-key'></i></span>
                            </div>
                            <input type='text' class='form-control' placeholder='Lösenord' aria-label='Lösenord' name='losenord' aria-describedby='basic-addon1'>
                            </div>
                        <button type='submit' class='btn btn-primary btn-sm' style='margin-top:4px;margin-bottom:10px;'>Skapa konto</button>
                        </form>
                        ";

                    } else {
                        $deaktiverat = mysqli_query($conn, "SELECT aktiv FROM kund WHERE id=". $row["id"] ." AND aktiv=0");
                        if($deaktiverat->num_rows != 0){
                            echo 
                            "
                            <div class='alert alert-danger' role='alert'>
                                <strong>Info:</strong> Kundens konto är deaktiverat.
                            </div>
                            ";
                        }
                        echo 
                        "
                        <p>Superadmin information:</p>
    
                        <form action='funktioner/skapa.php' method='POST'>
                        <input type='hidden' name='funktion' value='skapaKonto'/>
                            <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text' id='basic-addon1'><i class='fas fa-user'></i></span>
                            </div>
                            <input type='text' class='form-control' placeholder='Användarnamn' aria-label='Användarnamn' name='anamn' aria-describedby='basic-addon1'>
                            </div>
                            <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text' id='basic-addon1'><i class='fas fa-key'></i></span>
                            </div>
                            <input type='text' class='form-control' placeholder='Lösenord' aria-label='Lösenord' name='losenord' aria-describedby='basic-addon1'>
                            </div>
                        <button type='submit' class='btn btn-primary btn-sm' style='margin-top:4px;margin-bottom:10px;'>Redigera konto</button>
                        </form>
                        ";

                        echo
                        "
                        <div style='margin-top:20px;margin-bottom:20px;'>
                            <ul class='nav nav-tabs' id='myTab' role='tablist'>
                                <li class='nav-item'>
                                    <a class='nav-link active' id='blogg-tab' data-toggle='tab' href='#blogg". $row["id"] ."' role='tab' aria-controls='blogg' aria-selected='true'>Blogg</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' id='wiki-tab' data-toggle='tab' href='#wiki". $row["id"] ."' role='tab' aria-controls='wiki' aria-selected='false'>Wiki</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' id='kalender-tab' data-toggle='tab' href='#kalender". $row["id"] ."' role='tab' aria-controls='kalender' aria-selected='false'>Kalender</a>
                                </li>
                            </ul>
                            <div class='tab-content' id='myTabContent' style='padding: 10px 10px 10px 10px'>
                                <div class='tab-pane fade show active' id='blogg". $row["id"] ."' role='tabpanel' aria-labelledby='blogg-tab'>
                                    <p>Kundens aktiva bloggar:</p>
                                    <table class='table'>
                                        <thead>
                                            <tr>
                                            <th scope='col'>#</th>
                                            <th scope='col'>Titel</th>
                                            <th scope='col'>Privat</th>
                                            <th scope='col'>Inlägg</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope='row'>1</th>
                                                <td>Test blogg</td>
                                                <td>Nej</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>2</th>
                                                <td>Test blogg 2</td>
                                                <td>Ja</td>
                                                <td>3</td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>3</th>
                                                <td>Test blogg 3</td>
                                                <td>Nej</td>
                                                <td>2</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class='tab-pane fade' id='wiki". $row["id"] ."' role='tabpanel' aria-labelledby='wiki-tab'>
                                    <p>Kundens aktiva wikis:</p>
                                    <table class='table'>
                                    <thead>
                                        <tr>
                                        <th scope='col'>#</th>
                                        <th scope='col'>Titel</th>
                                        <th scope='col'>Privat</th>
                                        <th scope='col'>Sidor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope='row'>1</th>
                                            <td>Test wiki</td>
                                            <td>Nej</td>
                                            <td>7</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>2</th>
                                            <td>Test wiki 2</td>
                                            <td>Ja</td>
                                            <td>3</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>3</th>
                                            <td>Test wiki 3</td>
                                            <td>Nej</td>
                                            <td>1</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>

                                <div class='tab-pane fade' id='kalender". $row["id"] ."' role='tabpanel' aria-labelledby='kalender-tab'>
                                    <p>Kundens aktiva kalendrar:</p>
                                    <table class='table'>
                                    <thead>
                                        <tr>
                                        <th scope='col'>#</th>
                                        <th scope='col'>Titel</th>
                                        <th scope='col'>Privat</th>
                                        <th scope='col'>Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope='row'>1</th>
                                            <td>Test blogg</td>
                                            <td>Nej</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>2</th>
                                            <td>Test blogg 2</td>
                                            <td>Ja</td>
                                            <td>3</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>3</th>
                                            <td>Test blogg 3</td>
                                            <td>Nej</td>
                                            <td>2</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        ";
                    }

                    echo 
                    "
                    <p>Konto Inställningar:</p>
                    <div class='row'>

                    <form action='funktioner/konto.php' method='POST'>
                        <input type='hidden' name='funktion' value='avslutaKonto'/>
                        <input name='id' type='hidden' value='". $row["id"] ."'>
                        <button type='submit' class='btn btn-danger btn-sm'>Avsluta konto</button>
                    </form>";

                    $aktiv = mysqli_query($conn, "SELECT aktiv FROM kund WHERE id=". $row["id"] ." AND aktiv=1");

                    if($aktiv->num_rows != 0){
                        echo 
                        "
                        <form action='funktioner/konto.php' method='POST'>
                            <input type='hidden' name='funktion' value='deaktiveraKonto'/>
                            <input name='id' type='hidden' value='". $row["id"] ."'>
                            <button type='submit' class='btn btn-warning btn-sm'>Deaktivera konto</button>
                        </form>
                        ";
                    } else {
                        echo
                        "
                        <form action='funktioner/konto.php' method='POST'>
                            <input type='hidden' name='funktion' value='aktiveraKonto'/>
                            <input name='id' type='hidden' value='". $row["id"] ."'>
                            <button type='submit' class='btn btn-success btn-sm'>Aktivera konto</button>
                        </form>
                        ";
                    }

                    echo "</div>";

                } else {
                    echo 
                    "
                    <div class='alert alert-primary' role='alert'>
                        <strong>Info:</strong> Kunden har ingen tjänst aktiverad.
                    </div>
                    ";
                }

                echo "
                <br>
            </div>
            </div>
            </div>
        </div>
        ";

    }
    echo "</table>";
    } else { echo "0 results"; }
    $conn->close();
?>