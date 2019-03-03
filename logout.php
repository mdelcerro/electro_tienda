<?php
include "utils.php";

// comprobamos que se haya iniciado la sesión
if(is_logged()) {
    session_destroy();

}

header("Location: login.php");
