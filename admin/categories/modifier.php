<?php
session_start();
// Récupération et validation des données
$id = isset($_POST['idc']) ? trim($_POST['idc']) : '';
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$date_modification = date("Y-m-d");

// Vérification si les champs sont remplis
$errors = [];
if (empty($id)) {
    $errors[] = "L'identifiant ne peut pas être vide.";
}
if (empty($nom)) {
    $errors[] = "Le nom ne peut pas être vide.";
}
if (empty($description)) {
    $errors[] = "La description ne peut pas être vide.";
}

if (!empty($errors)) {
    die(implode('<br>', $errors));
}

include "../../include/functions.php";
$conn = connect();

// Préparation de la requête
$requette = $conn->prepare("UPDATE categories SET nom = :nom, description = :description, date_modification = :date_modification WHERE id = :id");

// Exécution de la requête
$resultat = $requette->execute([
    ':nom' => $nom,
    ':description' => $description,
    ':date_modification' => $date_modification,
    ':id' => $id
]);

// Vérification du résultat
if ($resultat) {
    header('Location: liste.php?modif=ok');
    exit(); // Assurez-vous d'appeler exit() après header pour arrêter l'exécution du script
} else {
    die("Erreur lors de la modification des données.");
}
?>
