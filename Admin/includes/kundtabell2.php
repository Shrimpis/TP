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
                <div class='card-body'>
                <p>Tjänster:</p>
                <form>
                  <div class='form-check'>";

                $blogg = mysqli_query($conn, "SELECT blogg FROM kund WHERE id=". $row["id"] ." AND blogg = 1");
                $wiki = mysqli_query($conn, "SELECT wiki FROM kund WHERE id=". $row["id"] ." AND wiki = 1");
                $kalender = mysqli_query($conn, "SELECT kalender FROM kund WHERE id=". $row["id"] ." AND kalender = 1");

                //Kollar om blogg tjänsten är aktiverad
                    if($blogg->num_rows == 0){
                        echo "<input type='checkbox' class='form-check-input' id='CheckBlogg'>";
                    } else {
                        echo "<input type='checkbox' class='form-check-input' id='CheckBlogg' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckBlogg'>Blogg</label><br>";

                //Kollar om wiki tjänsten är aktiverad
                    if($wiki->num_rows == 0){
                        echo "<input type='checkbox' class='form-check-input' id='CheckWiki'>";
                    } else {
                        echo "<input type='checkbox' class='form-check-input' id='CheckWiki' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckWiki'>Wiki</label><br>";

                //Kollar om kalender tjänsten är aktiverad
                    if($kalender->num_rows == 0){
                        echo "<input type='checkbox' class='form-check-input' id='CheckKalender'>";
                    } else {
                        echo "<input type='checkbox' class='form-check-input' id='CheckKalender' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckKalender'>Kalender</label><br>";

                    echo "
                  </div>
                  <button type='submit' class='btn btn-primary btn-sm' style='margin-top:4px;margin-bottom:30px;'>Aktivera tjänst</button>
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
                    }

                    echo 
                    "
                    <p>Konto Inställningar:</p>
                    <div class='row'>
                    <form action='funktioner/' method='POST'>
                        <button type='button' class='btn btn-danger btn-sm'>Avsluta konto</button>
                    </form>
                    <form action='funktioner/' method='POST'>
                        <button type='button' class='btn btn-warning btn-sm'>Deaktivera konto</button>
                    </form>
                    </div>
                    ";

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