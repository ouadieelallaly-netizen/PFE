<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require '../includes/db.php';

$id = $_GET['id'];

/* récupérer pièce */

$sql = "SELECT * FROM pieces
        WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$piece = $stmt->fetch(PDO::FETCH_ASSOC);

/* catégories */

$sqlCat = "SELECT * FROM categories";

$stmtCat = $pdo->query($sqlCat);

$categories =
$stmtCat->fetchAll();

/* modifier */

if(isset($_POST['modifier'])){

    $categorie_id =
    $_POST['categorie_id'];

    $nom_piece =
    $_POST['nom_piece'];

    $description =
    $_POST['description'];

    $prix =
    $_POST['prix'];

    /* garder image ancienne */

    $imageName =
    $piece['image'];

    /* nouvelle image */

   if(!empty($_FILES['image']['name'])){

    $image = $_FILES['image'];

    $imageName =
    time() . "_" .
    basename($image['name']);

    $tmpName =
    $image['tmp_name'];

    $imageSize =
    $image['size'];

    $imageError =
    $image['error'];

    $allowed = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];

    $imageExt =
    strtolower(
        pathinfo(
            $imageName,
            PATHINFO_EXTENSION
        )
    );

    /* validation */

    if(
        !in_array(
            $imageExt,
            $allowed
        )
    ){
        die("Format image invalide");
    }

    if($imageSize > 5000000){
        die("Image trop grande");
    }

    if($imageError !== 0){
        die("Erreur upload image");
    }

    /* upload */

    move_uploaded_file(
        $tmpName,
        "../uploads/" . $imageName
    );
}

    /* update */

    $sql = "UPDATE pieces
            SET
            categorie_id = ?,
            nom_piece = ?,
            description = ?,
            prix = ?,
            image = ?
            WHERE id = ?";

    $stmt =
    $pdo->prepare($sql);

    $stmt->execute([
        $categorie_id,
        $nom_piece,
        $description,
        $prix,
        $imageName,
        $id
    ]);

    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Pièce</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>

<div class="form-container">

<form method="POST"
      enctype="multipart/form-data">

    <h2>Modifier une pièce</h2>

    <select
        name="categorie_id"
        required>

        <?php foreach($categories as $cat): ?>

        <option
            value="<?= $cat['id']; ?>"

            <?= ($cat['id']
            == $piece['categorie_id'])
            ? 'selected'
            : ''; ?>

        >

            <?= $cat['nom']; ?>

        </option>

        <?php endforeach; ?>

    </select>

    <input
        type="text"
        name="nom_piece"
        value="<?= $piece['nom_piece']; ?>"
        required
    >

    <textarea
        name="description"
        required><?= $piece['description']; ?></textarea>

    <input
        type="number"
        name="prix"
        value="<?= $piece['prix']; ?>"
        required
    >

    <input
        type="file"
        name="image"
    >

    <button
        type="submit"
        name="modifier">

        Modifier

    </button>

    <a
        class="back-btn"
        href="dashboard.php">

        ← Retour Dashboard

    </a>

</form>

</div>

</body>
</html>