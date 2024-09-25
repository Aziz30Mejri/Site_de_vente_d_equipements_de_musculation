<?php
session_start();
// Récupération et validation des données
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$prix = isset($_POST['prix']) ? trim($_POST['prix']) : '';
$createur = isset($_POST['createur']) ? trim($_POST['createur']) : '';
$categorie = isset($_POST['categorie']) ? trim($_POST['categorie']) : '';
$quantite = isset($_POST['quantite']) ? trim($_POST['quantite']) : '';

// Validation du prix
if (!is_numeric($prix) || $prix <= 0) {
    die("Le prix doit être un nombre positif.");
}

// Validation et traitement de l'image
$image = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../../images/";
    $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($file_ext, $allowed_extensions)) {
        // Générer un nom unique pour le fichier
        $image = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $image;
        
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            die("Désolé, une erreur est survenue lors du téléchargement de votre fichier.");
        }
    } else {
        die("Type de fichier non autorisé. Seuls les fichiers jpg, jpeg, png, et gif sont acceptés.");
    }
}

$date = date("Y-m-d");
include "../../include/functions.php";
$conn = connect();

// Préparation et exécution de la requête
$requette = $conn->prepare("INSERT INTO produits(nom, description, prix, image, createur, categorie, date_creation) VALUES(:nom, :description, :prix, :image, :createur, :categorie, :date)");
$resultat = $requette->execute([
    ':nom' => $nom,
    ':description' => $description,
    ':prix' => $prix,
    ':image' => $image,
    ':createur' => $createur,
    ':categorie' => $categorie,
    ':date' => $date
]);

// Vérification du résultat de l'insertion du produit
if ($resultat) {
    $produit_id = $conn->lastInsertId();
    
    // Préparation et exécution de la requête pour ajouter le stock
    $requette2 = $conn->prepare("INSERT INTO stocks(produit, quantite, createur, date_creation) VALUES(:produit_id, :quantite, :createur, :date_creation)");
    $resultat2 = $requette2->execute([
        ':produit_id' => $produit_id,
        ':quantite' => $quantite,
        ':createur' => $createur,
        ':date_creation' => $date
    ]);

    // Vérification du résultat de l'insertion du stock
    if ($resultat2) {
        header('location:liste.php?ajout=ok');
        exit();
    } else {
        echo "Impossible d'ajouter le stock de produit.";
    }
} else {
    echo "Impossible d'ajouter le produit.";
}
?>