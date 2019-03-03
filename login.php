<?php

require "utils.php";
require_once("dao/UsuarioDAO.php");
require_once("modelo/Usuario.php");

function go_to_dispo() {
    header("Location: disponibilidad.php");
    die();
}

if (is_logged()) {
    go_to_dispo();
}

$email = $password = null;
$credentialError= false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $usuarioDAO = new UsuarioDAO();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = $usuarioDAO->get_usuario_by_email($email);

    if (ISSET($usuario) && $usuario->get_password() == $password) {
        $_SESSION['usuario'] = serialize($usuario);
        go_to_dispo();
    } else {
        header("Location: registro.php");
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<h1>Login</h1>
<br>
<form method="post">
    <label>Email</label>
    <input type="email" name="email">
    <br>
    <label>Password</label>
    <input type="password" name="password">
    <br>
    <button type="submit">Login</button>
</form>

</body>
</html>