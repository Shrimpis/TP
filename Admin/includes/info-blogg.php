<?php 


$valjblogg = "SELECT blogg.id, blogg.tjanstId, blogg.flaggad, tjanst.titel, tjanst.privat FROM blogg INNER JOIN tjanst ON blogg.tjanstId = tjanst.id WHERE tjanst.anvandarId =". $row["kontoID"] ."";
$result2 = $conn->query($valjblogg);
if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
        echo 
            "
            <div id='accordionBlogg". $row2["id"] ."'>
                <div class='card'>
                
                    <div class='card-header' id='headingOne'>
                    <h5 class='mb-0'>
                        <button class='btn btn-link' data-toggle='collapse' data-target='#collapseBlogg". $row2["id"] ."' aria-expanded='true' aria-controls='collapseBlogg". $row2["id"] ."'>
                        ". $row2["titel"] ."
                        </button>
                    </h5>
                    </div>

                    <div id='collapseBlogg". $row2["id"] ."' class='collapse' aria-labelledby='headingOne' data-parent='#accordionBlogg". $row2["id"] ."'>
                        <div class='card-body'>
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                <a class='nav-item nav-link active' id='nav-information-tab' data-toggle='tab' href='#nav-information". $row2["id"] ."' role='tab' aria-controls='nav-information' aria-selected='true'>Information</a>
                                <a class='nav-item nav-link' id='nav-installnigar-tab' data-toggle='tab' href='#nav-installnigar". $row2["id"] ."' role='tab' aria-controls='nav-installnigar' aria-selected='false'>Inställningar</a>
                                <a class='nav-item nav-link' id='nav-flagg-tab' data-toggle='tab' href='#nav-flagg". $row2["id"] ."' role='tab' aria-controls='nav-flagg' aria-selected='false'>Flaggningar</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='nav-information". $row2["id"] ."' role='tabpanel' aria-labelledby='nav-information-tab'>
                                    <div style='padding: 10px 10px 10px 10px;'>
                                        <p>Namn: <strong>". $row2["titel"] ."</strong></p>
                                        <p>Privat: <strong>";
                                        
                                        if($row2["privat"] == 1){
                                            echo "Ja";
                                        } else {
                                            echo "Nej";
                                        }

                                        echo "
                                        </strong></p>
                                        <p>Inlägg: <strong>";
                                        $inlagg = "SELECT bloggId FROM blogginlagg WHERE bloggId =". $row2["id"] ."";
                                        $result3 = $conn->query($valjblogg);
                                            if ($result3->num_rows > 0) {
                                                echo $result3->num_rows;
                                            } else {
                                                echo "0";
                                            }


                                        echo "</strong></p>
                                        <p>Kommentarer: <strong>";
                                        $kommentar = "SELECT inlaggId FROM kommentar INNER JOIN blogginlagg ON blogginlagg.id = kommentar.inlaggId WHERE blogginlagg.bloggId=". $row2["id"] ."";
                                        $result3 = $conn->query($valjblogg);
                                            if ($result3->num_rows > 0) {
                                                echo $result3->num_rows;
                                            } else {
                                                echo "0";
                                            }
                                        echo"</strong></p>
                                    </div>
                                </div>

                                <div class='tab-pane fade' id='nav-installnigar". $row2["id"] ."' role='tabpanel' aria-labelledby='nav-installnigar-tab'>
                                    <div class='row' style='padding: 10px 10px 10px 10px;'>
                                        <form action='funktioner/' method='POST' style='padding-right: 5px;'>
                                            <input type='hidden' name='funktion' value=''/>
                                            <input name='id' type='hidden' value=''>
                                            <button type='submit' class='btn btn-danger btn-sm'>Ta bort blogg</button>
                                        </form>
                                        <form action='funktioner/' method='POST'>
                                            <input type='hidden' name='funktion' value=''/>
                                            <input name='id' type='hidden' value=''>
                                            <button type='submit' class='btn btn-warning btn-sm'>Deaktivera blogg</button>
                                        </form>
                                    </div>
                                </div>

                                <div class='tab-pane fade' id='nav-flagg". $row2["id"] ."' role='tabpanel' aria-labelledby='nav-flagg-tab'>
                                    <div class='row' style='padding: 10px 10px 10px 10px;'>
                                        <p>Antal flaggningar: <strong><font color='red'>". $row2["flaggad"] ."</font></strong></p>

                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                <th scope='col'>#</th>
                                                <th scope='col'>Titel</th>
                                                <th scope='col'>Flaggad</th>
                                                <th scope='col'>Datum</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope='row'>1</th>
                                                    <td>En dag i mitt liv</td>
                                                    <td>2</td>
                                                    <td>2019-10-02</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>2</th>
                                                    <td>Fotboll är kul</td>
                                                    <td>13</td>
                                                    <td>2019-10-09</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>3</th>
                                                    <td>Polkagrisar är inte så värst nyttiga...</td>
                                                    <td>1</td>
                                                    <td>2019-10-15</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
";
    }
}

?>