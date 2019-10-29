<?php 
    
    // The Provider customers databasanslutning //

    $dbServername2 = 'localhost';
    $dbUsername2 = 'root';
    $dbPassword2 = '';
    $dbName2 = 'customers';

    $conn2 = mysqli_connect($dbServername2, $dbUsername2, $dbPassword2, $dbName2, "3306");
    mysqli_set_charset($conn2, "utf8mb4");

    include("../Databas/dbh.inc.php");

    // Kundtabellfunktioner //

    $total_pages = $conn2->query('SELECT COUNT(*) FROM customers')->fetch_row()[0];

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    if(isset($_GET['limit'])){
        $num_results_on_page = $_GET['limit'];
    } else {
        $num_results_on_page = 5; //Kundgräns på hur många kunder som ska visas i vyn.
    }


    //$sql = "SELECT kundrattigheter.id, kundrattigheter.tjanst, kundrattigheter.kontoID FROM kundrattigheter ORDER BY kundrattigheter.id LIMIT ?,?";
    //$result = $conn->query($sql);

    //if($stmt = $conn->prepare('SELECT kundrattigheter.id, kundrattigheter.tjanst, kundrattigheter.kontoID FROM kundrattigheter ORDER BY kundrattigheter.id LIMIT ?,?'))


    if($stmt = $conn2->prepare('SELECT customers.customers.id, customers.customers.namn, TheProvider.kundrattigheter.kontoID 
                                FROM customers.customers LEFT JOIN TheProvider.kundrattigheter ON customers.customers.id = TheProvider.kundrattigheter.id 
                                ORDER BY customers.customers.id LIMIT ?,?')){
        $calc_page = ($page - 1) * $num_results_on_page;
        $stmt->bind_param('ii', $calc_page, $num_results_on_page);
        $stmt->execute(); 
        // Get the results...
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        echo "Problem med att hämta kunder från databasen.";
    }

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo 
        "
        <div id='accordion'>
            <div class='card'>
            <div class='card-header' id='headingThree'>
                <h5 class='mb-0'>
                <button class='btn btn-link collapsed' data-toggle='collapse' data-target='#Kund". $row["id"] ."' aria-expanded='false' aria-controls='collapseThree'>
                    Kund #". $row["id"] ." - ". $row["namn"] ."
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

                $tjanst = mysqli_query($conn, "SELECT tjanst FROM kundrattigheter WHERE id=". $row["id"] ." AND tjanst = 1");

                //Kollar om blogg tjänsten är aktiverad
                    if($tjanst->num_rows == 0){
                        echo "<input name='CheckTjanst' type='checkbox' class='form-check-input' id='CheckTjanst'>";
                    } else {
                        echo "<input name='CheckTjanst' type='checkbox' class='form-check-input' id='CheckTjanst' checked>";
                    }
                    echo "<label class='form-check-label' for='CheckTjanst'>Blogg, Wiki och Kalender</label><br>";

                    echo "
                  </div>
                  <button type='submit' class='btn btn-primary btn-sm' style='margin-top:6px;margin-bottom:30px;'>Spara tjänst</button>
                </form>";
                
                //Kollar om ett superadmin konto redan är skapat
                $superadmin = mysqli_query($conn, "SELECT superadmin FROM kundrattigheter WHERE id=". $row["id"] ." AND superadmin = 1");

                if($tjanst->num_rows != 0){
                    
                    if($superadmin->num_rows == 0){

                        echo 
                        "
                        <p>Skapa konto för Superadmin:</p>
                    
                        <form name='skapaSuperAdmin' action='funktioner/skapa.php' method='POST'>
                        <input type='hidden' name='funktion' value='skapaKonto'/>
                        <input type='hidden' name='rollid' value='1'/>
                        <input type='hidden' name='id' value='". $row["id"] ."'/>
                            <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text' id='basic-addon1'><i class='fas fa-user'></i></span>
                            </div>
                            <input type='text' class='form-control' placeholder='Användarnamn' aria-label='Användarnamn' name='anamn' value='Superadmin-".$row["namn"]."".$row["id"]."' aria-describedby='basic-addon1' required autofocus>
                            </div>
                        <button type='submit' class='btn btn-primary btn-sm' style='margin-top:4px;margin-bottom:10px;'>Skapa konto</button>
                        </form>
                        ";

                    } else {
                        $deaktiverat = mysqli_query($conn, "SELECT anvandare.aktiv FROM anvandare WHERE id=". $row["kontoID"] ." AND aktiv=0");
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
                            <input type='text' value='"; 
                            
                            include "show-username.php";
                            
                            echo "' class='form-control' placeholder='Användarnamn' aria-label='Användarnamn' name='anamn' aria-describedby='basic-addon1'>
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
                        <div style='margin-top:10px;'>
                            <p>API-Nyckel:</p>
                    

                            <div class='input-group mb-3'>
                                <input type='password' class='form-control' aria-label='api' name='anamn' data-toggle='password' value='"; 

                                include "show-api.php";

                                echo "' aria-describedby='basic-addon1'>
                            </div>
                        </div>
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
                                    <p>Kundens aktiva bloggar:</p>";
                                    
                                    include "includes/info-blogg.php";
                                        
                                    
                            echo "
                                </div>
                                
                                <div class='tab-pane fade' id='wiki". $row["id"] ."' role='tabpanel' aria-labelledby='wiki-tab'>
                                    <p>Kundens aktiva wikis:</p>

                                </div>

                                <div class='tab-pane fade' id='kalender". $row["id"] ."' role='tabpanel' aria-labelledby='kalender-tab'>
                                    <p>Kundens aktiva kalendrar:</p>

                                </div>
                            </div>
                        </div>
                        ";
                    }

                    echo 
                    "
                    <p>Konto Inställningar:</p>
                    <div class='row'>

                    <form action='funktioner/tabort.php' method='POST'>
                        <input type='hidden' name='funktion' value='harddelkonto'/>
                        <input name='kontoID' type='hidden' value='". $row["kontoID"] ."'>
                        <input name='id' type='hidden' value='". $row["id"] ."'>
                        <button type='submit' class='btn btn-danger btn-sm'>Avsluta konto</button>
                    </form>";

                    $aktiv = mysqli_query($conn, "SELECT anvandare.aktiv FROM anvandare WHERE anvandare.id=". $row["kontoID"] ." AND anvandare.aktiv=1");

                    if($aktiv->num_rows != 0){
                        echo 
                        "
                        <form action='funktioner/konto.php' method='POST'>
                            <input type='hidden' name='funktion' value='deaktiveraKonto'/>
                            <input name='id' type='hidden' value='". $row["kontoID"] ."'>
                            <button type='submit' class='btn btn-warning btn-sm'>Deaktivera konto</button>
                        </form>
                        ";
                    } else {
                        echo
                        "
                        <form action='funktioner/konto.php' method='POST'>
                            <input type='hidden' name='funktion' value='aktiveraKonto'/>
                            <input name='id' type='hidden' value='". $row["kontoID"] ."'>
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
    
    } else { 
        echo 
        "
        <div class='alert alert-primary' style='text-align:center;' role='alert'>
            Inga resultat på sida ".$_GET['page']."
        </div>
        ";
    }
    $conn->close();
?>