<?php
  session_start();
  if (isset($_SESSION['nom'])) {
    //header('location:profile.php');
  }

  include "../include/functions.php";
  $user = true;
  if (!empty($_POST)) {
    $user = ConnectAdmin($_POST);
    if ($user) {
      session_start();
      $_SESSION['id'] = $user['id'];
      $_SESSION['email'] =$user['email'];
      $_SESSION['nom'] =$user['nom'];
      $_SESSION['mp'] =$user['mp'];
      header('location:home.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(getNomSociete()); ?> : Espace Admin | Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.css" integrity="sha512-Gebe6n4xsNr0dWAiRsMbjWOYe1PPVar2zBKIyeUQKPeafXZ61sjU2XCW66JxIPbDdEH3oQspEoWX8PQRhaKyBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
.container {
        padding-bottom: 70px;
      }
      form {
      max-width: 400px;
      margin: auto;
      }
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
    <div class="container" style="margin-top:-10px;">
    <div class="row justify-content-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4 p-5">
        <h1 class="text-center">Espace Admin: Connexion</h1>
        <form action="connexion.php" method="post">
          <div class="mb-3">
            <span>Adresse Email</span>
            <input type="email" name="email" class="inp w-100" id="exampleInputEmail1" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <span>Mot de Passe</span>
            <input type="password" name="mp" class="inp w-100" id="exampleInputPassword1" required>
          </div>
          <button type="submit" class="oauthButton w-100" style="margin-top: 3.4rem;">
            Connecter
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m6 17 5-5-5-5"></path><path d="m13 17 5-5-5-5"></path>
            </svg>
          </button>
          </form>
    </div>
    </div>
    </div>
    <?php include "../include/footer.php"; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.all.js" integrity="sha512-7CwElIdU6YF7ExXbTE9Z4xGnaKwLdQTdaMaonRG3XRhcIqTTg9K/eEiNInwBs7UgmY6o5MA2PLEzcwf1rRWKRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php 
  if (!$user) {
    print"
    <script>
      Swal.fire({
      icon: 'error',
      title: 'Erreur!',
      text: 'Cordonnées non valide',
      confirmButtonText: 'Ok',
      timer: 2000
      })
    </script>
  ";
  }
?>



</html>