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

        $imageName =
        $_FILES['image']['name'];

        $tmpName =
        $_FILES['image']['tmp_name'];

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

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#f4f4f4;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
        }

        .form-container{
            width:100%;
            max-width:600px;
        }

        form{
            background:white;
            padding:40px;
            border-radius:20px;
            box-shadow:
            0 10px 30px
            rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:30px;
        }

        input,
        textarea,
        select{
            width:100%;
            padding:15px;
            margin-bottom:20px;
            border:1px solid #ddd;
            border-radius:10px;
        }

        textarea{
            resize:none;
            height:120px;
        }

        button{
            width:100%;
            padding:15px;
            border:none;
            border-radius:10px;
            background:red;
            color:white;
            cursor:pointer;
        }

        .back-btn{
            display:block;
            text-align:center;
            margin-top:20px;
            text-decoration:none;
            color:black;
        }

    </style>

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