                <div id="accordion">
                  <div class="card">
                    <div class="card-header" id="headingOne">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#Kund1" aria-expanded="true" aria-controls="collapseOne">
                          Kund #1
                        </button>
                      </h5>
                    </div>
                    <div id="Kund1" class="collapse" aria-labelledby="Kund1" data-parent="#accordion">
                      <div class="card-body">
                      <p>Tjänster:</p>
                        <form>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="CheckBlogg">
                            <label class="form-check-label" for="CheckBlogg">Blogg</label>
                            <br>
                            <input type="checkbox" class="form-check-input" id="CheckWiki">
                            <label class="form-check-label" for="CheckWiki">Wiki</label>
                            <br>
                            <input type="checkbox" class="form-check-input" id="CheckKalender">
                            <label class="form-check-label" for="CheckKalender">Kalender</label>
                          </div>
                          <button type="submit" class="btn btn-primary btn-sm" style="margin-top:4px;margin-bottom:30px;">Spara</button>
                        </form>
                        
                        <p>Skapa konto för Superadmin:</p>
                        
                        <form action="funktioner/skapa.php" method="POST">
                        <input type='hidden' name='funktion' value='skapaKonto'/>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                              </div>
                              <input type="text" class="form-control" placeholder="Användarnamn" aria-label="Användarnamn" name="anamn" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                              </div>
                              <input type="text" class="form-control" placeholder="Lösenord" aria-label="Lösenord" name="losenord" aria-describedby="basic-addon1">
                            </div>
                          <button type="submit" class="btn btn-primary btn-sm" style="margin-top:4px;margin-bottom:10px;">Skapa konto</button>
                        </form>

                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingTwo">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#Kund2" aria-expanded="false" aria-controls="collapseTwo">
                          Kund #2
                        </button>
                      </h5>
                    </div>
                    <div id="Kund2" class="collapse" aria-labelledby="Kund2" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingThree">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#Kund3" aria-expanded="false" aria-controls="collapseThree">
                          Kund #3
                        </button>
                      </h5>
                    </div>
                    <div id="Kund3" class="collapse" aria-labelledby="Kund3" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                </div>