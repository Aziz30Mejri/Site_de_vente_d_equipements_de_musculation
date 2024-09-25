<?php
session_start();
include "../../include/functions.php";
$current_page = 'commandes';
$nomSociete = getNomSociete();
$visiteurId = $_SESSION['id'];
$visiteur = getVisiteurInfo($visiteurId);
$nomVisiteur = $visiteur['nom'];
$prenomVisiteur = $visiteur['prenom'];
$telephoneVisiteur = $visiteur['telephone'];

$paniersParPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPaniers = count(getAllPaniers());
$totalPages = ceil($totalPaniers / $paniersParPage);
$paniers = getAllPaniersParPage($page, $paniersParPage);

if (isset($_POST['sauvegarder'])) {
    //Changer etat du panier
    changerEtatPanier($_POST);
}

$commandes = getAllCommandes();

if (isset($_POST['btnSearch'])) {
    if ($_POST['etat'] =="tous") {
        $paniers = getAllPaniers();
    }else {
        $paniers = getPaniersByEtat($paniers, $_POST['etat']);   
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">
    <title>Admin : Paniers</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../css/dashboard.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px;
            background-color: transparent;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .pagination-container a:hover svg path {
            fill: #28A745
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo htmlspecialchars(getNomSociete()); ?></a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="../../deconnexion.php">Déconnexion</a>
        </li>
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        <?php
        include"../template/navigation.php";
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Liste des paniers</h2>
            </div>
            <!--- Liste Start --->
            <div>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Commande modifiée avec succès
                          </div>';
                } ?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="from-group d-flex">
                        <select name="etat" class="form-control">
                            <option value="" selected disabled hidden>-- Choisir l'etat --</option>
                            <option value="tous" <?php if(isset($_POST['etat']) && $_POST['etat'] == 'tous') echo 'selected'; ?>>Tous</option>
                            <option value="en cours" <?php if(isset($_POST['etat']) && $_POST['etat'] == 'en cours') echo 'selected'; ?>>En Cours</option>
                            <option value="en livraison" <?php if(isset($_POST['etat']) && $_POST['etat'] == 'en livraison') echo 'selected'; ?>>En Livraison</option>
                            <option value="livraison terminée" <?php if(isset($_POST['etat']) && $_POST['etat'] == 'livraison terminée') echo 'selected'; ?>>Livraison Terminée</option>
                        </select>
                        <input type="submit" class="btn btn-primary ml-2" name="btnSearch" value="Chercher"/>
                    </div>
                </form>
                <table class="table" style="margin-top: 10px;">
                    <thead style="border-top:2px solid #ddd;">
                        <tr style="border-top:2px solid #ddd; border-right: 2px solid #ddd; border-left: 2px solid #ddd;">
                            <th scope="col" style="border-right: 2px solid #ddd;">#</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Client</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Total</th>
                            <th scope="col" style="border-right: 2px solid #ddd; cursor: pointer;" onclick="sortTable(3)">
                                Date
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-filter" viewBox="0 0 16 16">
                                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Etat</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($paniers as $panier) {
                            $i++;
                            print '<tr style="border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                            <th scope="row" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . $i . '</th>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars(ucwords($panier['nom'] . ' ' . $panier['prenom'])) .'</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars($panier['total']) .' DTN</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars($panier['date_creation']) .'</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars($panier['etat']) .'</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">
                                <a class="btn btn-success" style="color: white;" data-toggle="modal" data-target="#Commandes' . $panier['id'] . '">Afficher</a>
                                <a class="btn btn-primary" style="color: white;" data-toggle="modal" data-target="#Traiter' . $panier['id'] . '">Traiter</a>
                            </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Navigation -->
                <?php if ($totalPaniers > $paniersParPage) { ?>
                    <div class="pagination-container">
                        <a href="?page=<?php echo $page > 1 ? $page - 1 : $totalPages; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16" style="color: black;">
                                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                            </svg>
                            </a>
                            <a href="?page=<?php echo $page < $totalPages ? $page + 1 : 1; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16" style="color: black;">
                                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                            </svg>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </main>
    </div>
</div>
<?php foreach ($paniers as $p) { ?>
    <!-- Modal Afficher -->
    <div class="modal fade" id="Commandes<?php echo $p['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel<?php echo $p['id']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel<?php echo $categorie['id']; ?>">Liste des commandes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Nom produit</th>
                                <th style="text-align: center;">Image</th>
                                <th style="text-align: center;">Quantité</th>
                                <th style="text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($commandes as $index => $c) {
                                if ($c['panier'] == $p['id']) {
                                    print'<tr>
                                            <td style="text-align: center;">'.$c['nom'].'</td>
                                            <td style="text-align: center;"><img src="../../images/'.$c['image'].'" width="100" /></td>
                                            <td style="text-align: center;">'.$c['quantite'].'</td>
                                            <td style="text-align: center;">'.$c['total'].' DTN</td>
                                        </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" onclick="imprimerPanier(<?php echo $p['id']; ?>)">Imprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php foreach ($paniers as $p) { ?>
    <!-- Modal Traiter -->
    <div class="modal fade" id="Traiter<?php echo $p['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel<?php echo $p['id']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel<?php echo $categorie['id']; ?>">Traiter la commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" value="<?php echo $p['id']?>" name="panier_id">
                        <?php
                        // Exemple de valeur stockée
                        $p['etat'] = htmlspecialchars($p['etat']);
                        ?>
                        <div class="form-group">
                            <select name="etat" class="form-control">
                                <option value="en livraison" <?php if ($p['etat'] === 'en livraison') echo 'selected'; ?>>
                                    En Livraison
                                </option>
                                <option value="livraison terminée" <?php if ($p['etat'] === 'livraison terminée') echo 'selected'; ?>>
                                    Livraison Terminée
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="sauvegarder" class="btn btn-primary">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../js/popper.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
<!-- Graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.1/dist/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function handleAlerts() {
        const alert = document.getElementById('messageAlert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = 0;
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 1000);
            }, 2000);
            setTimeout(() => {
                window.location.href = "liste.php";
            }, 2000);
        }
    }
    window.addEventListener('load', handleAlerts);
</script>
<script>
    function imprimerPanier(panierId) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const logoSociete = '../../images/logo_life.png'; // Chemin vers votre image
        const adresseSociete = "123, Rue d'Egypte, 2011 Tunis";
        const telephoneSociete = "+216 23 155 121";
        const emailSociete = "contact@lifefitness.com";
        const nomVisiteur = "<?php echo $nomVisiteur; ?>";
        const prenomVisiteur = "<?php echo $prenomVisiteur; ?>";
        const telephoneVisiteur = "<?php echo $telephoneVisiteur; ?>";
        const img = new Image();
        img.src = logoSociete;
        img.onload = function() {
            doc.addImage(img, 'PNG', 10, 10, 50, 30);
            doc.setFontSize(12);
            doc.text(adresseSociete, 10, 50);
            doc.text(`Téléphone: ${telephoneSociete}`, 10, 55);
            doc.text(`Email: ${emailSociete}`, 10, 60);
            const date = new Date().toLocaleDateString();
            doc.text(`Date: ${date}`, 150, 50);
            doc.text(`Facture n°# ${panierId}`, 150, 55);
            doc.text(`Client: ${prenomVisiteur} ${nomVisiteur}`, 75, 70);
            doc.text(`Téléphone: ${telephoneVisiteur}`, 80, 75);
            doc.setLineWidth(0.5);
            doc.line(10, 80, 200, 80);
            doc.setFontSize(14);
            doc.text("Détails de la commande :", 10, 85);
            doc.setFontSize(12);
            let yPosition = 95;
            doc.text('Produit', 10, yPosition);
            doc.text('Quantité', 80, yPosition);
            doc.text('Prix Unitaire', 120, yPosition);
            doc.text('Total', 170, yPosition);
            yPosition += 10;
            const commandes = document.querySelectorAll(`#Commandes${panierId} tbody tr`);
            let totalCommande = 0;
            commandes.forEach((commande) => {
                const cols = commande.querySelectorAll('td');
                const nomProduit = cols[0].innerText;
                const quantite = parseInt(cols[2].innerText);
                let total = cols[3].innerText.replace(' DTN', '').trim();
                total = parseFloat(total);
                if (!isNaN(quantite) && !isNaN(total)) {
                    const prixUnitaire = (total / quantite).toFixed(2);
                    totalCommande += total;
                    doc.text(nomProduit, 10, yPosition);
                    doc.text(quantite.toString(), 80, yPosition);
                    doc.text(Math.round(prixUnitaire).toString() + " DTN", 120, yPosition);
                    doc.text(Math.round(total).toString() + " DTN", 170, yPosition);
                    yPosition += 10;
                } else {
                    console.error("Quantité ou total invalide pour le produit:", nomProduit);
                }
            });
            yPosition += 10;
            doc.line(10, yPosition, 200, yPosition);
            yPosition += 10;
            doc.setFontSize(12);
            doc.text('Total Commande :', 120, yPosition);
            doc.text(Math.round(totalCommande).toString() + " DTN", 170, yPosition);
            yPosition += 20;
            doc.setFontSize(10);
            doc.text('Merci pour votre achat chez ' + "<?php echo $nomSociete; ?>" + '!', 10, yPosition);
            doc.text('Retours possibles sous 3 jours avec la facture.', 10, yPosition + 5);
            doc.text('Modes de paiement acceptés : Espèces.', 10, yPosition + 10);
            doc.save(`facture_panier_${panierId}.pdf`);
        };
    }
</script>
<script>
let isAscending = true; // Variable pour suivre l'état du tri

function sortTable(columnIndex) {
    const table = document.querySelector(".table tbody");
    const rows = Array.from(table.rows);
    const sortIcon = document.getElementById("sortIcon");
    rows.sort((a, b) => {
        const dateA = new Date(a.cells[columnIndex].innerText);
        const dateB = new Date(b.cells[columnIndex].innerText);

        return isAscending ? dateA - dateB : dateB - dateA; // Tri ascendant ou descendant
    });
    rows.forEach(row => table.appendChild(row));
    isAscending = !isAscending;
    sortIcon.setAttribute("class", isAscending ? "bi bi-chevron-up" : "bi bi-chevron-down");
}
</script>
</body>
</html>