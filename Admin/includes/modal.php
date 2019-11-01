<?php
include("../Databas/dbh.inc.php");

$modal_select = "SELECT customers.customers.id, customers.customers.namn, TheProvider.kundrattigheter.kontoID FROM customers.customers LEFT JOIN TheProvider.kundrattigheter ON customers.customers.id = TheProvider.kundrattigheter.id";
$modal_result = $conn->query($modal_select);

if ($modal_result->num_rows > 0) {
    while($modal_row = $modal_result->fetch_assoc()) {
        echo 
            "
            <!-- Delete Modal-->
            <div class='modal fade' id='deleteModal". $modal_row["id"] ."' tabindex='-1' role='dialog' aria-labelledby='DeleteLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                    <h5 class='modal-title' id='DeleteLabel'>Är du säker på att du vill avsluta kunden?</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                    </div>
                    <div class='modal-body'>Välj 'Ja' nedan om du är redo att avsluta kundens konto.</div>
                    <div class='modal-footer'>
                    <button type='submit' form='deleteform". $modal_row["id"] ."' class='btn btn-danger'>Ja</button>     
                    <button class='btn btn-secondary' type='button' data-dismiss='modal'>Avbryt</button>
                    </div>
                </div>
            </div>
            </div>
            ";
    }
}

?>