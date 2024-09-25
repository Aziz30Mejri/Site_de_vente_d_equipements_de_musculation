<?php
session_start();
include "../../include/functions.php";
$visiteurs = getAllUsers();
$current_page = 'visiteurs';
$nomSociete = getNomSociete();
$visiteursParPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalVisiteurs = count(getAllUsers());
$totalPages = ceil($totalVisiteurs / $visiteursParPage);
$visiteurs = getAllUsersParPage($page, $visiteursParPage);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">
    <title>Admin Profile</title>
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
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo htmlspecialchars($nomSociete); ?></a>
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
                <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Liste des visiteurs</h2>
            </div>
            <!--- Liste Start --->
            <div>
                <?php if (isset($_GET['valider']) && $_GET['valider'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Visiteur validée avec succès
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
                <table class="table table-fixed" id="visiteursTable">
                    <thead style="border-top:2px solid #ddd;">
                        <tr>
                            <th scope="col" style="width: 50px; border-top: 2px solid #ddd; border-right: 2px solid #ddd; border-left: 2px solid #ddd;">#</th>
                            <th scope="col" style="width: 300px; border-right: 2px solid #ddd;">Nom et Prénom</th>
                            <th scope="col" style="width: 350px; border-right: 2px solid #ddd;">Email</th>
                            <th scope="col" style="width: 100px; border-right: 2px solid #ddd;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($visiteurs as $i => $visiteur) {
                            $i++;
                            print '<tr style="border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                            <th scope="row" style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . $i . '</th>
                            <td style="border-right: 2px solid #ddd; border-left: 2px solid #ddd;">' . htmlspecialchars($visiteur['nom'] .' '.$visiteur['prenom']).'</td>
                            <td style="border-right: 2px solid #ddd; border-top: 2px solid #ddd;">' . htmlspecialchars($visiteur['email']) . '</td>
                            <td style="border-right: 2px solid #ddd; border-top: 2px solid #ddd;">
                                <a href="valider.php?id=' . $visiteur['id'] . '" onclick="return confirmValidation(' . $visiteur['id'] . ')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#218838" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793z"/>
                                </svg>
                                </a>
                            </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Navigation -->
                <?php if ($totalVisiteurs > $visiteursParPage) { ?>
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
function confirmValidation(id) {
    const userConfirmed = confirm("Êtes-vous sûr de vouloir valider ce visiteur ?");
    if (userConfirmed) {
        return true;
    } else {
        return false;
    }
}
</script>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll('#visiteursTable tbody tr');
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