<?php
    session_start();
    if (!isset($_SESSION['nom'])) {
        header('location:connexion.php');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    h1, h2 {
        margin-bottom: 20px;
    }
    @media (max-width: 576px) {
        h1 {
            font-size: 1.5rem;
        }
        
        h2 {
            font-size: 1rem;
        }
    }
</style>
</head>
<body>
<?php include"include/header.php";?>
<div class="container mt-5" style="margin-bottom: 14.2rem;">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <h1>Bienvenu <span class="text-primary"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom']; ?></span></h1>
            <p>Ceci est votre page de profil. </p>
            <h2>Email: <?php echo $_SESSION['email']; ?></h2>
        </div>
    </div>
</div>
    <?php include "include/footer.php"; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>