<?php

// Redigera funktioner //


switch ($_GET['f']) {
    case 'redigeraBlogg':
        redigeraBlogg();
        break;
    case 'redigeraKommentar';
        redigeraKommentar();
        break;
    case 'redigeraTextruta';
        redigeraTextruta();
        break;
    default:
        echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
}

function redigeraBlogg(){

}

function redigeraKommentar(){
    
}

function redigeraTextruta(){
    
}

?>