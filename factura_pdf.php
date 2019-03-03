<?php
require "utils.php";
require_once('tcpdf_include.php');
require_once("dao/ProductoDAO.php");
require_once("dao/ClienteDAO.php");
require_once("modelo/Compra.php");
require_once("modelo/Usuario.php");
require_once("modelo/Cliente.php");
validate_security();

if (!ISSET($_SESSION['carrito'])) {
    header("Location: disponibilidad.php");
    die();
}

$compra = unserialize($_SESSION['carrito']);

if ($compra->get_id() == null) {
    header("Location: disponibilidad.php");
    die();
}

$cliente = $compra->get_cliente();


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ElectroTienda');
$pdf->SetTitle('Factura de compra');
$pdf->SetSubject('Factura de compra');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('tcpdf_logo.jpg', 30, 'Factura de compra', 'www.electrotienda.com', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$productos = "<p>";
foreach ($compra->get_productos_comprados() as $producto_comprado) {
    $productos .=  "<p>". $producto_comprado->get_producto()->get_nombre() .'</p>';
    $productos .=  "<p>".$producto_comprado->get_producto()->get_descripcion() .'</p>';
    $productos .=  "<p>".$producto_comprado->get_cantidad() .'</p>';
    $productos .=  "<p>".precio_bonito($producto_comprado->get_precio_total(), $producto_comprado->get_divisa()) .'</p>';
}
$productos .= '</p>';

$nombre_cliente = $cliente->get_nombre();
$apellidos_cliente = $cliente->get_apellidos();
$telefono_cliente = $cliente->get_telefono();
$direccion_cliente = $cliente->get_direccion();

// Set some content to print
$html = <<<EOD
<br>
<h1>Resumen de compra</h1>
$productos
<br>
<h1>Datos del cliente</h1>
<p>$nombre_cliente $apellidos_cliente</p>
<p>$direccion_cliente</p>
<p>$telefono_cliente</p>
<br>
<h1>Datos de la empresa</h1>
 <p>ElectroTienda S.L.</p>
 <p>B57218372</p>
 <p>Camí de Son Fangos, 1-A</p>
 <p>07007 Palma de Mallorca</p>
 <p>Islas Baleares</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('factura.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
