<?php

session_start();

// Récupération et validation des données
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$prix = isset($_POST['prix']) ? trim($_POST['prix']) : '';
$createur = isset($_POST['createur']) ? trim($_POST['createur']) : '';
$categorie = isset($_POST['categorie']) ? trim($_POST['categorie']) : '';

// Validation du prix
if (!is_numeric($prix) || $prix <= 0) {
    die("Le prix doit être un nombre positif.");
}

// Connexion à la base de données
include "../../include/functions.php";
$conn = connect();

// Récupération de l'image actuelle
$stmt = $conn->prepare("SELECT image FROM produits WHERE id = :id");
$stmt->execute([':id' => $id]);
$currentImage = $stmt->fetchColumn();

// Gestion de l'image
$image = $currentImage;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadFileDir = '../../images/';
        $dest_file_path = $uploadFileDir . $fileName;
        
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }
        
        if (move_uploaded_file($fileTmpPath, $dest_file_path)) {
            $image = $fileName;
        } else {
            die("Erreur lors de l'envoi du fichier.");
        }
    } else {
        die("Extension de fichier non autorisée.");
    }
}

// Préparation et exécution de la requête de mise à jour
$date_modification = date("Y-m-d");
$requette = $conn->prepare("UPDATE produits SET nom = :nom, description = :description, prix = :prix, image = :image, createur = :createur, categorie = :categorie, date_modification = :date_modification WHERE id = :id");
$resultat = $requette->execute([
    ':nom' => $nom,
    ':description' => $description,
    ':prix' => $prix,
    ':image' => $image,
    ':createur' => $createur,
    ':categorie' => $categorie,
    ':date_modification' => $date_modification,
    ':id' => $id
]);

// Vérification du résultat
if ($resultat) {
    header('Location: liste.php?modif=ok');
    exit();
} else {
    die("Erreur lors de la mise à jour des données.");
}

?>
