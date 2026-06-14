<?php

require 'includes/db.php';

/* vérifier id */

if(
    !isset($_GET['id']) ||
    !is_numeric($_GET['id'])
){
    die("Produit introuvable");
}

$id = (int) $_GET['id'];

/* récupérer produit */

$sql = "SELECT * FROM pieces
        WHERE id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$id]);

$piece = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$piece){
    die("Produit introuvable");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($piece['nom_piece']); ?>
    </title>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>


<div class="details-container">

    <div class="details-card">

        <!-- IMAGE -->

        <div class="details-image">

            <img
                src="uploads/<?= htmlspecialchars($piece['image']); ?>"
                alt="<?= htmlspecialchars($piece['nom_piece']); ?>"
            >

        </div>

        <!-- CONTENT -->

        <div class="details-content">

            <h1>
                <?= htmlspecialchars($piece['nom_piece']); ?>
            </h1>

            <p>
                <?= htmlspecialchars($piece['description']); ?>
            </p>

            <h2>
                <?= htmlspecialchars($piece['prix']); ?> DH
            </h2>
                <a
                class="cart-btn"
                href="add_to_cart.php?id=<?= $piece['id']; ?>">

        Ajouter au panierb

        </a>
        <br>
            <a
               class="back-link"
               href="javascript:history.back()">

                <button>
                    Retour
                </button>

            </a>

        </div>

    </div>

</div>


</body>
</html>