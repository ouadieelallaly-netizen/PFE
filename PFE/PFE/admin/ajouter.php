<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require '../includes/db.php';

if(isset($_POST['ajouter'])){

    $categorie_id = $_POST['categorie_id'];
    $nom_piece = trim($_POST['nom_piece']);
    $description = trim($_POST['description']);
    $prix = $_POST['prix'];

    /* upload image */

   $image = $_FILES['image'];

$imageName = time() . "_" . basename($image['name']);

$tmpName = $image['tmp_name'];

$imageSize = $image['size'];

$imageError = $image['error'];

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

    /* insert */

    $sql = "INSERT INTO pieces
    (categorie_id, nom_piece, description, prix, image)

    VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $categorie_id,
        $nom_piece,
        $description,
        $prix,
        $imageName
    ]);

    header("Location: dashboard.php");
    exit();
}

/* categories */

$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Pièce</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="form-container">

<form method="POST"
      enctype="multipart/form-data">

    <h2>Ajouter une pièce</h2>

    <select name="categorie_id" required>

        <option value="">
            Choisir catégorie
        </option>

        <?php foreach($categories as $cat): ?>

        <option value="<?= $cat['id']; ?>">
            <?= $cat['nom']; ?>
        </option>

        <?php endforeach; ?>

    </select>

    <input
        type="text"
        name="nom_piece"
        placeholder="Nom de la pièce"
        required
    >

    <textarea
        name="description"
        placeholder="Description"
        required
    ></textarea>

    <input
        type="number"
        name="prix"
        placeholder="Prix"
        required
    >

    <input
        type="file"
        name="image"
        required
    >

    <button
        type="submit"
        name="ajouter">

        Ajouter la pièce

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