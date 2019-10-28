<?php
include("dbh.inc.php");

if(isset($_GET['id']) || isset($_GET['namn']) || isset($_GET['anamn'])){

    $kundid = $_GET['id'];
    $namn = $_GET['namn'];
    $anamn = $_GET['anamn'];

    if(empty($_GET['id'])){
        $where = "customers.customers.id = $kundid";
    }
    if(empty($_GET['namn'])){
        $where = "customers.customers.namn = $namn";
    }
    if(empty($_GET['anamn'])){
        $where = "test";
    }

    

    $sql = "SELECT customers.customers.id, customers.customers.namn, the_provider.kundrattigheter.kontoID 
            FROM customers.customers LEFT JOIN the_provider.kundrattigheter ON customers.customers.id = the_provider.kundrattigheter.id 
            WHERE $where ORDER BY customers.customers.id ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Kund #". $row["id"] ." - ". $row["namn"] ."";
        }
    } else {
        echo "Inget resultat.";
    }

} else {
    header("location: ../index.php?funktion=search?status=failed");
}

?>