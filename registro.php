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
$credentialError = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $usuarioDAO = new UsuarioDAO();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = $usuarioDAO->get_usuario_by_email($email);

    if (ISSET($usuario)) {
        $credentialError = "el usuario ya esta registrado en la DB";
    } else if (empty($password) || empty($email)) {
        $credentialError = "el email y pass son obligatorios";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $credentialError = "el email es invalido";
    } else {

        $usuario = new Usuario();
        $usuario->set_mail($email);
        $usuario->set_password($password);

        $usuarioDAO->insertar_usuario($usuario);

        $_SESSION['usuario'] = serialize($usuario);
        go_to_dispo();
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

<h1>Registro</h1>
<br>
<form method="post">
    <label>Email</label>
    <input type="email" name="email">
    <br>
    <label>Password</label>
    <input type="password" name="password">
    <br>
    <button type="submit">Registrarse</button>

    <?php
    if (ISSET($credentialError)) {
        echo "<br>". $credentialError . "<br>";
    }
    ?>

</form>

</body>
</html>