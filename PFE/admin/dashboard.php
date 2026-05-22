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

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f4f4f4;
    padding:40px;
}

/* HEADER */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:20px;
}

.topbar h1{
    font-size:50px;
}

/* BUTTONS */

.actions{
    display:flex;
    gap:15px;
}

.btn{
    padding:15px 25px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    font-weight:bold;
}

.add{
    background:green;
}

.logout{
    background:red;
}

/* SEARCH */

.search-form{
    display:flex;
    gap:10px;
    margin-bottom:30px;
}

.search-form input{
    flex:1;
    padding:15px;
    border:none;
    border-radius:10px;
    font-size:16px;
    box-shadow:
    0 5px 15px
    rgba(0,0,0,0.1);
}

.search-form button{
    padding:15px 25px;
    border:none;
    border-radius:10px;
    background:#111;
    color:white;
    cursor:pointer;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.card-stat{
    background:white;
    border-radius:20px;
    padding:30px;
    box-shadow:
    0 10px 25px
    rgba(0,0,0,0.1);
}

.card-stat h3{
    color:#777;
    margin-bottom:10px;
}

.card-stat h2{
    font-size:35px;
}

/* TABLE */

.table-container{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:
    0 10px 25px
    rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#111;
    color:white;
    padding:20px;
}

td{
    padding:20px;
    text-align:center;
    border-bottom:
    1px solid #eee;
}

tr:hover{
    background:#f9f9f9;
}

.product-img{
    width:90px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
}

.edit{
    background:orange;
    color:white;
    padding:10px 15px;
    text-decoration:none;
    border-radius:8px;
    margin-right:10px;
}

.delete{
    background:red;
    color:white;
    padding:10px 15px;
    text-decoration:none;
    border-radius:8px;
}

.no-result{
    text-align:center;
    color:red;
    margin:20px 0;
    font-size:22px;
}

</style>

</head>
<body>

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

</body>
</html>