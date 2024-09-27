<?php
  session_start();
  include "include/functions.php";
  $categories = getAllCategories();
  $data = getData();

  if (isset($_GET['id'])) {
    $produit = getProduitById($_GET['id']);
  }

  if (!empty($_POST)) {
    $produits = searchProduits($_POST['search']);
  }else{
    $produits = getAllProduits();
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars(getNomSociete()); ?></title>
  <link rel="shortcut icon" href="images/logo_site.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.css" integrity="sha512-Gebe6n4xsNr0dWAiRsMbjWOYe1PPVar2zBKIyeUQKPeafXZ61sjU2XCW66JxIPbDdEH3oQspEoWX8PQRhaKyBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        .modal-dialog {
          margin-top: 0;
          top: 0;
          transform: translateY(0);
        }
        .custom-select {
          background-color: #2488E6;
          color: white;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombre */
        }
        .custom-select:focus {
            outline: none; /* Supprimer l'effet de contour par défaut */
            box-shadow: 0 0 0 2px rgba(0, 136, 255, 0.5); /* Ombre au focus */
        }
        .custom-select option {
          background-color: white; /* Fond blanc pour les options */
          color: black; /* Couleur du texte des options */
        }
        .custom-select option {
          background-color: white; /* Fond blanc pour les options */
          color: black; /* Couleur du texte des options */
        }
  </style>
</head>
<body>
  <?php include "include/header.php";?>
  <div class="container mt-4">
    <div class="row">
      <div class="millieu" style="margin: 0 auto; text-align: center;">
      Il y a <?php echo $data['produits']; ?> produits.
      </div>
      <div class="col-12 text-end">
        <label for="sortPrix" class="form-label">Trier par:</label>
        <select id="sortPrix" class="custom-select">
          <option value="random">Aléatoire</option>
          <option value="name_asc">Nom, A à Z</option>
          <option value="name_desc">Nom, Z à A</option>
          <option value="asc">Prix croissant</option>
          <option value="desc">Prix décroissant</option>
        </select>
      </div>
      <?php foreach($produits as $produit): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-3 mb-3" data-date-creation="2024-09-01">
          <div class="card h-100">
            <img src="images/<?php echo $produit['image']; ?>" class="card-img-top img-fluid" alt="<?php echo $produit['nom']; ?>" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $produit['id']; ?>">
            <div class="card-body">
              <h5 class="card-title" style="color:#0b5ed7; font-weight: bold;"><?php echo $produit['nom']; ?></h5>
              <p class="card-text1" style="font-size: 15px; font-weight: 600;"><?php echo $produit['description']; ?></p>
              <!-- <p class="card-text" style="text-decoration: underline;">
                <span>Catégorie :&nbsp;</span><?php echo $produit['categorie']; ?>
              </p> -->
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
        <!-- Modal pour afficher l'image -->
        <div class="modal fade" id="imageModal<?php echo $produit['id']; ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo $produit['id']; ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header justify-content-center"> <!-- Centrer le contenu de l'en-tête -->
                <h5 class="modal-title" style="font-weight: bold;" id="imageModalLabel <?php echo $produit['id']; ?>"><?php echo $produit['nom']; ?></h5>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <img src="images/<?php echo $produit['image']; ?>" style="width:150%; height: 380px;" class="img-fluid" alt="<?php echo $produit['nom']; ?>">
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
                                  echo '<li class="list-group-item"><p style="text-decoration: underline;">' . htmlspecialchars($c['nom']) . '</p></li>';
                              }
                          }
                      } else {
                          echo '<li class="list-group-item">Categories data is not available.</li>';
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
  </div>
  <?php include "include/footer.php"; ?>
      <div class="social-buttons">
    <a href="https://www.facebook.com" target="_blank" title="Facebook" class="fb">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="bi bi-facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
        </svg>
    </a>
    <a href="https://instagram.com" target="_blank" title="Instagram" class="insta">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
        </svg>
    </a>
    <a href="https://email.com" target="_blank" title="Email" class="email">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
        </svg>
    </a>
    <a href="https://whatsapp.com" target="_blank" title="Whatsapp" class="whatsapp">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.634-2.962 6.591-6.592 6.591zm3.672-4.948c-.203-.101-1.2-.593-1.387-.66-.187-.067-.324-.1-.461.102-.137.203-.53.66-.648.797-.119.137-.239.154-.442.051-.203-.102-.853-.314-1.624-.999-.6-.534-1.002-1.2-1.12-1.403-.118-.203-.013-.312.09-.414.093-.093.203-.239.304-.358.102-.119.137-.203.203-.34.067-.137.034-.255-.017-.357-.05-.102-.462-1.118-.634-1.536-.167-.402-.34-.347-.461-.353h-.394c-.136 0-.357.05-.545.255s-.712.695-.712 1.695c0 1 .728 1.969.83 2.105.102.136 1.432 2.185 3.466 3.062.484.21.86.335 1.155.428.486.154.927.132 1.276.08.389-.058 1.2-.49 1.37-.962.17-.471.17-.875.118-.962-.05-.085-.186-.136-.39-.237z"/>
        </svg>
    </a>
</div>
</body>
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
<script>
document.getElementById('sortPrix').addEventListener('change', function() {
    const sortOption = this.value;
    const produits = Array.from(document.querySelectorAll('.col-12.col-sm-6.col-md-4.col-lg-3'));

    if (sortOption === 'asc' || sortOption === 'desc') {
        produits.sort((a, b) => {
            const prixA = parseFloat(a.querySelector('.card-text').textContent.replace('DT', '').trim());
            const prixB = parseFloat(b.querySelector('.card-text').textContent.replace('DT', '').trim());
            return sortOption === 'asc' ? prixA - prixB : prixB - prixA;
        });
    } else if (sortOption === 'name_asc' || sortOption === 'name_desc') {
        produits.sort((a, b) => {
            const nomA = a.querySelector('.card-title').textContent.toLowerCase();
            const nomB = b.querySelector('.card-title').textContent.toLowerCase();
            if (nomA < nomB) return sortOption === 'name_asc' ? -1 : 1;
            if (nomA > nomB) return sortOption === 'name_asc' ? 1 : -1;
            return 0;
        });
    } else if (sortOption === 'random') {
        produits.sort(() => Math.random() - 0.5);
    }
    const container = document.querySelector('.row');
    produits.forEach(produit => container.appendChild(produit));
});
</script>
</html>
