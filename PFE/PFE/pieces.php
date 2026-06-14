<?php

require 'includes/db.php';

$categorie_id = $_GET['id'];

$search = "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

if(!empty($search)){

    $sql = "SELECT * FROM pieces
            WHERE categorie_id = ?
            AND nom_piece LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $categorie_id,
        "%" . $search . "%"
    ]);

} else {

    $sql = "SELECT * FROM pieces
            WHERE categorie_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categorie_id]);
}

$pieces = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pièces</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="pieces-page">

<!-- NAVBAR -->

<header>
    <nav class="navbar">

        <div class="logo">
            AutoParts
        </div>

        <ul class="menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="#">Pièces</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="cart.php">Panier</a></li>
        </ul>

    </nav>
</header>

<section class="pieces">

    <h2>Pièces Disponibles</h2>

    <!-- SEARCH -->

    <form method="GET" class="search-form">

        <input
            type="hidden"
            name="id"
            value="<?= $categorie_id; ?>"
        >

        <input
            type="text"
            name="search"
            placeholder="Rechercher une pièce..."
            value="<?= $search; ?>"
        >

        <button type="submit">
            Rechercher
        </button>

    </form>

    <!-- CARDS -->

    <div class="pieces-grid">

        <?php if(empty($pieces)): ?>

            <h3 style="color:red;">
                Aucune pièce trouvée
            </h3>

        <?php endif; ?>

        <?php foreach($pieces as $piece): ?>

        <a
        class="card-link"
        href="details.php?id=<?= $piece['id']; ?>">

            <div class="card">

                <img
                src="uploads/<?= $piece['image']; ?>"
                alt="">

                <div class="card-overlay">

                    <h3>
                        <?= $piece['nom_piece']; ?>
                    </h3>

                    <p style="color:white;">
                        <?= $piece['prix']; ?> DH
                    </p>

                    <span class="card-btn">
                        Voir détails
                    </span>

                </div>

            </div>

        </a>

        <?php endforeach; ?>

    </div>

</section>

<footer class="footer">

    <div class="footer-container">

        <div>
            <h3>AutoParts</h3>
            <p>
                Votre spécialiste en pièces
                automobiles neuves et
                d'occasion.
            </p>
        </div>

        <div>
            <h3>Contact</h3>
            <p>📞 +212 6 00 00 00 00</p>
            <p>📧 autoparts@gmail.com</p>
            <p>📍 Tanger, Maroc</p>
        </div>

    </div>

    <hr>

    <p class="copyright">
        © 2026 AutoParts
    </p>

</footer>

</body>
</html>