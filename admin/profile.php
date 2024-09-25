<?php
session_start();
include "../include/functions.php";
$current_page = 'profile';
$visiteurs = getAllUsers();
$nombreNotifications = getTotalNotifications();
if (!isset($_SESSION['id'])) {
    echo "ID de l'administrateur non défini.";
    exit;
}
$adminData = getAdminById($_SESSION['id']);
if ($adminData) {
    $_SESSION['nom'] = $adminData['nom'];
    $_SESSION['email'] = $adminData['email'];
    $_SESSION['telephone'] = $adminData['telephone'];
    $_SESSION['nom_societe'] = $adminData['nom_societe'];
} else {
    echo "Aucun administrateur trouvé avec cet ID.";
    exit;
}
if (isset($_POST['btnEdit'])) {
    if (!preg_match("/^[A-Za-z\s]{5,}$/", $_POST['nom'])) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Le nom doit contenir uniquement des lettres et être supérieur à 5 caractères."];
        header('Location: profile.php');
        exit();
    }
    if (!preg_match("/^\d{8}$/", $_POST['telephone'])) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Le numéro de téléphone doit comporter exactement 8 chiffres."];
        header('Location: profile.php');
        exit();
    }
    if (!empty($_POST['mp']) && !preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $_POST['mp'])) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Le mot de passe doit comporter au moins 8 caractères, dont une lettre majuscule, une lettre minuscule, et un chiffre."];
        header('Location: profile.php');
        exit();
    }
    // Préparer les données pour la mise à jour
    $data = [
        'nom' => $_POST['nom'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'nom_societe' => $_POST['nom_societe'],
        'id_admin' => $_POST['id_admin']
    ];
    // Ajouter le mot de passe au tableau de données s'il n'est pas vide
    if (!empty($_POST['mp'])) {
        $data['mp'] = $_POST['mp'];
    }
    // Appeler la fonction pour mettre à jour les informations de l'administrateur
    if (EditAdmin($data)) {
        // Mettre à jour les valeurs de la session
        $_SESSION['nom'] = $_POST['nom'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['telephone'] = $_POST['telephone'];
        $_SESSION['nom_societe'] = $_POST['nom_societe'];
        // Stocker le message de succès dans la session
        $_SESSION['alert'] = ['type' => 'success', 'message' => "Profile modifié avec succès."];
        header('Location: profile.php');
        exit();
    } else {
        // Stocker le message d'erreur dans la session
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Erreur lors de la mise à jour des informations."];
        header('Location: profile.php');
        exit();
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
    <title>Admin : Profile</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
    <style>
        input[placeholder="Laisser vide si inchangé"]::placeholder {
            color: red;
        }
        .theme-selector {
            margin-left: 20px;
        }
        .theme-selector .bi-chevron-down {
        display: none; /* Cache la flèche */
        }
        .notification-container {
        position: relative;
        display: inline-block;
        margin-right: 10px;
        cursor: pointer
        }
        .notification-badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            top: -1px;
            right: -9px;
            transform: translate(50%, -50%);
            transition: transform 0.3s ease;
        }
        .notification-badge:hover {
            animation: swing 0.6s ease;
            color: red;
            background-color: white;
        }
        .notification-container:hover svg {
            color: white;
        }
        @keyframes swing {
            0% { transform: translate(50%, -50%) rotate(0deg); }
            25% { transform: translate(50%, -50%) rotate(-15deg); }
            50% { transform: translate(50%, -50%) rotate(15deg); }
            75% { transform: translate(50%, -50%) rotate(-15deg); }
            100% { transform: translate(50%, -50%) rotate(0deg); }
        }
        .notification-list {
            display: none; /* Cachez la liste par défaut */
            position: absolute;
            top: 47px; /* Ajustez en fonction de la position de votre icône */
            right: 150px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 10px;
            width: 190px;
            z-index: 1000;
            display: inline-block;
            cursor: pointer;
            max-width: 300px;
        }
        .icon-spacing {
            margin-right: 10px; /* Ajustez l'espace selon vos besoins */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo htmlspecialchars(getNomSociete()); ?></a>
    <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search" style="width:50%; margin-right:370px"> 
    <a class="nav-link" href="#" id="notificationIcon">
    <div class="notification-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16" style="color: white; margin-top: 5px;">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
        </svg>
        <span class="notification-badge"><?php echo $nombreNotifications; ?></span>
    </div>
    </a>
    <!-- Liste cachée -->
    <div id="notificationList" class="notification-list">
        <ul style="list-style-type: none; padding: 0; margin: 0; margin-left: 10px;">
            <li  style="text-align: center;">Tu as <?php echo $nombreNotifications; ?> notifications</li>
            <hr style="margin-top: 3px">
            <li style="margin-top: -10px; margin-bottom: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add icon-spacing" viewBox="0 0 16 16" style="color: green">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
            </svg>Nouveau visiteur</li>
            <li style="margin-bottom: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt icon-spacing" viewBox="0 0 16 16" style="color: green">
              <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
            </svg>Nouvel commande</li>
            <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" class="bi bi-wallet-fill icon-spacing" viewBox="0 0 16 16" style="color: green;">
                  <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v2h6a.5.5 0 0 1 .5.5c0 .253.08.644.306.958.207.288.557.542 1.194.542s.987-.254 1.194-.542C9.42 6.644 9.5 6.253 9.5 6a.5.5 0 0 1 .5-.5h6v-2A1.5 1.5 0 0 0 14.5 2z" stroke="currentColor"/>
                  <path d="M16 6.5h-5.551a2.7 2.7 0 0 1-.443 1.042C9.613 8.088 8.963 8.5 8 8.5s-1.613-.412-2.006-.958A2.7 2.7 0 0 1 5.551 6.5H0v6A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5z" stroke="currentColor"/>
                </svg>Stock est fini</li>
        </ul>
    </div>
    <div class="vl" style="border-left: 1px solid white; height: 30px;"></div>
    <div class="theme-selector" style="border: none;margin-left: 5px;">
    <button onclick="toggleDropdown()" style="background-color: #343a40; color: white; border-style: none; padding: 5px; border-radius: 5px; width: 100%; text-align: left; display: flex; justify-content: space-between; align-items: center;cursor: pointer">
        <span id="selectedOption">Lumière</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16" style="float: right;">
            <path d="M1.5 5.5a.5.5 0 0 1 .708-.708L8 9.793l5.792-5.792a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6z"/>
        </svg>
    </button>
    <div id="dropdown" style="display: none; background-color: #343a40; border-radius: 5px; position: absolute; width: 100%; z-index: 1;">
        <div onclick="selectOption('Lumière')" style="padding: 5px; color: white; cursor: pointer; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 8px;">
                <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
            </svg>
            Lumière
        </div>
        <div onclick="selectOption('Sombre')" style="padding: 5px; color: white; cursor: pointer; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 8px;">
                <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
            </svg>
            Sombre
        </div>
    </div>
    </div>
    <div style="display: flex; align-items: center;">
    <div class="vl" style="border-left: 1px solid white; height: 30px; margin-right: 10px; margin-left: 5px;"></div>
        <span style="color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $_SESSION['nom']; ?></span>
        <ul class="navbar-nav px-3" style="margin-left: auto;">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="../images/test_nav.jpg"
                        class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;" alt="<?php echo htmlspecialchars($_SESSION['email']); ?>" />
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <?php include "template/navigation.php"; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2 style="font-family: fantasy; text-transform: capitalize; font-size: 30px;">Profile</h2>
            </div>
            <div class="container">
            <?php
            if (isset($_SESSION['alert'])) {
                $alert = $_SESSION['alert'];
                $alertType = $alert['type'] === 'success' ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $alertType . ' alert-dismissible fade show" role="alert" id="messageAlert">
                        ' . htmlspecialchars($alert['message']) . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                // Effacer l'alerte après affichage
                unset($_SESSION['alert']);
            }
            ?>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == "ok") {
                    print '<div class="alert alert-success" id="messageAlert">
                            Profile modifiée avec succès
                          </div>';
                } ?>
                <div class="row gutters">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="account-settings">
                                    <div class="user-profile">
                                        <div>
                                            <div class="d-flex justify-content-center mb-4">
                                                <img src="../images/test.png"
                                                     class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" alt="example placeholder" />
                                            </div>
                                        </div>
                                        <h5 class="user-name" style="margin-top: 50px"><?php echo htmlspecialchars($_SESSION['nom']); ?></h5>
                                        <h6 class="user-email"><?php echo htmlspecialchars($_SESSION['email']); ?></h6>
                                    </div>
                                    <div class="about">
                                        <h5 class="mb-2 text-primary">À propos</h5>
                                        <p>Je m'appelle <?php echo htmlspecialchars($_SESSION['nom']); ?>, le responsable du site web pour la société <?php echo htmlspecialchars(getNomSociete()); ?>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de modification du profil -->
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h6 class="mb-2 text-primary" style="font-weight: bold;">Détails personnels :</h6>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nom" style="font-weight: bold;">Nom et prénom :</label>
                                                <input type="text" name="nom" value="<?php echo htmlspecialchars($_SESSION['nom']); ?>" class="form-control" placeholder="Taper votre nom ..." required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="email" style="font-weight: bold;">Adresse Email :</label>
                                                <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" class="form-control" placeholder="Taper votre email ..." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gutters">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="telephone" style="font-weight: bold;">Téléphone :</label>
                                                <input type="text" name="telephone" value="<?php echo htmlspecialchars($_SESSION['telephone']); ?>" class="form-control" placeholder="Taper votre numéro de téléphone ..." required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nom_societe" style="font-weight: bold;">Nom de la société :</label>
                                                <input type="text" name="nom_societe" value="<?php echo htmlspecialchars($_SESSION['nom_societe']); ?>" class="form-control" placeholder="Taper le nom de la société ..." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="mp" style="font-weight: bold;">Mot de passe :</label>
                                                <input type="password" id="mp" name="mp" class="form-control" placeholder="Laisser vide si inchangé" />
                                                <div class="progress mt-2">
                                                    <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="text-right">
                                                <button type="submit" name="btnEdit" id="btnEdit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fonction de mise à jour de la barre de progression du mot de passe
    document.getElementById('mp').addEventListener('input', function() {
        var password = this.value;
        var strength = 0;
        if (password.length >= 8) {
            strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/\d/.test(password)) strength += 25;
            if (/[\W_]/.test(password)) strength += 25;
        }
        strength = Math.min(strength, 100);
        var progressBar = document.getElementById('passwordStrength');
        progressBar.style.width = strength + '%';
        progressBar.setAttribute('aria-valuenow', strength);
        if (strength < 50) {
            progressBar.classList.add('bg-danger');
            progressBar.classList.remove('bg-warning', 'bg-success');
        } else if (strength < 75) {
            progressBar.classList.add('bg-warning');
            progressBar.classList.remove('bg-danger', 'bg-success');
        } else {
            progressBar.classList.add('bg-success');
            progressBar.classList.remove('bg-danger', 'bg-warning');
        }
    });
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
                window.location.href = "profile.php";
            }, 2000);
        }
    }
    window.addEventListener('load', handleAlerts);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btnEdit').addEventListener('click', function(event) {
        var confirmation = confirm("Êtes-vous sûr de vouloir modifier ces informations ?");
        if (!confirmation) {
            event.preventDefault();
            location.reload();
        }
    });
});
</script>

<script>
function toggleDropdown() {
    var dropdown = document.getElementById('dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}
function selectOption(option) {
    var selectedOptionElement = document.getElementById('selectedOption');
    if (option === 'Lumière') {
        selectedOptionElement.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
            </svg>
        `;
    } else if (option === 'Sombre') {
        selectedOptionElement.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
            </svg>
        `;
    }
    toggleDropdown();
    changeTheme(option); // Assuming this function changes the theme.
}
function changeTheme(theme) {
    if (theme === 'Sombre') {
        document.body.classList.add('dark-theme');
        document.body.classList.remove('light-theme');
        document.body.style.backgroundColor = '#121212';
        document.body.style.color = '#e0e0e0';
        localStorage.setItem('theme', 'dark'); // Stocke en minuscules
    } else {
        document.body.classList.add('light-theme');
        document.body.classList.remove('dark-theme');
        document.body.style.backgroundColor = '#ffffff';
        document.body.style.color = '#000000';
        localStorage.setItem('theme', 'light'); // Stocke en minuscules
    }
}
// Appliquer le thème stocké lors du chargement de la page
window.addEventListener('load', function() {
    var savedTheme = localStorage.getItem('theme');
    var selectedOptionElement = document.getElementById('selectedOption');

    if (savedTheme === 'dark') {
        selectedOptionElement.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
            </svg>
        `;
        changeTheme('Sombre');
    } else {
        selectedOptionElement.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
            </svg>
        `;
        changeTheme('Lumière');
    }
});
</script>
<script>
    // Charger l'état de la liste au démarrage de la page
    window.onload = function() {
        var list = document.getElementById('notificationList');
        list.style.display = 'none'; // Fermer la liste au chargement de la page
    };
    // Enregistrer l'état de la liste lorsque l'icône est cliquée
    document.getElementById('notificationIcon').addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        var list = document.getElementById('notificationList');
        if (list.style.display === 'none') {
            list.style.display = 'block'; // Ouvre la liste
        } else {
            list.style.display = 'none'; // Ferme la liste
        }
    });
</script>
</body>
</html>