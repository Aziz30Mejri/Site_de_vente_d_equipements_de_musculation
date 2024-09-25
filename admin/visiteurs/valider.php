<?php

$idvisiteur = $_GET['id'];

include "../../include/functions.php";
$conn = connect();

$requette = "UPDATE visiteurs SET etat=1 WHERE id='$idvisiteur' ";
$result = $conn->query($requette);
if ($result) {
    header('location:liste.php?valider=ok');
    } else {
        echo "Erreur de validation";
    }


?>