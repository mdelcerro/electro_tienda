<?php
require "utils.php";
require_once("dao/ProductoDAO.php");
require_once("modelo/Compra.php");
require_once("modelo/Usuario.php");
validate_security();

if (!ISSET($_SESSION['carrito'])) {
    header("Location: disponibilidad.php");
    die();
}

$compra = unserialize($_SESSION['carrito']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
</head>
<body>

<h1>Carrito</h1>
<form method="get">
    <br>

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
    Precio total: <b><?=precio_bonito($compra->get_precio_total(), 'EUR')?> </b></br>
    <br>
    <button type="submit" name="disponibilidad" formaction="disponibilidad.php">Volver a disponibilidad</button>
    <button type="submit" name="aceptar" formaction="formulario_clientes.php">Aceptar compra</button>

</form>
</body>
</html>