<?php

require_once(__DIR__."/../dao/DataSource.php");
require_once(__DIR__."/../dao/UsuarioDAO.php");
require_once(__DIR__."/../modelo/Cliente.php");

class ClienteDAO
{
    private $datasource;
    private $usuarioDAO;

    public function __construct(){
        $this->datasource = new DataSource();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function listar_clientes() {

        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Cliente";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $email, $nombre, $apellidos, $telefono, $direccion, $profesion, $dni, $id_usuario);

        $clientes = [];

        while ($stmt->fetch()) {
            $cliente = new Cliente();
            $cliente->set_id($id);
            $cliente->set_email($email);
            $cliente->set_nombre($nombre);
            $cliente->set_apellidos($apellidos);
            $cliente->set_telefono($telefono);
            $cliente->set_direccion($direccion);
            $cliente->set_profesion($profesion);
            $cliente->set_dni($dni);
            $cliente->set_usuario($this->usuarioDAO->get_usuario_by_id($id_usuario));

            $clientes[] = $cliente;
        }

        $stmt->close();

        return $clientes;
    }

    public function get_cliente_by_email($email) {
        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Cliente where email = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($id, $email, $nombre, $apellidos, $telefono, $direccion, $profesion, $dni, $id_usuario);

        $cliente = null;

        if ($stmt->fetch()) {
            $cliente = new Cliente();
            $cliente->set_id($id);
            $cliente->set_email($email);
            $cliente->set_nombre($nombre);
            $cliente->set_apellidos($apellidos);
            $cliente->set_telefono($telefono);
            $cliente->set_direccion($direccion);
            $cliente->set_profesion($profesion);
            $cliente->set_dni($dni);
            $cliente->set_usuario($this->usuarioDAO->get_usuario_by_id($id_usuario));

        }

        $stmt->close();

        return $cliente;
    }

    public function get_cliente_by_id($id) {
        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Cliente where id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->bind_result($id, $email, $nombre, $apellidos, $telefono, $direccion, $profesion, $dni, $id_usuario);

        $cliente = null;

        if ($stmt->fetch()) {
            $cliente = new Cliente();
            $cliente->set_id($id);
            $cliente->set_email($email);
            $cliente->set_nombre($nombre);
            $cliente->set_apellidos($apellidos);
            $cliente->set_telefono($telefono);
            $cliente->set_direccion($direccion);
            $cliente->set_profesion($profesion);
            $cliente->set_dni($dni);
            $cliente->set_usuario($this->usuarioDAO->get_usuario_by_id($id_usuario));

        }

        $stmt->close();

        return $cliente;
    }

    public function insertar_cliente($cliente) {
        $conn = $this->datasource->get_conexion();

        $sql = "INSERT INTO Cliente(email, nombre, apellidos, telefono, direccion, profesion, dni) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $email = $cliente->get_email();
        $nombre = $cliente->get_nombre();
        $apellidos = $cliente->get_apellidos();
        $telefono = $cliente->get_telefono();
        $direccion = $cliente->get_direccion();
        $profesion = $cliente->get_profesion();
        $dni = $cliente->get_dni();
        $stmt->bind_param('sssdsss', $email, $nombre, $apellidos, $telefono, $direccion, $profesion, $dni);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La inserción no se ha podido realizar" . $conn->error);
        }

        $cliente->set_id($conn->insert_id);
    }

    public function actualizar_cliente($cliente) {
        $conn = $this->datasource->get_conexion();

        $sql = "UPDATE Cliente SET email = ?, nombre = ?, apellidos = ?, telefono = ?, direccion = ?, profesion = ?, dni = ? WHERE id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $cliente->get_id();
        $email = $cliente->get_email();
        $nombre = $cliente->get_nombre();
        $apellidos = $cliente->get_apellidos();
        $telefono = $cliente->get_telefono();
        $direccion = $cliente->get_direccion();
        $profesion = $cliente->get_profesion();
        $dni = $cliente->get_dni();
        $stmt->bind_param('dsssdsss',$id, $email, $nombre, $apellidos, $telefono, $direccion, $profesion, $dni);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La actualización no se ha podido realizar" . $conn->error);
        }
    }
}