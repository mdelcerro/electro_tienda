<?php

require "utils.php";
require_once("dao/ProductoDAO.php");
require_once("modelo/Compra.php");
require_once("modelo/Usuario.php");
validate_security();

$usuario = get_logged();
$productoDAO = new ProductoDAO();
$productos = $productoDAO->listar_productos();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $compra = new Compra();
    $productos_cantidad = $_POST['productos'];


    foreach ($productos_cantidad as $id_producto => $cantidad_producto) {

        if ($cantidad_producto > 0) {
            $producto = $productoDAO->get_producto_by_id($id_producto);
            $compra->add_producto_comprado($producto, $cantidad_producto);
        }
    }

    // comprobamos si hay algun elemento comprado mirando si el precio es mayor que 0
    if ($compra->get_precio_total() > 0) {
        $_SESSION['carrito'] = serialize($compra);
        header("Location: carrito.php");
        die();
    }
}

$_SESSION['carrito'] = null

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Disponibilidad</title>
</head>
<body>

<h1>Disponibilidad</h1>
<form method="post">
<br>

<?php
foreach ($productos as $producto) {
    ?>
    <div>
        <img height="40" src="img/<?=$producto->get_id()?>.jpg" style="float: left; margin-right: 10px">
        <?=$producto->get_nombre()?> </br>
        <?=$producto->get_descripcion()?> </br>
        <?=precio_bonito($producto->get_precio(), $producto->get_divisa())?> </br>
        Cantidad : <input type="number" min="0" name="productos[<?=$producto->get_id()?>]" value="0" />
        </br>
    </div>
    <?php
}
?>
    <br>
    <br>
    <button type="submit">Comprar</button>

</form>
</body>
</html>