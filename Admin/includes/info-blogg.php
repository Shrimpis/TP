<?php 

echo 
"
<div id='accordion2'>
    <div class='card'>
    
        <div class='card-header' id='headingOne'>
        <h5 class='mb-0'>
            <button class='btn btn-link' data-toggle='collapse' data-target='#collapseBlogg' aria-expanded='true' aria-controls='collapseBlogg'>
            Blogg #1
            </button>
        </h5>
        </div>

        <div id='collapseBlogg' class='collapse' aria-labelledby='headingOne' data-parent='#accordion2'>
            <div class='card-body'>
                <nav>
                    <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                    <a class='nav-item nav-link active' id='nav-information-tab' data-toggle='tab' href='#nav-information' role='tab' aria-controls='nav-information' aria-selected='true'>Information</a>
                    <a class='nav-item nav-link' id='nav-installnigar-tab' data-toggle='tab' href='#nav-installnigar' role='tab' aria-controls='nav-installnigar' aria-selected='false'>Inställningar</a>
                    <a class='nav-item nav-link' id='nav-flagg-tab' data-toggle='tab' href='#nav-flagg' role='tab' aria-controls='nav-flagg' aria-selected='false'>Flagg</a>
                    </div>
                </nav>
                <div class='tab-content' id='nav-tabContent'>
                    <div class='tab-pane fade show active' id='nav-information' role='tabpanel' aria-labelledby='nav-information-tab'>
                        <div style='padding: 10px 10px 10px 10px;'>
                            <p>Namn: <strong>Test blogg</strong></p>
                            <p>Privat: <strong>Nej</strong></p>
                            <p>Inlägg: <strong>2</strong></p>
                            <p>Kommentarer: <strong>3</strong></p>
                        </div>
                    </div>

                    <div class='tab-pane fade' id='nav-installnigar' role='tabpanel' aria-labelledby='nav-installnigar-tab'>
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

                    <div class='tab-pane fade' id='nav-flagg' role='tabpanel' aria-labelledby='nav-flagg-tab'>
                        <div class='row' style='padding: 10px 10px 10px 10px;'>
                            <p>Antal flaggningar: <strong><font color='red'>5</font></strong></p>

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

?>