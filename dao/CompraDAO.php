<?php

require_once(__DIR__."/../dao/DataSource.php");
require_once(__DIR__."/../dao/ProductoCompradoDAO.php");
require_once(__DIR__."/../modelo/Compra.php");
require_once(__DIR__."/../modelo/Cliente.php");
require_once(__DIR__."/../modelo/ProductoComprado.php");
require_once(__DIR__."/../modelo/Producto.php");

class CompraDAO
{

    private $datasource;
    private $clienteDAO;
    private $producto_compradoDAO;

    public function __construct(){
        $this->datasource = new DataSource();
        $this->clienteDAO = new ClienteDAO();
        $this->producto_compradoDAO = new ProductoCompradoDAO();
    }

    public function get_compra_by_id($id) {

        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Compra WHERE id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->bind_result($id, $id_cliente);

        $compra = new Compra();
        if ($stmt->fetch()) {

            $compra->set_id($id);
            $compra->set_cliente($this->clienteDAO->get_cliente_by_id($id_cliente));
            $compra->set_productos_comprados($this->producto_compradoDAO->listar_producto_comprado($compra));
        }

        $stmt->close();

        return $compra;
    }

    public function insertar_compra($compra) {
        $conn = $this->datasource->get_conexion();

        $sql = "INSERT INTO Compra(id, id_cliente) VALUES (?, ?)";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $compra->get_id();
        $id_cliente = $compra->get_cliente()->get_id();
        $stmt->bind_param('dd', $id, $id_cliente);
        if ($stmt->execute() === FALSE) {
            throw new Exception("La inserción no se ha podido realizar" . $conn->error);
        }

        $compra->set_id($conn->insert_id);

        foreach ($compra->get_productos_comprados() as $producto_comprado) {
            $this->producto_compradoDAO->insertar_producto_comprado($producto_comprado);
        }
    }
}