<?php

class usuario
{

    // Declaración de atributos

    private $id;
    private $mail;
    private $password;

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    // Métodos consultores



    public function get_mail()
    {
        return $this->mail;
    }

    public function get_password()
    {
        return $this->password;
    }

    // Métodos modificadores

    public function set_mail($mail)
    {
        $this->mail = $mail;
    }

    public function set_password($password)
    {
        $this->password = $password;
    }
}

?>