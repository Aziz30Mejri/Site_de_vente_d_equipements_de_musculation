<?php
session_start();
include "include/functions.php";
$categories = getAllCategories();
if (isset($_GET['id'])) {
    $produit = getProduitById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(getNomSociete()); ?> : Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @media (max-width: 576px) {
            .card-title {
                font-size: 1.5rem;
            }

            .card-text {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.6rem 1rem;
            }
        }
    </style>
</head>
<body>
  <?php include "include/header.php"; ?>
    <div class="container mt-4">
        <?php if (isset($_SESSION['etat']) && $_SESSION['etat'] == 0): ?>
            <div class="alert alert-danger">
                Compte non validé
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <img src="images/<?php echo htmlspecialchars($produit['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($produit['nom']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($produit['description']); ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?php echo htmlspecialchars($produit['prix']); ?> DT</li>
                <?php 
                if (isset($categories) && is_array($categories)) {
                    foreach ($categories as $c) {
                        if ($c['id'] == $produit['categorie']) {
                            echo '<li class="list-group-item"><p style="text-decoration: underline wavy #e31836;">' . htmlspecialchars($c['nom']) . '</p></li>';
                        }
                    }
                } else {
                    echo '<li class="list-group-item">Categories data is not available.</li>';
                }
                ?>
            </ul>
            <div class="card-body">
                <form action="actions/commander.php" method="POST" class="d-flex">
                    <input type="hidden" value="<?php echo htmlspecialchars($produit['id']); ?>" name="produit">
                    <input type="number" class="form-control me-2" name="quantite" step="1" placeholder="Quantité du produit ..." required>
                    <button type="submit" <?php if (isset($_SESSION['etat']) && $_SESSION['etat'] == 0 || !isset($_SESSION['etat'])){ echo "disabled";} ?> class="btn btn-primary">Commander</button>
                </form>
            </div>
        </div>
    </div>
  <?php include "include/footer.php"; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>