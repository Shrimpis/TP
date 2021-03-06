<?php 

$conn = mysqli_connect('localhost','TheProvider','lösenord','TheProvider');
//mysqli_set_charset($conn. "utf8mb4");

$valjblogg = "SELECT blogg.id, blogg.tjanstId, tjanst.titel, tjanst.privat FROM blogg INNER JOIN tjanst ON blogg.tjanstId = tjanst.id WHERE tjanst.anvandarId =". $row["kontoID"] ."";
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

                                <a class='nav-item nav-link' id='nav-flagg-tab' data-toggle='tab' href='#nav-flagg". $row2["id"] ."' role='tab' aria-controls='nav-flagg' aria-selected='false'>Flaggningar ("; 

                                $antal_flaggningar = "SELECT * FROM `flaggadblogg` WHERE bloggId=". $row2["id"] ."";
                                
                                if($result_flaggningar=mysqli_query($conn,$antal_flaggningar)){
                                    $flaggningar = mysqli_num_rows($result_flaggningar);

                                    if($flaggningar > 0){
                                        echo "<font color='red'>";
                                        printf($flaggningar);
                                    } else {
                                        echo "<font color='green'>";
                                        printf($flaggningar);
                                    }
                                    
                                } else {
                                    echo "Kunde inte hämta data från databasen.";
                                }
                                
                                echo "</font>)</a>

                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='nav-information". $row2["id"] ."' role='tabpanel' aria-labelledby='nav-information-tab'>
                                    <div style='padding: 10px 10px 10px 10px;'>
                                        <p>Namn: <strong>". $row2["titel"] ."</strong></p>
                                        <p>BloggID: <strong>". $row2["id"] ."</strong></p>
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
                                        <div style='margin-right:5px;'>
                                            <form action='../Blogg/funktioner/visaBlogg.php' method='GET'>
                                                <input name='anvandarId' type='hidden' value='". $row["kontoID"] ."'>
                                                <input name='bloggId' type='hidden' value='". $row2["id"] ."'>
                                                <button type='submit' class='btn btn-info btn-sm'>Visa Blogg</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action='../Blogg/funktioner/tabort.php' method='POST' style='padding-right: 5px;'>
                                                <input type='hidden' name='funktion' value='tabortBlogg'/>
                                                <input name='bloggId' type='hidden' value='". $row2["id"] ."'>
                                                <button type='submit' class='btn btn-danger btn-sm'>Ta bort blogg</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class='tab-pane fade' id='nav-flagg". $row2["id"] ."' role='tabpanel' aria-labelledby='nav-flagg-tab'>
                                    <div class='row' style='padding: 10px 10px 10px 10px;'>

                                            <p>Bloggen är flaggad av:</p>

                                            <table class='table'>
                                                <thead>
                                                    <tr>
                                                    <th scope='col'>#</th>
                                                    <th scope='col'>Användarnamn</th>
                                                    <th scope='col'>E-post</th>
                                                    <th scope='col'>Roll</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";

                                                $flaggadblogg_anvandare = "SELECT * FROM flaggadblogg 
                                                INNER JOIN anvandare ON anvandare.id=flaggadblogg.anvandarId
                                                INNER JOIN anvandarroll ON flaggadblogg.anvandarId=anvandarroll.anvandarId
                                                INNER JOIN roll ON anvandarroll.rollId = roll.id WHERE flaggadblogg.bloggId = ". $row2["id"] ."
                                                ";
                                                $result_flaggadblogg_anvandare = $conn->query($flaggadblogg_anvandare);
                                                if ($result_flaggadblogg_anvandare->num_rows > 0) {
  
                                                    while($row_flaggadblogg_anvandare = $result_flaggadblogg_anvandare->fetch_assoc()) {
                                                        echo 
                                                        "
                                                        <tr>
                                                            <th scope='row'>". $row_flaggadblogg_anvandare["id"] ."</th>
                                                            <td>". $row_flaggadblogg_anvandare["anamn"] ."</td>
                                                            <td>". $row_flaggadblogg_anvandare["email"] ."</td>
                                                            <td>". $row_flaggadblogg_anvandare["rollNamn"] ."</td>
                                                        </tr>
                                                        ";
                                                    }
                                                echo "
                                                </tbody>
                                                </table>
                                                ";
                                                } else { 
                                                    echo 
                                                    "
                                                    </table>
                                                    <div class='alert alert-info alert-dismissible fade show center-block text-center' role='alert'>
                                                        <strong>Info:</strong> Inga användare har flaggat bloggen.
                                                    </div>
                                                    ";
                                                }

                                                    echo "

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
        <strong>INFO:</strong> Kunden har inga bloggar just nu.
    </div>
  ";
}

?>
