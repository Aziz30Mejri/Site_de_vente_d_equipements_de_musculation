<?php
session_start();
include "include/functions.php";

// Vérifier si un identifiant de catégorie est passé en paramètre
if (isset($_GET['categorie_id']) && filter_var($_GET['categorie_id'], FILTER_VALIDATE_INT)) {
    $categorieId = intval($_GET['categorie_id']);
    $categorie = getCategorieById($categorieId);
    if ($categorie) {
        $produits = getProduitsByCategorie($categorieId);
        $categorieNom = htmlspecialchars($categorie['nom']);
        // Affichage des produits et catégorie (à compléter selon vos besoins)
    } else {
        // Rediriger si l'identifiant de catégorie n'est pas valide
        header("Location: index.php");
        exit();
    }
} else {
    // Rediriger si l'identifiant de catégorie n'est pas spécifié ou invalide
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($categorie['nom']); ?> - <?php echo htmlspecialchars(getNomSociete()); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
     @media (max-width: 768px) {
      .card-text {
        font-size: 0.9rem;
      }
    }
    @media (max-width: 576px) {
      .card-title {
        font-size: 1.2rem;
      }
      .card-text {
        font-size: 0.8rem;
      }
      .social-buttons a {
        width: 60px;
        height: 35px;
        font-size: 0.8rem;
        padding: 8px;
      }
      .social-buttons svg {
        width: 20px;
        height: 20px;
      }
    }
    .social-buttons {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
        }
        .social-buttons a {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1px;
            margin-right: -20px;
            padding: 10px;
            padding-right: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            transition: transform 0.3s, border-color 0.3s;
            width: 70px;
            height: 40px;
        }
        .social-buttons a:hover {
            transform: translateX(-10px);
        }
        .social-buttons svg {
            fill: #000;
            transition: fill 0.3s, transform 0.3s ease;
        }
        .fb svg path {
            fill: blue;
        }
        .insta svg path {
            fill: #E4405F;
        }
        .email svg path {
            fill: #D44638;
        }
        .whatsapp svg path {
            fill: #25D366;
        }
        .social-buttons a:hover svg {
            transform: scale(1.1);
        }
        .card-img-top {
            width: 100%;
            height: 300px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card-img-top:hover {
          transform: scale(1.05);
          box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
          z-index: 1;
          cursor: pointer;
        }
        .card {
        box-shadow: 1px 1px 10px #111;
        }
        input[type="number"] {
        width: 100px;
        height: 39px;
        border-radius: 4px; /* Coins arrondis pour les champs de saisie */
        border: 1px solid #ced4da; /* Bordure douce pour le champ de saisie */
        padding: 0.5rem; /* Espacement intérieur pour le texte */
        font-size: 0.875rem; /* Taille de police légèrement plus petite */
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); /* Ombre intérieure pour un effet de profondeur */
        }
        .disabled-button {
        cursor: not-allowed;
        opacity: 0.5;
        }
        .btncommande {
          position: relative;
          overflow: hidden;
          outline: none;
          cursor: pointer;
          border-radius: 50px;
          background-color: black;
          font-family: inherit;
          padding: 0;
          width: 9.5rem;
          height: 2.2rem;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .default-btncommande, .hover-btncommande {
          background-color: black;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 5px;
          padding: 15px 20px;
          border-radius: 50px;
          font-size: 17px;
          font-weight: 500;
          text-transform: uppercase;
          transition: all .3s ease;
        }
        .hover-btncommande {
          position: absolute;
          inset: 0;
          background-color: black;
          transform: translate(0%, 100%);
        }
        .default-btncommande span {
          color: hsl(0, 0%, 100%);
          font-size: 15px;
        }
        .hover-btncommande span {
          color: white;
          font-size: 13px;
        }
        .btncommande:hover .default-btncommande{
          transform: translate(0%, -100%);
        }
        .btncommande:hover .hover-btncommande{
          transform: translate(0%, 0%);
        }
        .btncommande2 {
          position: relative;
          overflow: hidden;
          outline: none;
          cursor: pointer;
          border-radius: 50px;
          background-color: black;
          font-family: inherit;
          padding: 0;
          width: 13.5rem;
          height: 2.2rem;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .default-btncommande2, .hover-btncommande2 {
            background-color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 15px 20px;
            border-radius: 50px;
            font-size: 17px;
            font-weight: 500;
            text-transform: uppercase;
            transition: all .3s ease;
        }
        .hover-btncommande2 {
            position: absolute;
            inset: 0;
            background-color: black;
            transform: translateY(100%);
        }
        .default-btncommande2 span {
            color: hsl(0, 0%, 100%);
            font-size: 15px;
        }
        .hover-btncommande2 span {
            color: white;
            font-size: 13px;
        }
        .btncommande2:hover .default-btncommande2 {
            transform: translateY(-100%);
        }
        .btncommande2:hover .hover-btncommande2 {
            transform: translateY(0%);
        }
        .card-text1 {
            display: -webkit-box; /* Nécessaire pour utiliser -webkit-line-clamp */
            -webkit-box-orient: vertical; /* Définit l'orientation de la boîte */
            -webkit-line-clamp: 3; /* Limite à 3 lignes */
            overflow: hidden; /* Masque le texte qui dépasse */
            text-overflow: ellipsis; /* Ajoute "..." si le texte est trop long */
        }
  </style>
</head>
<body>
    <?php include "include/header.php"; ?>
    <div class="container mt-4">
        <h1><?php echo ucwords($categorieNom); ?> :</h1>
        <div class="row">
            <?php if (!empty($produits)): ?>
                <?php foreach($produits as $produit): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3 mb-3">
                        <div class="card h-100">
                            <img src="images/<?php echo htmlspecialchars($produit['image']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($produit['nom']); ?>" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $produit['id']; ?>">
                            <div class="card-body">
                                <h5 class="card-title" style="color:#0b5ed7; font-weight: bold;"><?php echo htmlspecialchars(ucwords($produit['nom'])); ?></h5>
                                <p class="card-text1" style="font-size: 15px; font-weight: 600;"><?php echo htmlspecialchars(ucfirst(strtolower($produit['description']))); ?></p>
                                <p class="card-text">
                                    Catégorie : 
                                    <?php 
                                    if (isset($categories) && is_array($categories)) {
                                        foreach ($categories as $c) {
                                            if ($c['id'] == $produit['categorie']) {
                                                echo '<span style="text-decoration: underline;">' . htmlspecialchars($c['nom']) . '</span>';
                                            }
                                        }
                                    } else {
                                        echo 'Les données des catégories ne sont pas disponibles.';
                                    }
                                    ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center" style="margin-right: 8px; margin-left: 15px;">
                                    <p class="card-text" style="color: red; font-weight: bold; margin-top: 10px;"><?php echo $produit['prix']; ?> DT</p>
                                    <button class ="btncommande" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $produit['id']; ?>">
                                    <div class="default-btncommande">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"viewBox="0 0 16 16">
                                        <path fill="#ffffff" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path fill="#ffffff" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                        </svg>
                                        <span>Aperçu</span>
                                    </div>
                                    <div class="hover-btncommande">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                        <path fill="#ffffff" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                        </svg>
                                        <span>Commander</span>
                                    </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun produit trouvé dans cette catégorie.</p>
            <?php endif; ?>
        </div>
        <!-- Modals for displaying images -->
        <?php foreach ($produits as $produit): ?>
            <div class="modal fade" id="imageModal<?php echo $produit['id']; ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo $produit['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h5 class="modal-title" style="font-weight: bold;" id="imageModalLabel<?php echo $produit['id']; ?>"><?php echo htmlspecialchars($produit['nom']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="images/<?php echo htmlspecialchars($produit['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                        </div>
                        <div class="container">
                            <?php if (isset($_SESSION['etat']) && $_SESSION['etat'] == 0): ?>
                                <div class="alert alert-danger">
                                    Compte non validé
                                </div>
                            <?php endif; ?>
                            <div class="card1 mb-4">
                                <div class="card-body">
                                    <p class="card-text" style="margin-left: 1rem; font-weight: 600;"><?php echo htmlspecialchars($produit['description']); ?></p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><?php echo htmlspecialchars($produit['prix']); ?> DT</li>
                                    <?php 
                                    if (isset($categories) && is_array($categories)) {
                                        foreach ($categories as $c) {
                                            if ($c['id'] == $produit['categorie']) {
                                                echo '<li class="list-group-item"><p>Catégorie : <span style="text-decoration: underline;">' . htmlspecialchars($c['nom']) . '</span></p></li>';
                                            }
                                        }
                                    } else {
                                        echo '<li class="list-group-item">Les données des catégories ne sont pas disponibles.</li>';
                                    }
                                    ?>
                                </ul>
                                <div class="card-body">
                                    <form action="actions/commander.php" method="POST" class="d-flex justify-content-center" style="gap: 1rem;">
                                        <input type="hidden" value="<?php echo htmlspecialchars($produit['id']); ?>" name="produit">
                                        <input type="number" class="form-control me-2" name="quantite" step="1" placeholder="Quantité ...." required>
                                        <button type="submit" id="add-to-cart-btn" 
                                        <?php if (isset($_SESSION['etat']) && $_SESSION['etat'] == 0) { echo 'disabled'; } ?>
                                        class="btncommande2 <?php if (isset($_SESSION['etat']) && $_SESSION['etat'] == 0) { echo 'disabled-button'; } ?>">
                                        <div class="default-btncommande2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                                <path fill="#ffffff" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                            <span>Ajouter au Panier</span>
                                        </div>
                                        <div class="hover-btncommande2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                                            <path fill="#ffffff" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                        </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include "include/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('add-to-cart-btn');
            if (btn && btn.disabled) {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Attention',
                        text: 'Vous devez être connecté pour ajouter des articles au panier.',
                    });
                });
            }
        });
    </script>
</body>
</html>