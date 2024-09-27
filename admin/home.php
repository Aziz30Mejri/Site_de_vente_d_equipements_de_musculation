<?php
session_start();
include "../include/functions.php";
$data = getData();
$current_page = 'home';
$nomSociete = getNomSociete();
$dataChart = getVentesMensuelles();
$mois = $dataChart['mois'];
$totaux = $dataChart['totaux'];
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">
    <title>Admin : Dashboard</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo htmlspecialchars($nomSociete); ?></a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="../deconnexion.php">Déconnexion</a>
        </li>
    </ul>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <?php
        include"template/navigation.php";
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Dashboard</h1>
            <div>
              <?php 
              echo $_SESSION['nom'];
              ?>
            </div>
          </div>
          
          <div class="row">
  <!-- Premier bloc -->
  <div class="col-xl-3 col-sm-6 col-12"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16" style="color: #00b5b8">
                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
              </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['clients']; ?></h3>
              <h6>nombre de clients</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Deuxième bloc -->
  <div class="col-xl-3 col-sm-6 col-12"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16" style="color: #FFAD89">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
              </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['produits']; ?></h3>
              <h6>nombre de produits</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Troisième bloc -->
  <div class="col-xl-3 col-sm-6 col-12"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16"  style="color: #16d39a">
                <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z"/>
              </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['categories']; ?></h3>
              <h6>nombre de catégories</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Quatrième bloc -->
  <div class="col-xl-3 col-sm-6 col-12"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16" style="color: #FF7693">
              <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
            </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['commandes']; ?></h3>
              <h6>nombre de commandes</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Cinquième bloc -->
  <div class="col-xl-3 col-sm-6 col-12 mt-3"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16"  style="color: #FF7693">
              <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z"/>
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
              <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
            </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['gains']; ?></h3>
              <h6>ventes totales (Dinars)</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Cinquième bloc -->
  <div class="col-xl-3 col-sm-6 col-12 mt-3"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-question" viewBox="0 0 16 16" style="color: #FFCE56">
              <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
              <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
              <path d="M13 14.5a.5.5 0 1 0-.5-.5h1a.5.5 0 0 0-.5.5"/>
            </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['demande']; ?></h3>
              <h6>Demandes en attente</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6 col-12 mt-3"> 
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="media d-flex">
            <div class="align-self-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-basket3" viewBox="0 0 16 16" style="color: #FFAD89">
              <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM3.394 15l-1.48-6h-.97l1.525 6.426a.75.75 0 0 0 .729.574h9.606a.75.75 0 0 0 .73-.574L15.056 9h-.972l-1.479 6z"/>
            </svg>
            </div>
            <div class="media-body text-right">
              <h3><?php echo $data['pdtvendus']; ?></h3>
              <h6>produits vendus</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Ajout du graphique Donut et du graphique à barres sur la même ligne -->
<div class="row" style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;  text-align: center;">
  <!-- Graphique Donut -->
  <div class="col-xl-6" style="flex: 1; max-width: 48%; margin-top: -60px;">
    <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Résume les chiffres de <?php echo htmlspecialchars($nomSociete); ?> :</h2>
    <div style="position: relative; width: 100%; height: 400px;">
      <canvas id="myDonutChart" style="position: absolute; width: 100%; height: 100%;"></canvas>
    </div>
  </div>
  <!-- Graphique à Barres -->
  <div class="col-xl-6" style="flex: 1; max-width: 48%; margin-bottom: 120px; text-align: center;">
    <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Les Ventes mensuelles :</h2>
    <canvas id="ventesChart" width="450" height="290"></canvas>
  </div>
</div>


        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
    <!-- Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.1/dist/Chart.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
          // Données PHP
          var clients = <?php echo $data['clients']; ?>;
          var produits = <?php echo $data['produits']; ?>;
          var categories = <?php echo $data['categories']; ?>;
          var commandes = <?php echo $data['commandes']; ?>;
          var gains = <?php echo $data['demande']; ?>;
          // Initialiser le Donut Chart
          var ctx = document.getElementById('myDonutChart').getContext('2d');
          var myDonutChart = new Chart(ctx, {
              type: 'doughnut', // Type de graphique
              data: {
                  labels: ['Clients', 'Produits', 'Catégories', 'Commandes', 'Demandes'],
                  datasets: [{
                      label: 'Statistiques',
                      data: [clients, produits, categories, commandes, gains],
                      backgroundColor: [
                          '#00b5b8',
                          '#FFAD89',
                          '#16d39a',
                          '#FF7693',
                          '#FFCE56'
                      ],
                      hoverBackgroundColor: [
                          '#008c8b',
                          '#d58b70',
                          '#13a080',
                          '#d96079',
                          '#ffb734'
                      ]
                  }]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                      legend: {
                          position: 'bottom',
                      },
                  },
              }
          });
      });
    </script>
<script>
        const labels = <?php echo json_encode($mois); ?>;
        const data = <?php echo json_encode($totaux); ?>;
        const ctx = document.getElementById('ventesChart').getContext('2d');
        const ventesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total des ventes (DT)',
                    data: data,
                    backgroundColor: '#FF7693',
                    borderColor: '#FF7693',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            callback: function(value, index, values) {
                                return new Date(value + '-01').toLocaleString('fr-FR', { month: 'short' });
                            }
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
  </body>
</html>
