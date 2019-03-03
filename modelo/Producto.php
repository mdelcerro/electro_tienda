<?php

class producto
{

    // Declaración de atributos

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $divisa;

    // Métodos consultores

    public function get_id()
    {
        return $this->id;
    }

    public function get_nombre()
    {
        return $this->nombre;
    }

    public function get_descripcion()
    {
        return $this->descripcion;
    }

    public function get_precio()
    {
        return $this->precio;
    }

    public function get_divisa()
    {
        return $this->divisa;
    }

    // Métodos modificadores

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function set_descripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function set_precio($precio)
    {
        $this->precio = $precio;
    }

    public function set_divisa($divisa)
    {
        $this->divisa = $divisa;
    }
}

?>