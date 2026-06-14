<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require '../includes/db.php';

$sql = "SELECT * FROM commandes
        ORDER BY id DESC";

$stmt = $pdo->query($sql);

$commandes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">

<title>Commandes</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
    padding:40px;
}

h1{
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#111;
    color:white;
    padding:15px;
}

td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
}

tr:hover{
    background:#f9f9f9;
}

.back{
    display:inline-block;
    margin-bottom:20px;
    padding:12px 20px;
    background:#111;
    color:white;
    text-decoration:none;
    border-radius:8px;
}

</style>

</head>
<body>

<a href="dashboard.php" class="back">
← Dashboard
</a>

<h1>Liste des Commandes</h1>

<table>

<tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Téléphone</th>
    <th>Adresse</th>
    <th>Total</th>  
    <th>Date</th>
    <th>Détails</th>
</tr>

<?php foreach($commandes as $commande): ?>

<tr>

<td><?= $commande['id']; ?></td>

<td><?= htmlspecialchars($commande['nom']); ?></td>

<td><?= htmlspecialchars($commande['telephone']); ?></td>

<td><?= htmlspecialchars($commande['adresse']); ?></td>

<td><?= $commande['total']; ?> DH</td>

<td><?= $commande['date_commande']; ?></td>

<td>

<a
href="details_commande.php?id=<?= $commande['id']; ?>"
style="
background:#2563eb;
color:white;
padding:8px 15px;
border-radius:8px;
text-decoration:none;
">

Voir

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>