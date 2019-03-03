<?php

require_once("dao/ProductoDAO.php");
require_once("modelo/Producto.php");

$productoDAO = new ProductoDAO();

$productos = $productoDAO->listar_productos();

foreach ($productos as $producto) {
    echo $producto->get_nombre() . '<br>';
}


$producto = $productoDAO->get_producto_by_id(1);

echo (ISSET($producto) ? 'existe' : 'no existe') . '<br>';
echo $producto->get_id() . '<br>';
echo $producto->get_nombre() . '<br>';
echo $producto->get_descripcion() . '<br>';
echo $producto->get_precio() . '<br>';

$producto = $productoDAO->get_producto_by_id(2);

echo (ISSET($producto) ? 'existe' : 'no existe') . '<br>';

$producto = new Producto();
$producto->set_nombre("Caja pirámide");
$producto->set_descripcion("Medidas 50x20x30");
$producto->set_precio(21);
$producto->set_divisa("EUR");


$productoDAO->insertar_producto($producto);

echo $producto->get_id() . '<br>';

$producto->set_nombre("Caja hexagonal");


// Testeo de la función actualizar cliente

$productoDAO->actualizar_producto($producto);

$producto = $productoDAO->get_producto_by_id(1);
echo $producto->get_id() . '<br>';
echo $producto->get_nombre() . '<br>';
echo $producto->get_descripcion() . '<br>';
echo $producto->get_precio() . '<br>';
echo $producto->get_divisa() . '<br>';
