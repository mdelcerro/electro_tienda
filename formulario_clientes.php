<?php

require "utils.php";
require_once("dao/ClienteDAO.php");
require_once("dao/CompraDAO.php");
require_once("modelo/Cliente.php");

if (!ISSET($_SESSION['carrito'])) {
    header("Location: disponibilidad.php");
    die();
}

$compra = unserialize($_SESSION['carrito']);
$nombre = $apellidos = $dni = $telefono = $direccion = $profesion = $email = null;
$nombreError = $apellidosError = $dniError = $telefonoError = $direccionError = $emailError = $emailInvalido = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $clienteDAO = new ClienteDAO();
    $compraDAO = new CompraDAO();
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $profesion = $_POST['profesion'] ?? '';
    $email = $_POST['email'] ?? '';
    $error = false;

    if (empty($nombre)) {
        $nombreError = "El nombre es un campo obligatorio";
        $error = true;
    }
    if (empty($apellidos)) {
        $apellidosError = "Apellidos es un campo obligatorio";
        $error = true;
    }
    if (empty($dni)) {
        $dniError = "DNI es un campo obligatorio";
        $error = true;
    }
    if (empty($telefono)) {
        $telefonoError = "Teléfono es un campo obligatorio";
        $error = true;
    }
    if (empty($direccion)) {
        $direccionError = "Dirección es un campo obligatorio";
        $error = true;
    }
    if (empty($email)) {
        $emailError = "Email es un campo obligatorio";
        $error = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailInvalido = "El email no es válido";
        $error = true;
    }

    if (!$error) {

        $cliente = new Cliente();
        $cliente->set_nombre($nombre);
        $cliente->set_apellidos($apellidos);
        $cliente->set_telefono($telefono);
        $cliente->set_direccion($direccion);
        $cliente->set_profesion($profesion);
        $cliente->set_profesion($profesion);
        $cliente->set_dni($dni);
        $cliente->set_email($email);


        $clienteDAO->insertar_cliente($cliente);
        $compra->set_cliente($cliente);

        $compraDAO->insertar_compra($compra);

        $_SESSION['carrito'] = serialize($compra);
        header("Location: confirmacion.php");
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulario de cliente</title>
</head>
<body>

<h1>Formulario de cliente</h1>
<br>
<form method="post">
    <label>Nombre</label>
    <input type="text" name="nombre">
    <?php echo $nombreError?>
    <br>
    <label>Apellidos</label>
    <input type="text" name="apellidos">
    <?php echo $apellidosError?>
    <br>
    <label>DNI</label>
    <input type="text" name="dni">
    <?php echo $dniError?>
    <br>
    <label>Teléfono</label>
    <input type="text" name="telefono">
    <?php echo $telefonoError?>
    <br>
    <label>Dirección</label>
    <input type="text" name="direccion">
    <?php echo $direccionError?>
    <br>
    <label>Profesión</label>
    <input type="text" name="profesion">
        <br>
    <label>Email</label>
    <input type="email" name="email">
    <?php echo $emailError?>
    <br>
    <button type="submit" name="disponibilidad" formaction="disponibilidad.php">Volver a disponibilidad</button>
    <button type="submit">Aceptar compra</button>


</form>

</body>
</html>