<?php

require_once(__DIR__."/../dao/DataSource.php");
require_once(__DIR__."/../dao/ProductoDAO.php");
require_once(__DIR__."/../modelo/ProductoComprado.php");

class ProductoCompradoDAO
{
    private $datasource;
    private $productoDAO;

    public function __construct(){
        $this->datasource = new DataSource();
        $this->productoDAO = new ProductoDAO();
    }

    public function listar_producto_comprado($compra) {

        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Productos_comprados WHERE id_compra = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id_compra = $compra->get_id();
        $stmt->bind_param('d', $id_compra);
        $stmt->execute();
        $stmt->bind_result($id_compra, $id_producto, $cantidad, $precio, $divisa);

        $productos_comprados = [];

        while ($stmt->fetch()) {
            $producto_comprado = new ProductoComprado();
            $producto_comprado->set_compra($compra);
            $producto_comprado->set_producto($this->productoDAO->get_producto_by_id($id_producto));
            $producto_comprado->set_cantidad($cantidad);
            $producto_comprado->set_precio($precio);
            $producto_comprado->set_divisa($divisa);
            $productos_comprados[] = $producto_comprado;
        }

        $stmt->close();

        return $productos_comprados;
    }


    public function insertar_producto_comprado($producto_comprado) {
        $conn = $this->datasource->get_conexion();

        $sql = "INSERT INTO Productos_comprados(id_compra, id_producto, cantidad, precio, divisa) VALUES (?, ?, ?, ?, ?)";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id_compra = $producto_comprado->get_compra()->get_id();
        $id_producto = $producto_comprado->get_producto()->get_id();
        $cantidad = $producto_comprado->get_cantidad();
        $precio = $producto_comprado->get_precio();
        $divisa = $producto_comprado->get_divisa();

        echo $cantidad . ' ' . $precio . ' ' . $divisa;
        $stmt->bind_param('dddds', $id_compra, $id_producto, $cantidad, $precio, $divisa);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La inserción no se ha podido realizar" . $conn->error);
        }
    }
}