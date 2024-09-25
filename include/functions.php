<?php
function connect(){
  $servername = "localhost";
  $username = "root";
  $password = "";
  try {
    $conn = new PDO("mysql:host=$servername;dbname=ecommerce", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  return $conn;
}

function getAllCategories(){
  $conn = connect();
  //2- creation de la requette
  $requette = "SELECT * FROM categories";
  //3- execution de la requette
  $resultat = $conn->query($requette);
  //4- resultat de la requette
  $categories = $resultat->fetchAll();
  //var_dump($categories);
  return $categories;
}

function getAllProduits(){
  $conn = connect();
  $requette = "SELECT * FROM produits ORDER BY RAND()";
  $resultat = $conn->query($requette);
  $produits = $resultat->fetchAll();
  return $produits;
}

function searchProduits($keywords){
  $conn = connect();
  $requete = "SELECT * FROM produits WHERE nom LIKE :keywords";
  $stmt = $conn->prepare($requete);
  $stmt->execute(['keywords' => '%' . $keywords . '%']);
  $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $produits;
}

function getProduitById($id){
  $conn = connect();
  $requete = "SELECT * FROM produits WHERE id = :id";
  $stmt = $conn->prepare($requete);
  $stmt->execute(['id' => $id]);
  $produit = $stmt->fetch(PDO::FETCH_ASSOC);
  return $produit;
}

function AddVisiteur($data) {
  $conn = connect();
  $mpHash = password_hash($data['mp'], PASSWORD_DEFAULT);
  $requette = "INSERT INTO visiteurs (nom, prenom, email, mp, telephone) 
               VALUES (:nom, :prenom, :email, :mp, :telephone)";
  $stmt = $conn->prepare($requette);
  $stmt->bindParam(':nom', $data['nom']);
  $stmt->bindParam(':prenom', $data['prenom']);
  $stmt->bindParam(':email', $data['email']);
  $stmt->bindParam(':mp', $mpHash);
  $stmt->bindParam(':telephone', $data['telephone']);
  $resultat = $stmt->execute();
  if($resultat) {
      return true;
  } else {
      return false;
  }
}

function ConnectVisiteur($data) {
  $conn = connect();
  $email = $data['email'];
  $requette = "SELECT * FROM visiteurs WHERE email = :email";
  $stmt = $conn->prepare($requette);
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user && password_verify($data['mp'], $user['mp'])) {
      return $user;
  } else {
      return false;
  }
}

function ConnectAdmin($data) {
  $conn = connect();
  $email = $data['email'];
  $mp = md5($data['mp']);
  $requete = "SELECT * FROM administrateur WHERE email = :email AND mp = :mp";
  $stmt = $conn->prepare($requete);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':mp', $mp);
  $stmt->execute();
  $user = $stmt->fetch();
  return $user;
}

function getAllUsers(){
  $conn = connect();
  $requette = "SELECT * FROM visiteurs WHERE etat=0";
  $resultat = $conn->query($requette);
  $users = $resultat->fetchAll();
  return $users; 
}

function getStocks(){
  $conn = connect();
  $requette = "SELECT s.id, p.nom, s.quantite FROM produits p, stocks s WHERE p.id = s.produit";
  $resultat = $conn->query($requette);
  $stocks = $resultat->fetchAll();
  return $stocks; 
}

function updateStockQuantity($id, $quantity) {
  global $db;
  $query = $db->prepare("UPDATE stocks SET quantite = ? WHERE id = ?");
  $query->execute([$quantity, $id]);
}

function getAllPaniers(){
  $conn = connect();
  $requette = "SELECT v.nom, v.prenom, v.telephone, p.total, p.etat, p.date_creation, p.id FROM panier p, visiteurs v WHERE p.visiteur = v.id ORDER BY p.date_creation DESC ";
  $resultat = $conn->query($requette);
  $paniers = $resultat->fetchAll();
  return $paniers; 
}

function getAllPaniersParPage($page, $paniersParPage){
  $conn = connect();  
  $offset = ($page - 1) * $paniersParPage;  
  $requette = "SELECT v.nom, v.prenom, v.telephone, p.total, p.etat, p.date_creation, p.id 
               FROM panier p, visiteurs v WHERE p.visiteur = v.id ORDER BY p.date_creation DESC LIMIT :offset, :paniersParPage";
  $stmt = $conn->prepare($requette);
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindValue(':paniersParPage', $paniersParPage, PDO::PARAM_INT);
  $stmt->execute();
  $users = $stmt->fetchAll();  
  return $users;
}

function getAllCommandes(){
  $conn = connect();
  $requette = "SELECT p.nom, p.image, c.quantite, c.total, p.prix, c.panier FROM commandes c, produits p
  WHERE c.produit = p.id ";
  $resultat = $conn->query($requette);
  $commandes = $resultat->fetchAll();
  return $commandes; 
}

function changerEtatPanier($data) {
  try {
      $conn = connect();
      $date_modification = date('Y-m-d');
      $etat = $data['etat'];
      $panier_id = $data['panier_id'];
      // Mise à jour de l'état du panier
      $requette = "UPDATE panier SET etat = :etat, date_modification = :date_modification WHERE id = :panier_id";
      $stmt = $conn->prepare($requette);
      $stmt->bindParam(':etat', $etat);
      $stmt->bindParam(':date_modification', $date_modification);
      $stmt->bindParam(':panier_id', $panier_id, PDO::PARAM_INT);
      $stmt->execute();
      if ($etat === 'livraison terminée') {
          // Récupérer les commandes associées au panier
          $requette_commandes = "SELECT produit, quantite FROM commandes WHERE panier = :panier_id";
          $stmt_commandes = $conn->prepare($requette_commandes);
          $stmt_commandes->bindParam(':panier_id', $panier_id, PDO::PARAM_INT);
          $stmt_commandes->execute();
          $commandes = $stmt_commandes->fetchAll(PDO::FETCH_ASSOC);
          // Mettre à jour les quantités dans la table stocks
          foreach ($commandes as $commande) {
              $requette_stock = "UPDATE stocks SET quantite = quantite - :quantite WHERE produit = :produit";
              $stmt_stock = $conn->prepare($requette_stock);
              $stmt_stock->bindParam(':quantite', $commande['quantite'], PDO::PARAM_INT);
              $stmt_stock->bindParam(':produit', $commande['produit'], PDO::PARAM_INT);
              $stmt_stock->execute();
          }
      }
      // Redirection après mise à jour
      if ($stmt->rowCount() > 0) {
          header('Location: liste.php?modif=ok');
          exit();
      } else {
          header('Location: liste.php?modif=not_found');
          exit();
      }
  } catch (PDOException $e) {
      die("Erreur lors de la modification des données : " . $e->getMessage());
  }
}

function getPaniersByEtat($paniers, $etat) {
  $paniersEtat = array();
  foreach ($paniers as $p) {
    if ($p['etat'] == $etat) {
      array_push($paniersEtat,$p);
    }
  }
  return $paniersEtat;
}

function EditAdmin($data) {
  $conn = connect();
  $nom_societe = isset($data['nom_societe']) ? $data['nom_societe'] : '';
  if (!empty($data['mp'])) {
    $query = "UPDATE administrateur SET nom = :nom, email = :email, telephone = :telephone, nom_societe = :nom_societe, mp = :mp WHERE id = :id";
  } else {
    $query = "UPDATE administrateur SET nom = :nom, email = :email, telephone = :telephone, nom_societe = :nom_societe WHERE id = :id";
  }
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':nom', $data['nom']);
  $stmt->bindParam(':email', $data['email']);
  $stmt->bindParam(':telephone', $data['telephone']);
  $stmt->bindParam(':nom_societe', $nom_societe);
  $stmt->bindParam(':id', $data['id_admin'], PDO::PARAM_INT);
  if (!empty($data['mp'])) {
    $hashedPassword = md5($data['mp']);
    $stmt->bindParam(':mp', $hashedPassword);
  }
  echo $query;
  $result = $stmt->execute();
  if (!$result) {
      print_r($stmt->errorInfo());
  }
  //return $result;
  if ($result) {
    header('Location: profile.php?modif=ok');
    exit();
  } else {
    die("Erreur lors de la modification des données.");
  }
}

function getAdminById($id) {
  $conn = connect();
  $stmt = $conn->prepare("SELECT * FROM administrateur WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getNomSociete() {
  $conn = connect();
  $stmt = $conn->prepare("SELECT nom_societe FROM administrateur LIMIT 1");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result['nom_societe'];
}

function getData(){
  $data = array();
  $conn = connect();
  // Calculer le nombre des produits dans la base:
  $requette = "SELECT COUNT(*) FROM produits";
  $resultat = $conn->query($requette);
  $nbrProduits = $resultat->fetch();
  // Calculer le nombre des categories dans la base:
  $requette1 = "SELECT COUNT(*) FROM categories";
  $resultat1 = $conn->query($requette1);
  $nbrCategories = $resultat1->fetch();
  // Calculer le nombre des visiteurs dans la base:
  $requette2 = "SELECT COUNT(*) FROM visiteurs WHERE etat=1";
  $resultat2 = $conn->query($requette2);
  $nbrVisiteurs = $resultat2->fetch();

  // Calculer le nombre des commandes dans la base:
  $requette3 = "SELECT COUNT(*) FROM commandes";
  $resultat3 = $conn->query($requette3);
  $nbrCommandes = $resultat3->fetch();

  // Calculer gains (annuels):
  $requette4 = "SELECT SUM(total) AS total_sum FROM panier WHERE etat = 'livraison terminée'";
  $resultat4 = $conn->query($requette4);
  $nbrGains = $resultat4->fetch();

  // Calculer le nombre des demandes des visiteurs:
  $requette5 = "SELECT COUNT(*) FROM visiteurs WHERE etat=0";
  $resultat5 = $conn->query($requette5);
  $nbrDemandes = $resultat5->fetch();

  // Calculer le nombre des produits vendus:
  $requette6 = "SELECT COUNT(quantite) FROM commandes, panier WHERE etat = 'livraison terminée'";
  $resultat6 = $conn->query($requette6);
  $nbrPdtVendus = $resultat6->fetch();

  $data["produits"] = $nbrProduits[0];
  $data["categories"] = $nbrCategories[0];
  $data["clients"] = $nbrVisiteurs[0];
  $data["commandes"] = $nbrCommandes[0];
  $data["gains"] = $nbrGains[0];
  $data["demande"] = $nbrDemandes[0];
  $data["pdtvendus"] = $nbrPdtVendus[0];
  return $data;
}

function getCategorieById($id) {
  $conn = connect();
  $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch();
}

function getVentesMensuelles() {
  $conn = connect();
  $sql = "SELECT DATE_FORMAT(date_modification, '%Y-%m') AS mois, SUM(total) AS total_ventes FROM panier
          WHERE etat = 'livraison terminée' GROUP BY mois ORDER BY mois ASC";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // Créer une liste de tous les mois de l'année en cours
  $mois = [];
  $totaux = [];
  $currentYear = date('Y');
  for ($i = 1; $i <= 12; $i++) {
      $month = sprintf('%04d-%02d', $currentYear, $i);
      $mois[] = $month;
      $totaux[] = 0; // Initialiser les totaux à 0
  }
  // Remplir les données avec les résultats de la requête
  foreach ($result as $row) {
      $index = array_search($row['mois'], $mois);
      if ($index !== false) {
          $totaux[$index] = $row['total_ventes'];
      }
  }
  return ['mois' => $mois, 'totaux' => $totaux];
}

function getProduitsByCategorie($categorieId) {
  $conn = connect();
  $sql = "SELECT * FROM produits WHERE categorie = :categorieId";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':categorieId', $categorieId, PDO::PARAM_INT);
  $stmt->execute();
  // Récupérer les produits
  $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $produits; // Retourne un tableau des produits
}

function getProduitsParPage($page = 1, $produitsParPage = 7) {
  $conn = connect();
  // Calculer l'offset pour la pagination
  $offset = ($page - 1) * $produitsParPage;
  // Créer la requête SQL avec LIMIT et OFFSET
  $requette = "SELECT * FROM produits LIMIT :offset, :limit";
  $stmt = $conn->prepare($requette);
  $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindParam(':limit', $produitsParPage, PDO::PARAM_INT);
  $stmt->execute();
  $produits = $stmt->fetchAll();
  return $produits;
}

function getStocksParPage($page = 1, $stocksParPage = 7) {
  $conn = connect();
  $offset = ($page - 1) * $stocksParPage;
  $requette = "SELECT s.id, p.nom, s.quantite FROM produits p, stocks s WHERE p.id = s.produit LIMIT :offset, :limit";
  $stmt = $conn->prepare($requette);
  $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindParam(':limit', $stocksParPage, PDO::PARAM_INT);
  $stmt->execute();
  $stocks = $stmt->fetchAll();
  return $stocks;
}

function getAllUsersParPage($page, $visiteursParPage){
  $conn = connect();  
  $offset = ($page - 1) * $visiteursParPage;
  $requette = "SELECT * FROM visiteurs WHERE etat=0 LIMIT :offset, :visiteursParPage";
  $stmt = $conn->prepare($requette);
  $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindParam(':visiteursParPage', $visiteursParPage, PDO::PARAM_INT);
  $stmt->execute();
  $users = $stmt->fetchAll();  
  return $users;
}

function getVisiteurInfo($visiteurId) {
    try {
      $conn = connect();
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // Récupération des informations du visiteur
      $query = "SELECT nom, prenom, telephone FROM visiteurs WHERE id = :id";
      $stmt = $conn->prepare($query);
      $stmt->bindValue(':id', $visiteurId, PDO::PARAM_INT);
      $stmt->execute();
      $visiteur = $stmt->fetch(PDO::FETCH_ASSOC);

      return $visiteur ?: null; // Retourner null si aucun résultat
  } catch (PDOException $e) {
      die("Erreur de connexion : " . $e->getMessage());
  }
}

function getTotalNotifications() {
  $conn = connect();
  // 1. Obtenir le nombre de produits avec quantité zéro
  $requeteProduits = "SELECT COUNT(*) as total FROM stocks WHERE quantite = 0";
  $resultatProduits = $conn->query($requeteProduits);
  $produitsZeroQuantite = $resultatProduits->fetch();
  $totalProduitsZero = $produitsZeroQuantite['total'];
  // 2. Obtenir le nombre de commandes en cours (requête corrigée)
  $requeteCommandes = "SELECT COUNT(p.id) as total FROM panier p WHERE p.etat = 'en cours'";
  $resultatCommandes = $conn->query($requeteCommandes);
  $commandesEnCours = $resultatCommandes->fetch();
  $totalCommandesEnCours = $commandesEnCours['total'];
  // 3. Obtenir le nombre de demandes de visiteurs en attente
  $requeteDemandes = "SELECT COUNT(*) as total FROM visiteurs WHERE etat = 0";
  $resultatDemandes = $conn->query($requeteDemandes);
  $demandesVisiteurs = $resultatDemandes->fetch();
  $totalDemandes = $demandesVisiteurs['total'];
  // 4. Calculer le total des notifications
  $totalNotifications = $totalProduitsZero + $totalCommandesEnCours + $totalDemandes;
  return $totalNotifications;
}

?>