<?php

require 'includes/db.php';

$search = "";

/* SEARCH */

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

/* CATEGORIES */

$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();

$sql = "SELECT * FROM pieces";
$stmt = $pdo->query($sql);
$pieces = $stmt->fetchAll();

/* SEARCH RESULTS */

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pièces Automobiles</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR -->

<header>
    <nav class="navbar">

        <div class="logo">
            AutoParts
        </div>

        <ul class="menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="#categories">Pièces</a></li>
            <li><a href="#footer">Contact</a></li>
            <li><a href="cart.php">Panier</a></li>
            <button id="theme-toggle">🌙</button>
        </ul>
            
    </nav>
    
</header>

<!-- HERO -->

<section class="hero">

    <div class="hero-content">

        <span class="hero-badge">
            Pièces automobiles premium
        </span>

        <h1>
            Trouvez les meilleures pièces automobiles
        </h1>

        <p>
            Pièces neuves et d'occasion
            pour toutes les marques automobiles
        </p>

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="Rechercher une pièce..."
                value="<?= htmlspecialchars($search) ?>"
            >

            <button type="submit">
                Rechercher
            </button>

        </form>

    </div>

</section>

<!-- SEARCH RESULTS -->

<?php if(!empty($search)): ?>

<section class="pieces">

    <h2>Résultats Recherche</h2>

    <div class="cards">

        <?php if(empty($results)): ?>

            <h3 style="color:red;">
                Aucune pièce trouvée
            </h3>

        <?php else: ?>

            <?php foreach($results as $piece): ?>

                <a
                    class="card-link"
                    href="details.php?id=<?= $piece['id']; ?>"
                >

                    <div class="card">

                        <img
                            src="uploads/<?= $piece['image']; ?>"
                            alt="<?= $piece['nom_piece']; ?>"
                        >

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

        <?php endif; ?>

    </div>

</section>


<?php endif; ?>

<!-- CATEGORIES -->

<section class="pieces" id="categories">

    <h2>Nos Catégories</h2>

    <div class="cards">


        <?php foreach($categories as $cat): ?>

            <div class="card">

                <img
                    src="images/<?= $cat['image']; ?>"
                    alt="<?= $cat['nom']; ?>"
                >

                <div class="card-overlay">

                    <h3>
                        <?= $cat['nom']; ?>
                    </h3>

                    <a
                    class="card-btn filter-btn"
                    data-category="<?= $cat['id']; ?>"
                    >
                    Voir les pièces
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>

<section class="pieces">

<h2>Toutes les pièces</h2>

<div class="pieces-grid">

<?php foreach($pieces as $piece): ?>

<div
class="card produit-card"
data-category="<?= $piece['categorie_id']; ?>"
>

<img
src="uploads/<?= $piece['image']; ?>"
alt="">

<div class="card-overlay">

<h3>
<?= $piece['nom_piece']; ?>
</h3>

<p>
<?= $piece['prix']; ?> DH
</p>

<a
href="details.php?id=<?= $piece['id']; ?>"
class="card-btn">

Voir détails

</a>

</div>

</div>

<?php endforeach; ?>

</div>

</section>

<!-- FOOTER -->

<footer class="footer" id="footer">

    <div class="footer-container">

        <div>
            <h3>AutoParts</h3>
            <p>
                Votre spécialiste en pièces
                automobiles neuves et d'occasion.
            </p>
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
            <script src="script.js"></script>
</body>
</html>