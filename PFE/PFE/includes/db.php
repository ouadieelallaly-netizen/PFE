<?php

$host = "localhost";
$dbname = "pieces_auto";
$user = "root";
$password = "wadie@2006";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch(PDOException $e){

    die("Erreur connexion : "
        . $e->getMessage());
}