<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require '../includes/db.php';

$id = $_GET['id'];

/* commande */

$sql = "
SELECT *
FROM commandes
WHERE id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$commande = $stmt->fetch();

/* produits */

$sql = "

SELECT

commande_details.*,

pieces.nom_piece,

pieces.image

FROM commande_details

INNER JOIN pieces

ON pieces.id = commande_details.piece_id

WHERE commande_details.commande_id = ?

";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$produits = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">

<title>Détails Commande</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
    padding:40px;
}

.container{
    max-width:1100px;
    margin:auto;
}

h1{
    margin-bottom:20px;
}

.info{
    background:white;
    padding:20px;
    border-radius:15px;
    margin-bottom:30px;
}

.card{
    display:flex;
    align-items:center;
    gap:20px;

    background:white;

    padding:20px;

    border-radius:15px;

    margin-bottom:20px;
}

.card img{

    width:120px;

    height:90px;

    object-fit:cover;

    border-radius:10px;
}

.back{

    display:inline-block;

    margin-bottom:20px;

    padding:12px 20px;

    background:#111;

    color:white;

    text-decoration:none;

    border-radius:10px;
}

</style>

</head>
<body>

<div class="container">

<a
href="commandes.php"
class="back">

← Retour

</a>

<h1>
Commande #<?= $commande['id']; ?>
</h1>

<div class="info">

<p>
<b>Client :</b>
<?= $commande['nom']; ?>
</p>

<p>
<b>Téléphone :</b>
<?= $commande['telephone']; ?>
</p>

<p>
<b>Adresse :</b>
<?= $commande['adresse']; ?>
</p>

<p>
<b>Total :</b>
<?= $commande['total']; ?> DH
</p>

</div>

<h2>
Produits commandés
</h2>

<?php foreach($produits as $produit): ?>

<div class="card">

<img
src="../uploads/<?= $produit['image']; ?>"
alt="">

<div>

<h3>
<?= $produit['nom_piece']; ?>
</h3>

<p>
Quantité :
<?= $produit['quantite']; ?>
</p>

<p>
Prix :
<?= $produit['prix']; ?> DH
</p>

</div>

</div>

<?php endforeach; ?>

</div>

</body>
</html>