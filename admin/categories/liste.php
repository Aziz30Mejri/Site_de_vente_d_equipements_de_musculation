<?php
session_start();
include "../../include/functions.php";
$categories = getAllCategories();
$current_page = 'categories';
$nomSociete = getNomSociete();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">
    <title>Admin : Catégorie</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../css/dashboard.css" rel="stylesheet">
    <style>
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
            width: 780px;
            word-wrap: break-word;
            white-space: normal;
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
                <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Liste des catégories</h1>
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
                            Catégorie ajoutée avec succès
                          </div>';
                } ?>
                <?php if (isset($_GET['modif']) && $_GET['modif'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Catégorie modifiée avec succès
                          </div>';
                } ?>
                <?php if (isset($_GET['delete']) && $_GET['delete'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Catégorie supprimée avec succès
                          </div>';
                } ?>
                <?php if (isset($_GET['erreur']) && $_GET['erreur'] == "duplicate") {
                    print '<div class="alert alert-danger" id="messageAlert">
                            Nom de catégorie est déja existe
                          </div>';
                } ?>
                <table class="table">
                    <thead style="border-top:2px solid #ddd;">
                        <tr>
                            <th scope="col" style="border-top:2px solid #ddd; border-right: 2px solid #ddd; border-left: 2px solid #ddd;">#</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Nom</th>
                            <th scope="col" class="col-description" style="border-right: 2px solid #ddd;">Description</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($categories as $c) {
                            $i++;
                            print '<tr style="border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                            <th scope="row" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . $i . '</th>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars(ucwords($c['nom'])) . '</td>
                            <td class="col-description" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars(ucfirst(strtolower($c['description']))) . '</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">
                                <a data-toggle="modal" data-target="#editModal' . $c['id'] . '" style="margin-right: 5px; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" fill="#218838" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                                <a onclick="return popUpDeleteCategorie()" href="supprimer.php?idc=' . $c['id'] . '" >
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
            </div>
        </main>
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Ajouter Catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="ajout.php" method="post">
                    <div class="form-group">
                        <input type="text" id="nom" name="nom" minlenght="5" class="form-control" placeholder="Nom de catégorie ..." required/>
                    </div>
                    <div class="form-group">
                        <textarea id="description" name="description" minlenght="5" class="form-control" placeholder="Description de catégorie ..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><span>Ajouter</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php foreach ($categories as $categorie) { ?>
    <!-- Modal Modifier -->
    <div class="modal fade" id="editModal<?php echo $categorie['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel<?php echo $categorie['id']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel<?php echo $categorie['id']; ?>">Modifier Catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="modifier.php" method="post">
                        <input type="hidden" name="idc" value="<?php echo $categorie['id']; ?>"/>
                        <div class="form-group">
                            <input type="text" id="nom" name="nom" minlenght="5" class="form-control" value="<?php echo htmlspecialchars($categorie['nom']); ?>" placeholder="Nom de catégorie ..." required/>
                        </div>
                        <div class="form-group">
                            <textarea id="description" name="description" minlenght="5" class="form-control" placeholder="Description de catégorie ..." required><?php echo htmlspecialchars($categorie['description']); ?></textarea>
                        </div>
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
<script>
    function popUpDeleteCategorie(){
        return confirm("Êtes-vous sûr de vouloir supprimer cette catégorie?");
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
</body>
</html>