<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if (strpos($url,'userLogin=Success') == true) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Du har nu loggats in korrekt.
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
?>