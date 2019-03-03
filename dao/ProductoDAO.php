<?php

require_once(__DIR__."/../dao/DataSource.php");
require_once(__DIR__."/../modelo/Producto.php");

class ProductoDAO
{
    private $datasource;

    public function __construct(){
        $this->datasource = new DataSource();
    }

    public function listar_productos() {

        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Producto";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $descripcion, $precio, $divisa);

        $productos = [];

        while ($stmt->fetch()) {
            $producto = new Producto();
            $producto->set_id($id);
            $producto->set_nombre($nombre);
            $producto->set_descripcion($descripcion);
            $producto->set_precio ($precio);
            $producto->set_divisa ($divisa);

            $productos[] = $producto;
        }

        $stmt->close();

        return $productos;
    }

    public function get_producto_by_id($id) {
        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Producto where id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $descripcion, $precio, $divisa);

        $producto = null;

        if ($stmt->fetch()) {
            $producto = new Producto();
            $producto->set_id($id);
            $producto->set_nombre($nombre);
            $producto->set_descripcion($descripcion);
            $producto->set_precio($precio);
            $producto->set_divisa($divisa);

        }

        $stmt->close();

        return $producto;
    }

    public function insertar_producto($producto) {
        $conn = $this->datasource->get_conexion();

        $sql = "INSERT INTO Producto(nombre, descripcion, precio, divisa) VALUES (?, ?, ?, ?)";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $nombre = $producto->get_nombre();
        $descripcion = $producto->get_descripcion();
        $precio = $producto->get_precio();
        $divisa = $producto->get_divisa();
        $stmt->bind_param('ssds', $nombre, $descripcion, $precio, $divisa);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La inserción no se ha podido realizar" . $conn->error);
        }

        $producto->set_id($conn->insert_id);
    }

    public function actualizar_producto($producto) {
        $conn = $this->datasource->get_conexion();

        $sql = "UPDATE Producto SET nombre = ?, descripcion = ?, precio = ?, divisa = ? WHERE id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $producto->get_id();
        $nombre = $producto->get_nombre();
        $descripcion = $producto->get_descripcion();
        $precio = $producto->get_precio();
        $divisa = $producto->get_divisa();
        $stmt->bind_param('dssds', $id, $nombre, $descripcion, $precio, $divisa);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La actualización no se ha podido realizar" . $conn->error);
        }
    }
}