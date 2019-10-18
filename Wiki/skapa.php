<?php

session_start();
include("dbh.inc.php");

switch($_POST['funktion']){

    case 'skapaWiki':
        skapaWiki();
        break;
    case 'skapaWikiSida':
        skapaWikiSida();
        break;
    case 'skapaWikiUppdatering':
        skapaWikiUppdatering();
        break;
    default:
        echo 'ERROR: Något gick fel med parametrarna i eran begäran.';

}

function skapaWikiUppdatering(){



}


