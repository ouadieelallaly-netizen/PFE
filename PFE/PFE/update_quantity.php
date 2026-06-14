<?php

session_start();

if(isset($_GET['id']) && isset($_GET['action'])){

    $id = (int) $_GET['id'];

    $action = $_GET['action'];

    if(isset($_SESSION['cart'][$id])){

        if($action == "plus"){

            $_SESSION['cart'][$id]['quantite']++;

        }

        if($action == "minus"){

            $_SESSION['cart'][$id]['quantite']--;

            if($_SESSION['cart'][$id]['quantite'] <= 0){

                unset($_SESSION['cart'][$id]);
            }
        }
    }
}

header("Location: cart.php");
exit();

?>