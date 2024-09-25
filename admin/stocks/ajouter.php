<?php
session_start();
include "../../include/functions.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idstock = intval($_POST['idstock']);
    $quantite = intval($_POST['quantite']);

    // Connect to the database
    $conn = connect();

    // Prepare and execute the query to get the current quantity
    $stmt = $conn->prepare("SELECT quantite FROM stocks WHERE id = ?");
    $stmt->execute([$idstock]);
    $currentStock = $stmt->fetchColumn();

    if ($currentStock !== false) {
        // Calculate the new quantity
        $newQuantite = $currentStock + $quantite;

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE stocks SET quantite = ? WHERE id = ?");
        $stmt->execute([$newQuantite, $idstock]);

        // Redirect with success message
        //header('Location: stocks.php');
        header("Location: liste.php?modif=ok");
        exit();
    } else {
        // Handle error: stock not found
        echo 'Stock not found.';
    }
} else {
    // Handle invalid request method
    echo 'Invalid request.';
}
?>