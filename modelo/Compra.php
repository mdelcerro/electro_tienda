<?php
require_once("ProductoComprado.php");

class Compra
{

    // Declaración de atributos

    private $id;
    private $cliente;
    private $productos_comprados = [];


    // Métodos consultores

    public function get_id()
    {
    return $this->id;
    }

    public function get_cliente()
    {
        return $this->cliente;
    }

    public function get_productos_comprados()
    {
        return $this->productos_comprados;
    }

    // Métodos modificadores

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_cliente($cliente)
    {
        $this->cliente = $cliente;
    }

    public function set_productos_comprados($productos_comprados)
    {
        $this->productos_comprados = $productos_comprados;
    }

    public function add_producto_comprado($producto, $cantidad)
    {
        $producto_comprado = new ProductoComprado();
        $producto_comprado->set_producto($producto);
        $producto_comprado->set_cantidad($cantidad);
        $producto_comprado->set_compra($this);

        $this->productos_comprados[] = $producto_comprado;
    }

    public function get_precio_total() {

        $total = 0.0;

        foreach ($this->productos_comprados as $producto_comprado) {
            $total += $producto_comprado->get_precio_total();
        }

        return $total;
    }
}

?>