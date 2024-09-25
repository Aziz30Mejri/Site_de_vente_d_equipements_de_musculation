<?php
session_start();
// Récupération et validation des données
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$createur = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$date_creation = date("Y-m-d");
// Vérification si les champs sont remplis
if (empty($nom) || empty($description)) {
    die("Le nom et la description ne peuvent pas être vides.");
}
include "../../include/functions.php";
$conn = connect();
// Préparation et exécution de la requête
$requette = $conn->prepare("INSERT INTO categories(nom, description, createur, date_creation) VALUES(:nom, :description, :createur, :date_creation)");
$resultat = $requette->execute([
    ':nom' => $nom,
    ':description' => $description,
    ':createur' => $createur,
    ':date_creation' => $date_creation
]);
// Vérification du résultat
if ($resultat) {
    header('location:liste.php?ajout=ok');
} else {
    die("Erreur lors de l'insertion des données.");
}
?>