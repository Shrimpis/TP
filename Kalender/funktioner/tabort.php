<?php

// Funktioner för att ta bort

session_start();

include('../../Databas/dbh.inc.php');
        switch ($_POST['funktion']) {

            case '':
                ();
                break;

            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();
