<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require '../includes/db.php';

/* SEARCH */

$search = "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

/* QUERY */

if(!empty($search)){

    $sql = "SELECT * FROM pieces
            WHERE nom_piece LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "%" . $search . "%"
    ]);

} else {

    $sql = "SELECT * FROM pieces";

    $stmt = $pdo->query($sql);
}

$pieces = $stmt->fetchAll();

/* STATS */

$totalProduits =
count($pieces);

/* catégories */

$sqlCat =
"SELECT COUNT(*) as total
 FROM categories";

$stmtCat =
$pdo->query($sqlCat);

$totalCategories =
$stmtCat->fetch()['total'];

/* dernier produit */

$sqlLast =
"SELECT nom_piece
 FROM pieces
 ORDER BY id DESC
 LIMIT 1";

$stmtLast =
$pdo->query($sqlLast);

$lastProduct =
$stmtLast->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width,
initial-scale=1.0">

<title>Dashboard Admin</title>
<link rel="stylesheet" href="assets/admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="admin-layout">
    <div class="sidebar">

    <h2>AutoParts</h2>

   <ul>

    <li>
        <a href="dashboard.php">
            <i class="fa-solid fa-chart-line"></i>
            Dashboard
        </a>
    </li>

    <li>
        <a href="ajouter.php">
            <i class="fa-solid fa-plus"></i>
            Ajouter Produit
            
        </a>
    </li>
    <li>
        <a
        class="btn"
        style="background:#2563eb;"
        href="commandes.php">

        Commandes

        </a>
        </li>
    <li>
        <a href="../index.php">
            <i class="fa-solid fa-globe"></i>
            Voir Site
        </a>
    </li>

    <li>
        <a href="logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </li>

</ul>

</div>
<div class="container">
<div class="topbar">

    <h1>
        Dashboard Admin
    </h1>

    <div class="actions">

        <a
        class="btn add"
        href="ajouter.php">

        Ajouter Produit

        </a>

        <a
        class="btn logout"
        href="logout.php">

        Logout

        </a>

    </div>

</div>

<!-- SEARCH -->

<form
class="search-form"
method="GET">

<input
type="text"
name="search"
placeholder="Rechercher produit..."
value="<?= $search; ?>">

<button type="submit">
    Rechercher
</button>

</form>

<!-- STATS -->

<div class="stats">

    <div class="card-stat">

        <h3>
            Total Produits
        </h3>

        <h2>
            <?= $totalProduits; ?>
        </h2>

    </div>

    <div class="card-stat">

        <h3>
            Catégories
        </h3>

        <h2>
            <?= $totalCategories; ?>
        </h2>

    </div>

    <div class="card-stat">

        <h3>
            Dernier Produit
        </h3>

        <h2>
            <?= $lastProduct['nom_piece']; ?>
        </h2>

    </div>

</div>

<!-- TABLE -->

<div class="table-container">

<table>

<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Nom</th>
    <th>Prix</th>
    <th>Actions</th>
</tr>

<?php if(empty($pieces)): ?>

<tr>

<td colspan="5"
class="no-result">

Aucun produit trouvé

</td>

</tr>

<?php endif; ?>

<?php foreach($pieces as $piece): ?>

<tr>

<td>
    <?= $piece['id']; ?>
</td>

<td>

<img
class="product-img"
src="../uploads/<?= $piece['image']; ?>"
alt="">

</td>

<td>
    <?= $piece['nom_piece']; ?>
</td>

<td>
    <?= $piece['prix']; ?> DH
</td>

<td>

<a
class="edit"
href="modifier.php?id=<?= $piece['id']; ?>">

Modifier

</a>

<a
class="delete"
href="supprimer.php?id=<?= $piece['id']; ?>"
onclick="return confirm('Voulez-vous supprimer cette pièce ?')">

Supprimer

</a>

</td>

</tr>   

<?php endforeach; ?>

</table>

</div>
</div>
</div>
</body>
</html>