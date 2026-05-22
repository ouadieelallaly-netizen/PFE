<?php

require 'includes/db.php';

if(!isset($_GET['id'])){
    header("Location: index00.php");
    exit();
}

$id = $_GET['id'];

/* récupérer produit */

$sql = "SELECT * FROM pieces
        WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$piece = $stmt->fetch();

if(!$piece){
    echo "Produit introuvable";
    exit();
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

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#f5f5f5;
        }

        .container{
            max-width:1200px;
            margin:50px auto;
            background:white;
            border-radius:25px;
            overflow:hidden;
            box-shadow:0 10px 40px rgba(0,0,0,0.15);
            display:flex;
            flex-wrap:wrap;
        }

        .image-box{
            flex:1;
            min-width:350px;
            background:#fafafa;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:40px;
        }

        .image-box img{
            width:100%;
            max-width:500px;
            border-radius:20px;
            transition:0.4s;
        }

        .image-box img:hover{
            transform:scale(1.05);
        }

        .content{
            flex:1;
            min-width:350px;
            padding:50px;
        }

        .badge{
            display:inline-block;
            background:red;
            color:white;
            padding:8px 16px;
            border-radius:30px;
            font-size:14px;
            margin-bottom:20px;
        }

        .content h1{
            font-size:42px;
            margin-bottom:20px;
            color:#111;
        }

        .description{
            color:#666;
            line-height:1.8;
            font-size:18px;
            margin-bottom:30px;
        }

        .price{
            font-size:40px;
            color:red;
            font-weight:bold;
            margin-bottom:30px;
        }

        .buttons{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .btn{
            padding:15px 30px;
            border:none;
            border-radius:12px;
            text-decoration:none;
            font-size:18px;
            font-weight:bold;
            transition:0.3s;
        }

        .btn-contact{
            background:red;
            color:white;
        }

        .btn-contact:hover{
            background:#cc0000;
        }

        .btn-back{
            background:#111;
            color:white;
        }

        .btn-back:hover{
            background:#333;
        }

        @media(max-width:768px){

            .container{
                flex-direction:column;
                margin:20px;
            }

            .content{
                padding:30px;
            }

            .content h1{
                font-size:32px;
            }

        }

    </style>

</head>
<body>

<div class="container">

    <div class="image-box">

        <img
        src="uploads/<?= $piece['image']; ?>"
        alt="">

    </div>

    <div class="content">

        <span class="badge">
            Pièce Automobile
        </span>

        <h1>
            <?= $piece['nom_piece']; ?>
        </h1>

        <p class="description">
            <?= $piece['description']; ?>
        </p>

        <div class="price">
            <?= $piece['prix']; ?> DH
        </div>

        <div class="buttons">

            <a
            href="https://wa.me/212600000000"
            class="btn btn-contact">

                Contacter WhatsApp

            </a>

            <a
            href="javascript:history.back()"
            class="btn btn-back">

                Retour

            </a>

        </div>

    </div>

</div>

</body>
</html>