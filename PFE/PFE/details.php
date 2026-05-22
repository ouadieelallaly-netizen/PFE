<?php

require 'includes/db.php';

if(!isset($_GET['id'])){
    die("Produit introuvable");
}

$id = $_GET['id'];

$sql = "SELECT * FROM pieces WHERE id = ?";

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
        <?= $piece['nom_piece']; ?>
    </title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="details-container">

    <div class="details-card">

        <div class="details-image">

            <img
                src="uploads/<?= $piece['image']; ?>"
                alt=""
            >

        </div>

        <div class="details-content">

            <h1>
                <?= $piece['nom_piece']; ?>
            </h1>

            <p>
                <?= $piece['description']; ?>
            </p>

            <h2>
                <?= $piece['prix']; ?> DH
            </h2>

            <a href="javascript:history.back()">

                <button>
                    Retour
                </button>

            </a>

        </div>

    </div>

</div>

</body>
</html>