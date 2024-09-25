<?php
$idproduit = $_GET['idc'];

include"../../include/functions.php";

$conn = connect();

$requette = "DELETE FROM produits WHERE id = '$idproduit'";
$resultat = $conn->query($requette);
if ($resultat) {
    header('location:liste.php?delete=ok');
}
?>