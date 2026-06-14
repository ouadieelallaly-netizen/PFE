<?php

session_start();

require 'includes/db.php';

$cart = $_SESSION['cart'] ?? [];

if(empty($cart)){
    die("Votre panier est vide");
}

$total = 0;

foreach($cart as $piece){

    $total +=
    $piece['prix']
    * $piece['quantite'];
}

if(isset($_POST['valider'])){

    $nom = trim($_POST['nom']);

    $telephone = trim($_POST['telephone']);

    $adresse = trim($_POST['adresse']);

    $sql = "INSERT INTO commandes
    (nom, telephone, adresse, total)

    VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        $nom,

        $telephone,

        $adresse,

        $total
    ]);

    $commande_id = $pdo->lastInsertId();

foreach($cart as $piece){

    $sqlDetail = "
    INSERT INTO commande_details
    (commande_id, piece_id, quantite, prix)

    VALUES (?, ?, ?, ?)";

    $stmtDetail =
    $pdo->prepare($sqlDetail);

    $stmtDetail->execute([

        $commande_id,

        $piece['id'],

        $piece['quantite'],

        $piece['prix']
    ]);
}

    unset($_SESSION['cart']);

    header("Location: merci.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">

<title>Commande</title>

<link rel="stylesheet" href="css/style.css">

</head>
<body>

<section class="pieces">

<h2>Finaliser la commande</h2>

<form method="POST" class="search-form">

<input
type="text"
name="nom"
placeholder="Votre nom"
required>

<input
type="text"
name="telephone"
placeholder="Téléphone"
required>

<input
type="text"
name="adresse"
placeholder="Adresse"
required>

<button
type="submit"
name="valider">

Valider la commande

</button>

</form>

</section>

</body>
</html>