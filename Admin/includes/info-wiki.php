<?php
$valjwiki = "SELECT wiki.id, wiki.tjanstId, wiki.dolt, tjanst.titel, tjanst.privat FROM wiki INNER JOIN tjanst ON wiki.tjanstId = tjanst.id WHERE tjanst.anvandarId =". $row["kontoID"] ."";
$wikiresult = $conn->query($valjwiki);
if ($wikiresult->num_rows > 0) {
    while($wikirow = $wikiresult->fetch_assoc()) {
        echo 
            "
            <div id='accordionwiki". $wikirow["id"] ."'>
                <div class='card'>
                
                    <div class='card-header' id='headingOne'>
                    <h5 class='mb-0'>
                        <button class='btn btn-link' data-toggle='collapse' data-target='#collapsewiki". $wikirow["id"] ."' aria-expanded='true' aria-controls='collapsewiki". $wikirow["id"] ."'>
                        ". $wikirow["titel"] ."
                        </button>
                    </h5>
                    </div>

                    <div id='collapsewiki". $wikirow["id"] ."' class='collapse' aria-labelledby='headingOne' data-parent='#accordionwiki". $wikirow["id"] ."'>
                        <div class='card-body'>
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-information-tab' data-toggle='tab' href='#nav-information-wiki". $wikirow["id"] ."' role='tab' aria-controls='nav-information' aria-selected='true'>Information</a>
                                    <a class='nav-item nav-link' id='nav-installnigar-tab' data-toggle='tab' href='#nav-installnigar-wiki". $wikirow["id"] ."' role='tab' aria-controls='nav-installnigar' aria-selected='false'>Inställningar</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='nav-information-wiki". $wikirow["id"] ."' role='tabpanel' aria-labelledby='nav-information-tab'>
                                    <div style='padding: 10px 10px 10px 10px;'>
                                        <p>Namn: <strong>". $wikirow["titel"] ."</strong></p>
                                        <p>WikiID: <strong>". $wikirow["id"] ."</strong></p>
                                        <p>Privat: <strong>";
                                        
                                        if($wikirow["privat"] == 1){
                                            echo "Ja";
                                        } else {
                                            echo "Nej";
                                        }

                                        echo "
                                        </strong></p>
                                        <p>Sidor: <strong>";
                                        $wikisidor = "SELECT wikiId FROM wikisidor WHERE wikiId =". $wikirow["id"] ."";
                                        $wikiresult3 = $conn->query($wikisidor);
                                            if ($wikiresult3->num_rows > 0) {
                                                echo $wikiresult3->num_rows;
                                            } else {
                                                echo "0";
                                            }
                                        echo"</strong>
                                    </div>
                                </div>

                                <div class='tab-pane fade' id='nav-installnigar-wiki". $wikirow["id"] ."' role='tabpanel' aria-labelledby='nav-installnigar-tab'>
                                    <div class='row' style='padding: 10px 10px 10px 10px;'>
                                        <form action='../wiki/funktioner/tabort.php' method='POST' style='padding-right: 5px;'>
                                            <input type='hidden' name='funktion' value='tabortWiki'/>
                                            <input name='id' type='hidden' value='". $wikirow["id"] ."'>
                                            <button type='submit' class='btn btn-danger btn-sm'>Ta bort wiki</button>
                                        </form>
                                        <form action='../wiki/funktioner/tabort.php' method='POST'>
                                            <input type='hidden' name='funktion' value=''/>
                                            <input name='id' type='hidden' value=''>
                                            <button type='submit' class='btn btn-warning btn-sm'>Deaktivera wiki</button>
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
        <strong>INFO:</strong> Kunden har inga wikis just nu.
    </div>
  ";
}

?>