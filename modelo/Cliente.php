<?php

class Cliente
{

    // Declaración de atributos

    private $id;
    private $email;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $direccion;
    private $profesion;
    private $dni;
    private $usuario;

    // Métodos consultores

    public function get_id()
    {
        return $this->id;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function get_nombre()
    {
        return $this->nombre;
    }

    public function get_apellidos()
    {
        return $this->apellidos;
    }

    public function get_telefono()
    {
        return $this->telefono;
    }

    public function get_direccion()
    {
        return $this->direccion;
    }

    public function get_profesion()
    {
        return $this->profesion;
    }

    public function get_dni()
    {
        return $this->dni;
    }

    public function get_usuario()
    {
        return $this->usuario;
    }

    // Métodos modificadores

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_email($email)
    {
        $this->email = $email;
    }

    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function set_apellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function set_telefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function set_direccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function set_profesion($profesion)
    {
        $this->profesion = $profesion;
    }

    public function set_dni($dni)
    {
        $this->dni = $dni;
    }

    public function set_usuario($usuario)
    {
        $this->usuario = $usuario;
    }
}

?>