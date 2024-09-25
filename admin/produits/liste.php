<?php
session_start();
include "../../include/functions.php";
$categories = getAllCategories();
$produits = getAllProduits();
$current_page = 'produits';
$nomSociete = getNomSociete();
$produitsParPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalProduits = count(getAllProduits()); // Récupérer le nombre total de produits
$totalPages = ceil($totalProduits / $produitsParPage);
// Récupérer les produits pour la page courante
$produits = getProduitsParPage($page, $produitsParPage);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">
    <title>Admin : Produit</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../css/dashboard.css" rel="stylesheet">
    <style>
        .alert {
            transition: opacity 1s ease-out;
        }
        .btnajouter {
            border: none !important;
            background-color: #0079FA;
            padding: 0.6em 1.2em 0.6em 1em;
            border-radius: 0.2em;
            transition: all ease-in-out 0.2s;
        }
        .btnajouter span {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: 600;
        }
        .btnajouter:hover {
            background-color: #0071e2;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .col-description {
            width: 650px; /* Fixe la largeur de la colonne */
            word-wrap: break-word; /* Permet au texte de retourner à la ligne */
            white-space: normal; /* Assure que le texte ne reste pas sur une seule ligne */
        }
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            position: fixed;
            bottom: 20px; /* Distance du bas de la fenêtre */
            right: 20px; /* Distance du bord droit de la fenêtre */
            background-color: #fff; /* Arrière-plan pour s'assurer qu'ils restent visibles */
            padding: 10px; /* Espacement autour des boutons */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Optionnel : ombre pour plus de visibilité */
            z-index: 1000; /* Assure que les boutons sont au-dessus du contenu */
        }
        .pagination-container a:hover svg path {
            fill: #e41119; /* Change path fill color on hover */
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .form button {
            border: none;
            background: none;
            color: #8b8ba7;
        }
        .form {
            --timing: 0.3s;
            --width-of-input: 245px;
            --height-of-input: 40px;
            --border-height: 2px;
            --input-bg: #fff;
            --border-color: #111;
            --border-radius: 30px;
            --after-border-radius: 1px;
            position: relative;
            left: 38%;
            margin-bottom: 10px;
            width: var(--width-of-input);
            height: var(--height-of-input);
            display: flex;
            align-items: center;
            padding-inline: 0.8em;
            border-radius: var(--border-radius);
            transition: border-radius 0.5s ease;
            background: var(--input-bg);
        }
        .input {
            font-size: 16px;
            font-weight: 600;
            background-color: transparent;
            width: 100%;
            height: 100%;
            padding-inline: 0.5em;
            padding-block: 0.7em;
            border: none;
        }
        .form:before {
            content: "";
            position: absolute;
            background: var(--border-color);
            transform: scaleX(0);
            transform-origin: center;
            width: 100%;
            height: var(--border-height);
            left: 0;
            bottom: 0;
            border-radius: 1px;
            transition: transform var(--timing) ease;
        }
        .form:focus-within {
            border-radius: var(--after-border-radius);
        }
        input:focus {
            outline: none;
        }
        .form:focus-within:before {
            transform: scale(1);
        }
        .reset {
            border: none;
            background: none;
            opacity: 0;
            visibility: hidden;
        }
        input:not(:placeholder-shown) ~ .reset {
            opacity: 1;
            visibility: visible;
        }
        .form:focus-within .reset svg path {
            color: #111;
        }
        .form:focus-within button {
            color: #111;
        }
        .form svg {
            width: 17px;
            margin-top: 3px;
        }
        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
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
                <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Liste des produits</h2>
                <div>
                    <button data-toggle="modal" data-target="#addCategoryModal" class="btnajouter">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                            </svg> Ajouter
                        </span>
                    </button>
                </div>
            </div>
            <!--- Liste Start --->
            <div>
            <?php if (isset($_GET['ajout']) && $_GET['ajout'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Produit ajoutée avec succès
                          </div>';
                } ?>
                <?php if (isset($_GET['modif']) && $_GET['modif'] == "ok") {
                    echo '<div class="alert alert-success" id="messageAlert">
                    Produit modifié avec succès</div>';
                } ?>
                <?php if (isset($_GET['delete']) && $_GET['delete'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Produit supprimée avec succès
                          </div>';
                } ?>
                <?php if (isset($_GET['erreur']) && $_GET['erreur'] == "duplicate") {
                    print '<div class="alert alert-danger" id="messageAlert">
                            Nom de Produit est déjà existé
                          </div>';
                } ?>
                <form class="form" action="index.php" method="POST">
                    <button>
                        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                            <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <input class="input" placeholder="Recherche Par Nom" type="search" aria-label="Search" name="search" id="searchInput">
                    <button class="reset" type="reset">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>
                <table class="table table-fixed" id="produitsTable">
                    <thead style="border-top:2px solid #ddd;">
                        <tr>
                            <th scope="col" style="border-top:2px solid #ddd; border-right: 2px solid #ddd; border-left: 2px solid #ddd;">#</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Nom</th>
                            <th scope="col" class="col-description" style="border-right: 2px solid #ddd;">Description</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Prix</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = ($page - 1) * $produitsParPage;
                        foreach ($produits as $p) {
                            $i++;
                            print '<tr style="border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                            <th scope="row" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . $i . '</th>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars(ucwords($p['nom'])) . '</td>
                            <td class="col-description" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars(ucfirst(strtolower($p['description']))) . '</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars($p['prix']) . ' DTN</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">
                                <a data-toggle="modal" data-target="#editModal' . $p['id'] . '" style="margin-right: 5px; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" fill="#218838" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                                <a onclick="return popUpDeleteCategorie()" href="supprimer.php?idc=' . $p['id'] . '" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#e41119" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                </svg>
                                </a>
                            </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Navigation -->
                <?php if ($totalProduits > $produitsParPage) { ?>
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
<!-- Modal Ajout -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Ajouter Produit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="ajout.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" id="nom" name="nom" minlength="5" class="form-control" placeholder="Nom de produit ..." required/>
                    </div>
                    <div class="form-group">
                        <textarea id="description" name="description" minlength="5" class="form-control" placeholder="Description de produit ..." required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="number" id="prix" name="prix" minlength="2" step="0.01" class="form-control" placeholder="Prix de produit ..." required/>
                    </div>
                    <div class="form-group">
                        <input type="file" id="image" name="image" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <select id="categorie" name="categorie" class="form-control">
                            <?php
                            foreach($categories as $index => $c){
                                echo '<option value="'.$c['id'].'">'.$c['nom'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" name="quantite" id="quantite" class="form-control" placeholder="Tapez la quantité de produit ..." required />
                    </div>
                    <input type="hidden" name="createur" id="createur" value="<?php echo $_SESSION['id'];?> "/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php foreach ($produits as $produit) { ?>
    <!-- Modal Modifier -->
    <div class="modal fade" id="editModal<?php echo $produit['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editProductLabel<?php echo $produit['id']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel<?php echo $produit['id']; ?>">Modifier Produit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="modifier.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $produit['id']; ?>"/>
                        <div class="form-group">
                            <label for="nom">Nom de Produit:</label>
                            <input type="text" id="nom" name="nom" minlength="5" class="form-control" value="<?php echo htmlspecialchars($produit['nom']); ?>" placeholder="Nom de produit ..." required/>
                        </div>
                        <div class="form-group">
                            <label for="description">Description de Produit:</label>
                            <textarea id="description" name="description" minlength="5" class="form-control" placeholder="Description de produit ..." required><?php echo htmlspecialchars($produit['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="prix">Prix:</label>
                            <input type="number" id="prix" name="prix" minlength="2" step="1.000" class="form-control" value="<?php echo htmlspecialchars($produit['prix']); ?>" placeholder="Prix de produit ..." required/>
                        </div>
                        <div class="form-group">
                        <label for="image">Image actuelle:</label><br>
                            <?php if (!empty($produit['image'])): ?>
                                <img src="../../images/<?php echo htmlspecialchars($produit['image']); ?>" alt="Image de produit" style="width: 100px; height: auto; margin-left: 40%"/>
                            <?php else: ?>
                                <p>Aucune image disponible</p>
                            <?php endif; ?>
                            <input type="file" id="image" name="image" class="form-control mt-2"/>
                        </div>
                        <div class="form-group">
                            <label for="categorie">Catégorie:</label>
                            <select id="categorie" name="categorie" class="form-control">
                                <?php
                                foreach($categories as $category){
                                    $selected = ($category['id'] == $produit['categorie']) ? 'selected' : '';
                                    print '<option value="'.$category['id'].'" '.$selected.'>'.$category['nom'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="createur" id="createur" value="<?php echo $_SESSION['id']; ?>"/>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
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
</script>
<script>
    function popUpDeleteCategorie(){
        return confirm("Êtes-vous sûr de vouloir supprimer ce produit?");
    }
</script>
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
document.getElementById('searchInput').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll('#produitsTable tbody tr');
    rows.forEach(function(row) {
        var name = row.cells[1].textContent.toLowerCase();
        if (name.indexOf(input) > -1) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
</body>
</html>