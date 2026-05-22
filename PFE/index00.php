<?php

require 'includes/db.php';

$search = "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

/* categories */
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();

/* produits recherchés */
$results = [];

if(!empty($search)){

    $sql = "SELECT * FROM pieces
            WHERE nom_piece LIKE ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "%" . $search . "%"
    ]);

    $results = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pièces Automobiles</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navbar">

        <div class="logo">
            AutoParts
        </div>

        <ul class="menu">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Pièces</a></li>
            <li><a href="#">Contact</a></li>
        </ul>

    </nav>
</header>

<section class="hero">

    <div class="hero-content">

        <h1>
            Trouvez les meilleures pièces automobiles
        </h1>

        <p>
            Pièces neuves et d'occasion
            pour toutes les marques
        </p>

        <form method="GET">

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

    </div>

</section>


<!-- Résultats de recherche -->
<?php if(!empty($search)): ?>

<section class="pieces">

    <h2>Résultats Recherche</h2>

    <div class="cards">

        <?php if(count($results) > 0): ?>

            <?php foreach($results as $piece): ?>

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

        <?php else: ?>

            <p>
                Aucun produit trouvé.
            </p>

        <?php endif; ?>

    </div>

</section>

<?php endif; ?>


<!-- Catégories -->
<section class="pieces">

    <h2>Nos Catégories</h2>

    <div class="cards">

        <?php foreach($categories as $cat): ?>

        <div class="card">

            <img
            src="images/<?= $cat['image']; ?>"
            alt="<?= $cat['nom']; ?>">

            <div class="card-overlay">

                <h3>
                    <?= $cat['nom']; ?>
                </h3>

                <a
                href="pieces.php?id=<?= $cat['id']; ?>"
                class="card-btn">

                    Voir les pièces

                </a>

            </div>

        </div>

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
<div class="info-box">
    <p><strong>Disponibilité :</strong> En stock</p>
    <p><strong>Livraison :</strong> Partout au Maroc</p>
    <p><strong>Qualité :</strong> Garantie</p>
</div>

        <div>
            <h3>Contact</h3>
            <p>📞 +212 6 00 00 00 00</p>
            <p>📧 autoparts@gmail.com</p>
            <p>📍 Tanger, Maroc</p>
        </div>

        <div>
            <h3>Liens Rapides</h3>
            <p>Accueil</p>
            <p>Pièces</p>
            <p>Contact</p>
        </div>

    </div>

    

    <hr>

    <p class="copyright">
        © 2026 AutoParts - Tous droits réservés
    </p>

</footer>

</body>
</html>