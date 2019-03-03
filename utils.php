<?php
session_start();

function is_logged() {
    return !empty($_SESSION['usuario']);
}

function validate_security() {

    if (!is_logged()) {
        header('Location: login.php');
        die();
    }
}

function get_logged() {
    return unserialize($_SESSION['usuario']);
}

function precio_bonito($cantidad, $divisa) {
    $locale='es-ES';
    $fmt = new NumberFormatter( $locale."@currency=$divisa", NumberFormatter::CURRENCY );
    $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    return money_format('%.2n', $cantidad) . ' ' . $symbol;
}