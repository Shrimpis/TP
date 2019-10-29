<?php
$valjkalender = "SELECT kalender.id, kalender.tjanstId, tjanst.titel, tjanst.privat FROM kalender INNER JOIN tjanst ON kalender.tjanstId = tjanst.id WHERE tjanst.anvandarId =". $row["kontoID"] ."";
$kalenderresult = $conn->query($valjkalender);
if ($kalenderresult->num_rows > 0) {
    while($kalenderrow = $kalenderresult->fetch_assoc()) {
        echo 
            "
            <div id='accordionkalender". $kalenderrow["id"] ."'>
                <div class='card'>
                
                    <div class='card-header' id='headingOne'>
                    <h5 class='mb-0'>
                        <button class='btn btn-link' data-toggle='collapse' data-target='#collapsekalender". $kalenderrow["id"] ."' aria-expanded='true' aria-controls='collapsekalender". $kalenderrow["id"] ."'>
                        ". $kalenderrow["titel"] ."
                        </button>
                    </h5>
                    </div>

                    <div id='collapsekalender". $kalenderrow["id"] ."' class='collapse' aria-labelledby='headingOne' data-parent='#accordionkalender". $kalenderrow["id"] ."'>
                        <div class='card-body'>
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-information-tab' data-toggle='tab' href='#nav-information-kalender". $kalenderrow["id"] ."' role='tab' aria-controls='nav-information' aria-selected='true'>Information</a>
                                    <a class='nav-item nav-link' id='nav-installnigar-tab' data-toggle='tab' href='#nav-installnigar-kalender". $kalenderrow["id"] ."' role='tab' aria-controls='nav-installnigar' aria-selected='false'>Inställningar</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='nav-information-kalender". $kalenderrow["id"] ."' role='tabpanel' aria-labelledby='nav-information-tab'>
                                    <div style='padding: 10px 10px 10px 10px;'>
                                        <p>Namn: <strong>". $kalenderrow["titel"] ."</strong></p>
                                        <p>KalenderID: <strong>". $kalenderrow["id"] ."</strong></p>
                                        <p>Privat: <strong>";
                                        
                                        if($kalenderrow["privat"] == 1){
                                            echo "Ja";
                                        } else {
                                            echo "Nej";
                                        }

                                        echo "
                                        </strong></p>
                                        <p>Kalendrar: <strong>";
                                        $kalendersidor = "SELECT id FROM kalender WHERE id =". $kalenderrow["id"] ."";
                                        $kalenderresult3 = $conn->query($kalendersidor);
                                            if ($kalenderresult3->num_rows > 0) {
                                                echo $kalenderresult3->num_rows;
                                            } else {
                                                echo "0";
                                            }
                                        echo"</strong>
                                    </div>
                                </div>

                                <div class='tab-pane fade' id='nav-installnigar-kalender". $kalenderrow["id"] ."' role='tabpanel' aria-labelledby='nav-installnigar-tab'>
                                    <div class='row' style='padding: 10px 10px 10px 10px;'>
                                        <form action='../kalender/funktioner/tabort.php' method='POST' style='padding-right: 5px;'>
                                            <input type='hidden' name='funktion' value='tabortkalender'/>
                                            <input name='id' type='hidden' value='". $kalenderrow["id"] ."'>
                                            <button type='submit' class='btn btn-danger btn-sm'>Ta bort kalender</button>
                                        </form>
                                        <form action='../kalender/funktioner/tabort.php' method='POST'>
                                            <input type='hidden' name='funktion' value=''/>
                                            <input name='id' type='hidden' value=''>
                                            <button type='submit' class='btn btn-warning btn-sm'>Deaktivera kalender</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
";
    }
} else {
    echo "
    <div class='alert alert-info alert-dismissible fade show' role='alert'>
        <strong>INFO:</strong> Kunden har inga kalenders just nu.
    </div>
  ";
}

?>