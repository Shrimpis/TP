<div class="col-xl-4 col-lg-5">



              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ta bort Blogg</h6>
                </div>
                <div style="padding: 10px 10px 10px 10px;">
                <p>Välj blogg:</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="border: 0px solid #d1d3e2 !important;" for="inputGroupSelect01"><i class="fab fa-blogger-b"></i></label>
                        </div>
                    <form action="../api.php" method="POST">
                        <input type='hidden' name='nyckel' value='JIOAJWWNPA259FB2'/>
                        <input type='hidden' name='tjanst' value='blogg'/>
                        <input type='hidden' name='typ' value='function'/>
                        <input type='hidden' name='handling' value='tabort'/>
                        <input type='hidden' name='funktion' value='tabortBlogg'/>

                        <select class="selectpicker show-tick" data-live-search="true" id="inputGroupSelect01" name="bloggId" id="bloggId">
                            <option selected>Välj...</option>
                            <?php 
                                include("../Databas/dbh.inc.php");
                                $sql = "SELECT blogg.id, blogg.tjanstId, tjanst.titel FROM blogg INNER JOIN tjanst ON blogg.tjanstId = tjanst.id";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='". $row["id"] ."'>TjänstID: ". $row["tjanstId"]." | ". $row["titel"]."</option>";
                                }
                                echo "</table>";
                                } else { echo "0 results"; }
                                $conn->close();
                            ?>
                        </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:4px;margin-bottom:30px;">Ta bort Blogg</button>
                    </form>
                  </div>
                </div>



                <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ta bort Wiki</h6>
                </div>
                <div style="padding: 10px 10px 10px 10px;">
                <p>Välj wiki:</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="border: 0px solid #d1d3e2 !important;" for="inputGroupSelect01"><i class="fab fa-wikipedia-w"></i></label>
                        </div>
                    <form action="../api.php" method="POST">
                        <input type='hidden' name='nyckel' value='JIOAJWWNPA259FB2'/>
                        <input type='hidden' name='tjanst' value='wiki'/>
                        <input type='hidden' name='typ' value='function'/>
                        <input type='hidden' name='handling' value='tabort'/>
                        <input type='hidden' name='funktion' value='tabortWiki'/>

                        <select class="selectpicker show-tick" data-live-search="true" id="inputGroupSelect01" name="wikiId" id="wikiId">
                            <option selected>Välj...</option>
                            <?php 
                                include("../Databas/dbh.inc.php");
                                $sql = "SELECT wiki.id, wiki.tjanstId, tjanst.titel FROM wiki INNER JOIN tjanst ON wiki.tjanstId = tjanst.id";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                while($row_wiki = $result->fetch_assoc()) {
                                    echo "<option value='". $row_wiki["id"] ."'>TjänstID: ". $row_wiki["tjanstId"]." | ". $row_wiki["titel"]."</option>";
                                }
                                echo "</table>";
                                } else { echo "0 results"; }
                                $conn->close();
                            ?>
                        </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:4px;margin-bottom:30px;">Ta bort Wiki</button>
                    </form>
                  </div>
                </div>



                <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ta bort Kalender</h6>
                </div>
                <div style="padding: 10px 10px 10px 10px;">
                <p>Välj kalender:</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" style="border: 0px solid #d1d3e2 !important;" for="inputGroupSelect01"><i class="fas fa-calendar-week"></i></label>
                        </div>
                    <form action="../api.php" method="POST">
                        <input type='hidden' name='nyckel' value='JIOAJWWNPA259FB2'/>
                        <input type='hidden' name='tjanst' value='kalender'/>
                        <input type='hidden' name='typ' value='function'/>
                        <input type='hidden' name='handling' value='tabort'/>
                        <input type='hidden' name='funktion' value='tabortKalender'/>

                        <select class="selectpicker show-tick" data-live-search="true" id="inputGroupSelect01" name="tjanstId" id="tjanstId">
                            <option selected>Välj...</option>
                            <?php 
                                include("../Databas/dbh.inc.php");
                                $sql = "SELECT kalender.id, kalender.tjanstId, tjanst.titel FROM kalender INNER JOIN tjanst ON kalender.tjanstId = tjanst.id";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                while($row_kalender = $result->fetch_assoc()) {
                                    echo "<option value='". $row_kalender["id"] ."'>TjänstID: ". $row_kalender["tjanstId"]." | ". $row_kalender["titel"]."</option>";
                                }
                                echo "</table>";
                                } else { echo "0 results"; }
                                $conn->close();
                            ?>
                        </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:4px;margin-bottom:30px;">Ta bort Kalender</button>
                    </form>
                  </div>
                </div>



                <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ta bort superadmin</h6>
                </div>
                <div style="padding: 10px 10px 10px 10px;">
                    <form action="funktioner/tabort.php" method="POST">
                    <input type='hidden' name='funktion' value='tabortKonto'/>
                        <p>Välj superadmin:</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" style="border: 0px solid #d1d3e2 !important;" for="inputGroupSelect01"><i class="fas fa-user"></i></label>
                            </div>
                            <select class="selectpicker show-tick" data-live-search="true" id="inputGroupSelect01" name="anvandarid" id="anvandarid">
                                <option selected>Välj...</option>
                                <?php 
                                    include("../Databas/dbh.inc.php");
                                    $sql = "SELECT anvandare.id, anvandare.anamn FROM anvandare INNER JOIN anvandarroll ON anvandare.id = anvandarroll.anvandarId WHERE anvandarroll.rollId = 1 AND anvandare.id <> 1";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='". $row["anvandare.id"] ."'>AnvändarID: ". $row["id"]." | ". $row["anamn"]."</option>";
                                    }
                                    echo "</table>";
                                    } else { echo "0 results"; }
                                    $conn->close();
                                ?>
                            </select>
                            </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:4px;margin-bottom:30px;">Ta bort superadmin</button>
                    </form>
                  </div>
                </div>
              </div>
              </div>
            </div>
