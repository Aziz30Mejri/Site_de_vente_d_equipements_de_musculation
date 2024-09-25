<?php
  session_start();
  if (isset($_SESSION['nom'])) {
    header('location:profile.php');
  }
  
  include "include/functions.php";
  $showRegistrationAlert = 0;
  $categories = getAllCategories();

  if (!empty($_POST)) {
    if (AddVisiteur($_POST)) {
      $showRegistrationAlert = 1;
    } 
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(getNomSociete()); ?> : S'inscrire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.css" integrity="sha512-Gebe6n4xsNr0dWAiRsMbjWOYe1PPVar2zBKIyeUQKPeafXZ61sjU2XCW66JxIPbDdEH3oQspEoWX8PQRhaKyBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      @media (max-width: 576px) {
      h1 {
          font-size: 1.5rem;
      }
      .form-text {
          font-size: 0.85rem;
      }
    }
    .oauthButton {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        margin: 50px auto 0 auto;
        padding: auto 15px 15px auto;
        width: 250px;
        height: 40px;
        border-radius: 5px;
        border: 2px solid #323232;
        background-color: #fff;
        box-shadow: 4px 4px #323232;
        font-size: 16px;
        font-weight: 600;
        color: #323232;
        cursor: pointer;
        transition: all 250ms;
        position: relative;
        overflow: hidden;
        z-index: 1;
      }
      .oauthButton::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        background-color: #212121;
        z-index: -1;
        -webkit-box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
        box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
        transition: all 250ms;
      }
      .oauthButton:hover {
        color: #e8e8e8;
      }
      .oauthButton:hover::before {
        width: 100%;
      }
      .inp {
        height: 40px;
        border-radius: 5px;
        border: 2px solid #323232;
        background-color: #fff;
        box-shadow: 4px 4px #323232;
        font-size: 15px;
        font-weight: 600;
        color: #323232;
        padding: 5px 10px;
        outline: none;
      }
 </style>
  </head>
<body>
  <?php include "include/header.php";?>
  <div class="container" style="margin-top: -30px;">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4 p-5">
            <h1 class="text-center">S'inscrire</h1>
            <h6 class="text-center">Créez un compte gratuit avec votre email.</h6>
            <form action="register.php" method="post" style= "max-width: 400px; margin: auto;">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" name="nom" class="inp w-100" id="nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" name="prenom" class="inp w-100" id="prenom" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse Email :</label>
                    <input type="email" name="email" class="inp w-100" id="email" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="mp" class="form-label">Mot de Passe :</label>
                    <input type="password" name="mp" class="inp w-100" id="mp" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone :</label>
                    <input type="text" name="telephone" class="inp w-100" id="telephone" required>
                </div>
                <button type="submit" class="oauthButton w-100">
                  Enregistrer
                  <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 17 5-5-5-5"></path><path d="m13 17 5-5-5-5"></path>
                  </svg>
                </button>
            </form>
        </div>
    </div>
</div>
<?php include "include/footer.php"; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.all.js" integrity="sha512-7CwElIdU6YF7ExXbTE9Z4xGnaKwLdQTdaMaonRG3XRhcIqTTg9K/eEiNInwBs7UgmY6o5MA2PLEzcwf1rRWKRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php 
  if ($showRegistrationAlert == 1) {
    print"
    <script>
      Swal.fire({
      icon: 'success',
      title: 'Succès!',
      text: 'Création de compte avec succès',
      confirmButtonText: 'Ok',
      timer: 2000
      }).then((result) => {
        if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
          window.location.href = 'connexion.php';
        }
      });
    </script>
  ";
  }
?>
</html>