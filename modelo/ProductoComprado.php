<?php

class ProductoComprado
{

    // Declaración de atributos

    private $compra;
    private $producto;
    private $cantidad;
    private $precio;
    private $divisa;

    // Métodos consultores

    public function get_compra()
    {
        return $this->compra;
    }

    public function get_producto()
    {
        return $this->producto;
    }

    public function get_cantidad()
    {
        return $this->cantidad;
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

    public function set_compra($compra)
    {
        $this->compra = $compra;
    }

    public function set_producto($producto)
    {
        $this->producto = $producto;
        $this->precio = $producto->get_precio();
        $this->divisa = $producto->get_divisa();
    }

    public function set_cantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function set_precio($precio)
    {
        $this->precio = $precio;
    }

    public function set_divisa($divisa)
    {
        $this->divisa = $divisa;
    }

    public function get_precio_total() {
        return $this->precio * $this->cantidad;
    }
}

?>