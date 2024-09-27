<?php
session_start();
include "../../include/functions.php";
$stocks = getStocks();
$current_page = 'stocks';
$nomSociete = getNomSociete();
$stocksParPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalProduits = count(getStocks());
$totalPages = ceil($totalProduits / $stocksParPage);
$stocks = getStocksParPage($page, $stocksParPage);
$produitsZeroStock = getProduitsZeroStock();

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">
    <title>Admin : Stocks</title>
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
            left: 35%;
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
                <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Stocks des produits</h2>
            </div>
            <!--- Liste Start --->
            <div>
                <?php if (isset($_GET['modif']) && $_GET['modif'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Stock modifiée avec succès
                          </div>';
                } ?>
                <!-- Afficher l'alerte uniquement si le stock est épuisé pour certains produits -->
                <?php if ($produitsZeroStock > 0): ?>
                    <div class="alert alert-danger">
                        <span class="close-btn">&times;</span>
                        Attention ! Il y a <?= $produitsZeroStock ?> produit(s) en rupture de stock.
                    </div>
                <?php endif; ?>

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
                <!-- Nouveau bouton pour exporter en Excel -->
                <div>
                    <button type="button" id="exportExcel" style="float:right; margin-right: 20px; margin-top:-40px; background:none; border:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#1a7644">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64"/>
                        </svg>
                    </button>
                    <button type="button" id="exportPdf" style="float:right; margin-top:-40px; background:none; border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#B30B00">
                        <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
                        <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/>
                    </svg>
                    </button>
                </div>
                <table class="table" id="stocksTable">
                    <thead style="border-top:2px solid #ddd;">
                        <tr>
                            <th scope="col" style="border-top:2px solid #ddd; border-right: 2px solid #ddd; border-left: 2px solid #ddd;">#</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Nom de produit</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Quantité</th>
                            <th scope="col" style="border-right: 2px solid #ddd;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = ($page - 1) * $stocksParPage;
                        foreach ($stocks as $s) {
                            $i++;
                            print '<tr style="border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                            <th scope="row" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . $i . '</th>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd; width: 660px;">' . htmlspecialchars(ucwords($s['nom'])) . '</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars($s['quantite']) . '</td>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">
                                <a class="btn btn-success" style="color: white;" data-toggle="modal" data-target="#editModal' . $s['id'] . '">Ajouter</a>
                            </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Navigation -->
                <?php if ($totalProduits > $stocksParPage) { ?>
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
<?php foreach ($stocks as $index => $stock) { ?>
    <!-- Modal Ajouter -->
    <div class="modal fade" id="editModal<?php echo $stock['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel<?php echo $stock['id']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel<?php echo $stock['id']; ?>">Ajouter au stock du <span class="text-primary"><?php echo $stock['nom']; ?></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="ajouter.php" method="post">
                        <input type="hidden" name="idstock" value="<?php echo $stock['id']; ?>"/>
                        <div class="form-group">
                            <label for="quantite">Quantité à ajouter:</label>
                            <input type="number" step="1" id="quantite" name="quantite" class="form-control" min="0" placeholder="Quantité à ajouter" required/>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
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
    var rows = document.querySelectorAll('#stocksTable tbody tr');
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
<script>
document.getElementById('exportExcel').addEventListener('click', function() {
    var table = document.getElementById('stocksTable');
    var wb = XLSX.utils.book_new();
    var ws_data = [
        ["Liste des Stocks"],
        [],
    ];
    var ws = XLSX.utils.table_to_sheet(table, {origin: 'A3'});
    XLSX.utils.sheet_add_aoa(ws, ws_data, {origin: 'A1'});
    XLSX.utils.book_append_sheet(wb, ws, "Stocks");
    XLSX.writeFile(wb, 'stocks_des_produits.xlsx');
});
</script>
<script>
document.getElementById('exportPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF();
    var pageWidth = doc.internal.pageSize.getWidth();
    var title = "Liste des Stocks";
    var textWidth = doc.getTextWidth(title);
    var xPos = (pageWidth - textWidth) / 2;
    doc.setFont("Helvetica", "bold");
    doc.text(title, xPos, 10);
    doc.setFont("Helvetica", "normal");
    doc.autoTable({ 
        html: '#stocksTable',
        startY: 20,
        headStyles: { fillColor: [41, 128, 185] },
        theme: 'grid',
        columns: [
            { dataKey: 'col1', title: 'Colonne 1' },
            { dataKey: 'col2', title: 'Colonne 2' },
            { dataKey: 'col3', title: 'Colonne 3' },
        ],
        styles: {
            halign: 'center',
            textColor: [0, 0, 0],
        }
    });
    doc.save('stocks_des_produits.pdf');
});
</script>
</body>
</html>
