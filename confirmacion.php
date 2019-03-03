<?php
require "utils.php";
require_once("dao/ProductoDAO.php");
require_once("dao/ClienteDAO.php");
require_once("modelo/Compra.php");
require_once("modelo/Usuario.php");
require_once("modelo/Cliente.php");
validate_security();

if (!ISSET($_SESSION['carrito'])) {
    header("Location: disponibilidad.php");
    die();
}

$compra = unserialize($_SESSION['carrito']);

if ($compra->get_id() == null) {
    header("Location: disponibilidad.php");
    die();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmación</title>
</head>
<body>

<h1>Confirmación</h1>
<form method="get">
    <br>
    <img src="tcpdf/images/tcpdf_logo.jpg" height="120" width="120">
    <h2>Resumen de compra</h2>
    <?php
    foreach ($compra->get_productos_comprados() as $producto_comprado) {
        ?>
        <div>
            <img height="40" src="img/<?=$producto_comprado->get_producto()->get_id()?>.jpg" style="float: left; margin-right: 10px">
            <?=$producto_comprado->get_producto()->get_nombre()?> </br>
            <?=$producto_comprado->get_producto()->get_descripcion()?> </br>
            Cantidad: <?=$producto_comprado->get_cantidad()?> </br>
            <?=precio_bonito($producto_comprado->get_precio_total(), $producto_comprado->get_divisa())?> </br>
            </br>
        </div>
        <?php
    }
    ?>
     <br>
    Precio total: <?=precio_bonito($compra->get_precio_total(), 'EUR')?> </br>
    <br>
    <button type="submit" name="factura" formaction="factura_pdf.php">Factura compra</button>
    <br>
    <h2>Datos del cliente</h2>
    <?php
    $cliente = $compra->get_cliente();
     ?>
    <?=$cliente->get_nombre()?></br>
    <?=$cliente->get_apellidos()?></br>
    <?=$cliente->get_telefono()?></br>
    <?=$cliente->get_direccion()?></br>
    <br>
    <h2>Datos de la empresa</h2>
      <p>ElectroTienda S.L.</br>
          B57218372</br>
        Camí de Son Fangos, 1-A</br>
          07007 Palma de Mallorca</br>
        Islas Baleares</p>
    <button type="submit" name="disponibilidad" formaction="disponibilidad.php">Realiza nueva compra</button>
    <button type="submit" name="logout" formaction="logout.php">Logout</button>
</form>
</body>

