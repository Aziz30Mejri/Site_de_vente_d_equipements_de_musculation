<?php

session_start();
include "../include/functions.php";
$conn = connect();

//Id visiteur:
$visiteur = $_SESSION['id'];
$total = $_SESSION['panier'][1];
$date = date('Y-m-d');


//Creation de panier:
$requette_panier = "INSERT INTO panier(visiteur, total, date_creation) VALUES(:visiteur, :total, :date_creation)";
$stmt = $conn->prepare($requette_panier);
$stmt->bindParam(':visiteur', $visiteur, PDO::PARAM_INT);
$stmt->bindParam(':total', $total);
$stmt->bindParam(':date_creation', $date);
$stmt->execute();

$panier_id = $conn->lastInsertId(); 

$commandes = $_SESSION['panier'][3];

foreach ($commandes as $commande) {
    // Ajouter la commande
    $quantite = $commande[0];
    $total = $commande[1];
    $id_produit = $commande[4];
    $requete = "INSERT INTO commandes(quantite, total, panier, date_creation, date_modification, produit) VALUES(:quantite, :total, :panier, :date_creation, :date_modification, :id_produit)";

    $stmt = $conn->prepare($requete);
    $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':panier', $panier_id, PDO::PARAM_INT);
    $stmt->bindParam(':date_creation', $date);
    $stmt->bindParam(':date_modification', $date);
    $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
    $stmt->execute();
    
}

// Supprimer le panier
$_SESSION['panier'] = null;
header("location: ../index.php");

?>