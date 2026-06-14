<?php

session_start();

require 'includes/db.php';

$id = (int) $_GET['id'];

/* créer panier */

if(!isset($_SESSION['cart'])){

    $_SESSION['cart'] = [];
}

/* produit déjà dans panier ? */

if(isset($_SESSION['cart'][$id])){

    $_SESSION['cart'][$id]['quantite']++;

} else {

    $sql = "SELECT * FROM pieces
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id]);

    $piece = $stmt->fetch(PDO::FETCH_ASSOC);

    if($piece){

        $_SESSION['cart'][$id] = [

            'id' => $piece['id'],

            'nom_piece' => $piece['nom_piece'],

            'prix' => $piece['prix'],

            'image' => $piece['image'],

            'quantite' => 1
        ];
    }
}

header("Location: cart.php");
exit();

?>