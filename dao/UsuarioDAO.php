<?php
require_once(__DIR__."/../dao/DataSource.php");
require_once(__DIR__."/../modelo/Usuario.php");

class UsuarioDAO
{
    private $datasource;

    public function __construct(){
        $this->datasource = new DataSource();
    }

    public function listar_usuarios() {

        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Usuario";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $email, $password);

        $usuarios = [];

        while ($stmt->fetch()) {
            $usuario = new Usuario();
            $usuario->set_id($id);
            $usuario->set_email($email);
            $usuario->set_password($password);

            $usuarios[] = $usuario;
        }

        $stmt->close();

        return $usuarios;
    }

    public function get_usuario_by_email($email) {
        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Usuario where email = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($id, $email, $password);

        $usuario = null;

        if ($stmt->fetch()) {
            $usuario = new Usuario();
            $usuario->set_id($id);
            $usuario->set_mail($email);
            $usuario->set_password($password);

        }

        $stmt->close();

        return $usuario;
    }

    public function get_usuario_by_id($id) {
        $conn = $this->datasource->get_conexion();

        $sql = "SELECT * FROM Usuario where id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('d', $id);
        $stmt->execute();
        $stmt->bind_result($id, $email, $password);

        $usuario = null;

        if ($stmt->fetch()) {
            $usuario = new Usuario();
            $usuario->set_id($id);
            $usuario->set_mail($email);
            $usuario->set_password($password);

        }

        $stmt->close();

        return $usuario;
    }

    public function insertar_usuario($usuario) {
        $conn = $this->datasource->get_conexion();

        $sql = "INSERT INTO Usuario(email, password) VALUES (?, ?)";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $email = $usuario->get_mail();
        $password = $usuario->get_password();
        $stmt->bind_param('ss', $email, $password);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La inserción no se ha podido realizar" . $conn->error);
        }

        $usuario->set_id($conn->insert_id);
    }

    public function actualizar_usuario($usuario) {
        $conn = $this->datasource->get_conexion();

        $sql = "UPDATE Usuario SET email = ?, password = ? WHERE id = ?";

        // Vincular variables a una instrucción preparada como parámetros
        $stmt = $conn->prepare($sql);
        $id = $usuario->get_id();
        $email = $usuario->get_mail();
        $password = $usuario->get_password();
        $stmt->bind_param('ssd',$email,$password, $id);

        if ($stmt->execute() === FALSE) {
            throw new Exception("La actualización no se ha podido realizar" . $conn->error);
        }
    }
}
?>