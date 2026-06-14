<?php

session_start();
require '../includes/db.php';

$error = "";
$email ="";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];
}
   $sql = "SELECT * FROM admin
        WHERE email = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$email]);

$admin = $stmt->fetch();

if(
    $admin &&
    password_verify(
        $password,
        $admin['password']
    )
){

    $_SESSION['admin'] = $admin['email'];

    header("Location: dashboard.php");
    exit();

} else {

    $error = "Email ou mot de passe incorrect";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="login-page">

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