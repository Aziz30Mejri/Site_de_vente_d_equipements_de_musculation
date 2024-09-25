<?php
  session_start();
  include "include/functions.php";

  $total =0;
  if (isset($_SESSION['panier'])) {
    $total = $_SESSION['panier'][1];
  }
  $categories = getAllCategories();

  if (!empty($_POST)) {
    $produits = searchProduits($_POST['search']);
  }else{
    $produits = getAllProduits();
  }

  $commandes = array();
  if (isset($_SESSION['panier'])) {
    if (count($_SESSION['panier'][3]) > 0) {
        $commandes = $_SESSION['panier'][3];
    }
  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars(getNomSociete()); ?> : Panier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.css" integrity="sha512-Gebe6n4xsNr0dWAiRsMbjWOYe1PPVar2zBKIyeUQKPeafXZ61sjU2XCW66JxIPbDdEH3oQspEoWX8PQRhaKyBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    @media (max-width: 576px) {
    h1 {
        font-size: 1.5rem;
    }
    .table th, .table td {
        font-size: 0.9rem;
    }
    .btn {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
    }
    }
    .Btnsupp {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      width: 45px;
      height: 45px;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition-duration: .3s;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
      background-color: #e31836;
    }
    .signsupp {
      width: 100%;
      transition-duration: .3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .signsupp svg {
      width: 18px;
    }
    .signsupp svg path {
      fill: white;
    }
    .textsupp {
      position: absolute;
      right: 0%;
      width: 0%;
      opacity: 0;
      color: white;
      font-size: 1.2em;
      font-weight: 600;
      transition-duration: .3s;
}
</style>
</head>
<body>
  <?php include "include/header.php"; ?>
  <div class="container mt-4 p-5" style="margin-bottom: 7.1rem;">
    <h1>VOTRE PANIER :</h1>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Produit</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($commandes as $index => $commande) {
                    print'<tr>
                        <th scope="row">'.($index+1).'</th>
                        <td>'.$commande[5].'</td>
                        <td>'.$commande[0].' pièces</td>
                        <td>'.$commande[1].' DTN </td>
                        <td>
                          <a class="Btnsupp" href="actions/enlever-produit-panier.php?id='.$index.'">
                          <div class="signsupp">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                              <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                          </div>
                          <div class="textsupp">Annuler</div>
                          </a>
                        </td>
                      </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="text-end mt-3">
        <h4 style="color: red; font-weight: bold;">Total: <?php echo $total; ?> DN</h4>
        <a href="actions/valider-panier.php" id="valider-btn" class="btn btn-success" style="width:100px">Valider</a>
    </div>
</div>
<?php include "include/footer.php"; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.all.js" integrity="sha512-7CwElIdU6YF7ExXbTE9Z4xGnaKwLdQTdaMaonRG3XRhcIqTTg9K/eEiNInwBs7UgmY6o5MA2PLEzcwf1rRWKRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      var validerBtn = document.getElementById("valider-btn");
      validerBtn.addEventListener("click", function(event) {
          var commandes = <?php echo json_encode($commandes); ?>;
          if (commandes.length === 0) {
              event.preventDefault();
              Swal.fire({
                  icon: "error",
                  title: "Oups...",
                  html: "Votre panier est <strong>vide</strong>. <br>Ajoutez des produits avant de valider.",
              });
          }
      });
  });
  </script>
</script>
</html>