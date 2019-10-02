<?php

echo'<form action="test.php">
    <input type="hidden" name="send">
</form>';

$send=$_GET['send'];
if($send=="lista_användare"){
    listaAnvändare();
}

function listaAnvändare(){
    echo 'niles ahmad my mom tha nigga black man';
}

?>