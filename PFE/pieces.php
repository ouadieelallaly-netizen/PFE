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

    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="pieces">

    <h2>Pièces Disponibles</h2>
    <form method="GET">

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

    <div class="cards">

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

                <p style="color:white; margin-bottom:10px;">
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

</body>
</html>