<?php

session_start();
require '../includes/db.php';

$error = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin
            WHERE email = ?
            AND password = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $email,
        $password
    ]);

    $admin = $stmt->fetch();

    if($admin){

        $_SESSION['admin'] = $admin['email'];

        header("Location: dashboard.php");
        exit();

    } else {

        $error = "Email ou mot de passe incorrect";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <style>

        body{
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            font-family:Arial;
            background:#f5f5f5;
        }

        form{
            width:350px;
            background:white;
            padding:30px;
            border-radius:10px;
        }

        input{
            width:100%;
            padding:12px;
            margin-bottom:15px;
        }

        button{
            width:100%;
            padding:15px;
            background:#111;
            color:white;
            border:none;
        }

        p{
            color:red;
        }

    </style>

</head>
<body>

<form method="POST">

    <h2>Admin Login</h2>

    <p><?= $error ?></p>

    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <button
        type="submit"
        name="login">

        Login

    </button>

</form> 

</body>
</html>