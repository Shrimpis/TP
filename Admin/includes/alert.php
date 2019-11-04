<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if (strpos($url,'userLogin=Success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <h4 class='alert-heading'>Välkommen!</h4>
            <p>Du har nu loggats in till <strong>The Providers</strong> kontrollpanel v2.0.</p>
            <p>Här finns flera funktioner för att administrera kundtjänster.</p>
            <hr>
            <p class='mb-0'>Har du några funderingar så kan du alltid vända dig till <a href='https://github.com/Shrimpis/TP/wiki' target='_blank'>dokumentation</a>.</p>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=avslutaKonto?status=success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Kontot har nu avslutats.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'userLogin=Error?reason=NotAdmin') == true) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Du har inte rättigheter för att kunna logga in.
        </div>
      ";
    }
    if (strpos($url,'funktion=search?status=failed') == true) {
        echo "
        <div class='alert alert-info alert-dismissible fade show' role='alert'>
            <strong>Info:</strong> Sökfälten är tomma. Vänligen välj en sökterm vid nästa sökning.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=aktiveraKonto?status=success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Kontot har nu aktiverats.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=deaktiveraKonto?status=success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Kontot har nu deaktiverats.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=aktiveraTjanst?m=success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Tjänsterna har nu ändrats för kunden.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=skapaKonto?status=success') == true) {
        $id = $_GET['id'];
        $username = $_GET['username'];
        $password = $_GET['password'];

        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <h4 class='alert-heading'>Kontot har nu skapats för kund #".$id."</h4>
            <hr>
            <p>Användarnamn: <strong>".$username."</strong></p>
            <p>Lösenord: <strong>".$password."</strong></p>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=skapaKonto?status=error?reason=usernameTaken') == true) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>ERROR:</strong> Användarnamnet är redan taget.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
?>