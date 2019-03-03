<?php

class DataSource
{
    private $conexion;

    public function __construct()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $schema = "electro_tienda";

        /*
        //datos base de datos local

        $servername = "localhost";
        $username = "";
        $password = "";
        $schema = "";
        */

        // Conectar DB
        $this->conexion = new mysqli($servername, $username, $password);
        mysqli_set_charset($this->conexion, "utf8");

        // Comprobar conexión
        if ($this->conexion->connect_error) {
            die("<p style=\"color:red\">Error de conexión: </p><br>" . $this->conexion->connect_error);
        }
        // Seleccionar bd
        $sql = "USE " . $schema;
        if ($this->conexion->query($sql) === FALSE) {
            die("<br><p style=\"color:red\">La base de datos " . $schema . " no se ha podido seleccionar: </p><br>" . $this->conexion->error);
        }
    }

    public function get_conexion()
    {
        return $this->conexion;
    }
}
