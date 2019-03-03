<?php

require_once("dao/ClienteDAO.php");
require_once("modelo/Cliente.php");

$clienteDAO = new ClienteDAO();

$clientes = $clienteDAO->listar_clientes();

foreach ($clientes as $cliente) {
    echo $cliente->get_email() . '<br>';
}


$cliente = $clienteDAO->get_cliente_by_email("test@test.com");

echo (ISSET($cliente) ? 'existe' : 'no existe') . '<br>';
echo $cliente->get_id() . '<br>';
echo $cliente->get_email() . '<br>';

$cliente = $clienteDAO->get_cliente_by_email("test@test2323.dfdf");

echo (ISSET($cliente) ? 'existe' : 'no existe') . '<br>';

$cliente = new Cliente();
$cliente->set_email("aa@bb.com");
$cliente->set_nombre("Pepito");
$cliente->set_apellidos("De los Palotes");
$cliente->set_telefono("971382345");
$cliente->set_direccion("Calle Joan Josep Amengual i Reus");
$cliente->set_profesion("Product Manager");
$cliente->set_dni("43127003w");

$clienteDAO->insertar_cliente($cliente);

echo $cliente->get_id() . '<br>';

$cliente->set_email("caca@bb.com");


// Testeo de la función actualizar cliente

$clienteDAO->actualizar_cliente($cliente);

$cliente = $clienteDAO->get_cliente_by_email("aa@bb.com");
echo $cliente->get_id() . '<br>';
echo $cliente->get_email() . '<br>';
echo $cliente->get_nombre() . '<br>';
echo $cliente->get_apellidos() . '<br>';
echo $cliente->get_telefono() . '<br>';
echo $cliente->get_direccion() . '<br>';
echo $cliente->get_profesion() . '<br>';
echo $cliente->get_dni() . '<br>';

// test get_cliente_by_id

$cliente = $clienteDAO->get_cliente_by_id(1);

echo (ISSET($cliente) ? 'existe' : 'no existe') . '<br>';
echo $cliente->get_id() . '<br>';
echo $cliente->get_email() . '<br>';
echo $cliente->get_nombre() . '<br>';

?>