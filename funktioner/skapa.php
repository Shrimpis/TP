<?php

    function skapaBlogg(){

        include("dbh.inc.php");

        $usrid = $_POST['UID'];
        $title = $_POST['Titel'];
        $skapaBlogg = "INSERT INTO blogg(title,UID) VALUES('{$title}',$usrid)";
        $conn->query($skapaBlogg);
        $conn->close();

        if(mysqli_query($conn, $skapaBlogg)){
            echo "INFO: Bloggen har skapats.";
            header('Refresh: 2; URL = ../index.php');
        } else {
            echo "ERROR: Could not execute $skapaBlogg. " . mysqli_error($conn);
        }

    }

    function skapaInlagg(){



    }

    function skapaTextRuta(){



    }

    function skapaBildRuta(){



    }

    function skapaKommentar(){

        include('dbh.inc.php');
        $UID = mysqli_real_escape_string($conn, $_POST['UID']); //Användar-ID
        $IID = mysqli_real_escape_string($conn, $_POST['IID']); //Blogginlägg-ID
        $text = mysqli_real_escape_string($conn, $_POST['text']); //Kommentar text
        $hierarchyID = mysqli_real_escape_string($conn, $_POST['hierarchyID']);

        $skapaKommentar = "INSERT INTO kommentar (UID, IID, text, hierarchyID) VALUES ('$UID', '$IID', '{$text}', '$hierarchyID')";
        if(mysqli_query($conn, $skapaKommentar)){
            echo "INFO: Kommentar skapad.";
        } else{
            echo "ERROR: Could not able to execute $skapaKommentar. " . mysqli_error($conn);
        }
        $conn->close();

        if(mysqli_query($conn, $skapaKommentar)){
            echo "INFO: Kommentaren har skapats.";
            header('Refresh: 2; URL = ../index.php');
        } else {
            echo "ERROR: Could not execute $skapaKommentar. " . mysqli_error($conn);
        }

    }

    function sattaOrdning(){



    }

    function gillaInlagg(){

        include('dbh.inc.php');
        $UID = mysqli_real_escape_string($conn, $_POST['UID']); //Användar-ID
        $IID = mysqli_real_escape_string($conn, $_POST['IID']); //Blogginlägg-ID

        $redan_gillat = mysqli_query($conn, "SELECT UID, IID FROM gillningar WHERE UID='$UID' AND IID='$IID'");

        if($redan_gillat->num_rows == 0){
            $like = "INSERT INTO gillningar (UID, IID) VALUES ('$UID', '{$IID}')";
            if(mysqli_query($conn, $like)){
                echo "INFO: Inlägg med id " .$IID. " gillat av användar med id " .$UID. ".";
            } else{
                echo "ERROR: Could not able to execute $like. " . mysqli_error($conn);
            }
        } else {
            $dislike = "DELETE FROM gillningar WHERE UID='$UID' AND IID='$IID'";
            if(mysqli_query($conn, $dislike)){
                echo "ERROR: Användaren har redan gillat. Tar bort gillning.";
            } else{
                echo "ERROR: Could not able to execute $dislike. " . mysqli_error($conn);
            }
        }

        header("location: ../index.php");
        $conn->close();

    }
