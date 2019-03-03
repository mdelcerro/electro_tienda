<?php

require_once("dao/ProductoCompradoDAO.php");
require_once("modelo/ProductoComprado.php");

$productocompradoDAO = new ProductoCompradoDAO();

$usuarios = $usuarioDAO->listar_usuarios();

foreach ($usuarios as $usuario) {
    echo $usuario->get_mail() . '<br>';
}

$usuario = $usuarioDAO->get_usuario_by_email("test@test.com");

echo (ISSET($usuario) ? 'existe' : 'no existe') . '<br>';
echo $usuario->get_id() . '<br>';
echo $usuario->get_password() . '<br>';

$usuario = $usuarioDAO->get_usuario_by_email("test@test2323.dfdf");

echo (ISSET($usuario) ? 'existe' : 'no existe') . '<br>';

$usuario = new Usuario();
$usuario->set_mail("aa@bb.com");
$usuario->set_password("dfsfdsf");

$usuarioDAO->insertar_usuario($usuario);

echo $usuario->get_id() . '<br>';

$usuario->set_mail("caca@bb.com");

// Testeo de la función actualizar usuario

$usuarioDAO->actualizar_usuario($usuario);

$usuario = $usuarioDAO->get_usuario_by_email("caca@bb.com");
echo $usuario->get_id() . '<br>';
echo $usuario->get_email() . '<br>';

?>