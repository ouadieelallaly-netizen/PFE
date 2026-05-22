<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

require '../includes/db.php';


if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM pieces
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id]);
}

header("Location: dashboard.php");
exit();

?>