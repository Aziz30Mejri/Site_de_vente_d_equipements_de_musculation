<?php
session_start();

//Test user connecter
if (!isset($_SESSION['nom'])) { // User non connectée
header('location:../connexion.php');
exit();
}

include "../include/functions.php";
$conn = connect();

$visiteur = $_SESSION['id'];

$id_produit = $_POST['produit'];
$quantite = $_POST['quantite'];

// Sélectionner le prix du produit avec son ID
$requete = "SELECT prix, nom FROM produits WHERE id = :id_produit";
$stmt = $conn->prepare($requete);
$stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt->execute();
$produit = $stmt->fetch();

// Calculer le total
$total = $quantite * $produit['prix'];
$date = date("Y-m-d");

if (!isset($_SESSION['panier'])) { //panier n'existe pas
    $_SESSION['panier'] = array($visiteur, 0, $date, array() ); //creation du panier
}
$_SESSION['panier'][1] += $total; 
$_SESSION['panier'][3][] = array($quantite, $total, $date, $date, $id_produit, $produit['nom']);

header('location:../panier.php');

?>