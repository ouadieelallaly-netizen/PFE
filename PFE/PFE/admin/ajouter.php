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

    $imageName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

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
</head>
<body>
    <style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
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
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

form h2{
    text-align:center;
    margin-bottom:30px;
    font-size:35px;
    color:#111;
}

input,
textarea,
select{
    width:100%;
    padding:15px;
    margin-bottom:20px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:16px;
    outline:none;
    transition:0.3s;
}

input:focus,
textarea:focus,
select:focus{
    border-color:red;
    box-shadow:0 0 10px rgba(255,0,0,0.2);
}

textarea{
    resize:none;
    height:120px;
}

input[type="file"]{
    border:none;
}

button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:12px;
    background:red;
    color:white;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#cc0000;
    transform:translateY(-2px);
}

.back-btn{
    display:block;
    text-align:center;
    margin-top:20px;
    text-decoration:none;
    color:#111;
    font-weight:bold;
}

</style>

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