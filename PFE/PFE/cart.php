<?php

session_start();

$cart = $_SESSION['cart'] ?? [];

$total = 0;

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">

<title>Mon Panier</title>

<link rel="stylesheet" href="css/style.css">

</head>
<body>

<section class="pieces">

<h2>Mon Panier</h2>

<div class="pieces-grid">

<?php if(empty($cart)): ?>

<h3 style="color:red;">
Votre panier est vide
</h3>

<?php endif; ?>

<?php foreach($cart as $piece): ?>

<?php

$sousTotal =
$piece['prix'] * $piece['quantite'];

$total += $sousTotal;

?>

<div class="card">

<img
src="uploads/<?= $piece['image']; ?>"
alt="">

<div class="card-overlay">

<h3>
<?= $piece['nom_piece']; ?>
</h3>

<p style="color:white;">
Prix : <?= $piece['prix']; ?> DH
</p>

<div class="qty-box">

    <a
    href="update_quantity.php?id=<?= $piece['id']; ?>&action=minus"
    class="qty-btn">

    -

    </a>

    <span>
        <?= $piece['quantite']; ?>
    </span>

    <a
    href="update_quantity.php?id=<?= $piece['id']; ?>&action=plus"
    class="qty-btn">

    +

    </a>

</div>
<p style="color:white;">
Total : <?= $sousTotal; ?> DH
</p>

<a
href="remove_from_cart.php?id=<?= $piece['id']; ?>"
class="delete-cart">

Supprimer

</a>

</div>

</div>

<?php endforeach; ?>

</div>

<h2 style="margin-top:40px;">
Total Général :
<?= $total; ?> DH
</h2>

<br><br>

<a href="checkout.php" class="cart-btn">
    Passer la commande
</a>
</section>

</body>
</html>