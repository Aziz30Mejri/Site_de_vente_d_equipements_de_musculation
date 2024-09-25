<?php
// Ensure you have included necessary files for database connection
include "../../include/functions.php";

// Retrieve the stock ID and quantity to add from the POST request
$idStock = $_POST['idstock'];
$quantiteToAdd = intval($_POST['quantite']);

// Fetch the current quantity from the database
$currentStock = getStockById($idStock);
$currentQuantity = $currentStock['quantite'];

// Calculate the new quantity
$newQuantity = $currentQuantity + $quantiteToAdd;

// Update the stock quantity in the database
updateStockQuantity($idStock, $newQuantity);

// Redirect back to the stocks list page with a success message
header("Location: liste.php?modif=ok");
exit();
?>