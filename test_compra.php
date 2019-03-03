<?php

require_once("dao/ClienteDAO.php");
require_once("dao/ProductoDAO.php");
require_once("dao/CompraDAO.php");
require_once("dao/ProductoCompradoDAO.php");
require_once("modelo/Compra.php");
require_once("modelo/ProductoComprado.php");

$productoDAO = new ProductoDAO();
$clienteDAO = new ClienteDAO();
$compraDAO = new CompraDAO();
$producto_compradoDAO = new ProductoCompradoDAO();

// Testeo del método insertar compra

$producto = $productoDAO->get_producto_by_id(2);
$cliente = $clienteDAO->get_cliente_by_id(1);

$compra = new Compra();
$compra->set_cliente($cliente);
$compra->add_producto_comprado($producto, 4);
$compraDAO->insertar_compra($compra);


$compraDB = $compraDAO->get_compra_by_id($compra->get_id());

echo 'El precio total de la compra es ' . $compraDB->get_precio_total();