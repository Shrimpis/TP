<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if (strpos($url,'userLogin=Success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <h4 class='alert-heading'>Välkommen!</h4>
            <p>Du har nu loggats in till <strong>The Providers</strong> kontrollpanel v1.5.</p>
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
            Tjänsten eller tjänsterna har nu ändrats för kunden.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
      ";
    }
    if (strpos($url,'funktion=skapaKonto?status=success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Kontot har nu skapats.
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