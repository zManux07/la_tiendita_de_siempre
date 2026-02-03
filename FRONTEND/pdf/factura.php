<?php
require('../fpdf/fpdf.php');
require_once '../config/Database.php';
require_once '../models/FacturaModel.php';
require_once '../models/DetalleSalidaModel.php';

if (!isset($_GET['id'])) {
    die('Factura no especificada');
}

$db = new Database();
$conn = $db->connect();

$facturaModel = new FacturaModel($conn);
$detalleModel = new DetalleSalidaModel($conn);

$factura = $facturaModel->obtenerPorId($_GET['id']);
$detalles = $detalleModel->obtenerPorFactura($_GET['id']);

if (!$factura) {
    die('Factura no encontrada');
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);

$pdf->Cell(0,10,'LA TIENDITA DE SIEMPRE',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'Factura #: '.$factura['idFACTURA'],0,1);
$pdf->Cell(0,6,'Cliente: '.$factura['nomUSUARIO'],0,1);
$pdf->Cell(0,6,'Email: '.$factura['emailUSUARIO'],0,1);
$pdf->Cell(0,6,'Fecha: '.$factura['fechaFACTURA'],0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,6,'Producto',1);
$pdf->Cell(30,6,'Cantidad',1);
$pdf->Cell(40,6,'Precio',1);
$pdf->Cell(40,6,'Subtotal',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
foreach ($detalles as $d) {
    $pdf->Cell(80,6,utf8_decode($d['nomPRODUCTO']),1);
    $pdf->Cell(30,6,$d['cantiSalidaDETALLESALIDA'],1);
    $pdf->Cell(40,6,'$'.number_format($d['valorunitarioDETALLESALIDA'],2),1);
    $pdf->Cell(40,6,'$'.number_format($d['valorTotalventaDETALLESALIDA'],2),1);
    $pdf->Ln();
}

$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'TOTAL: $'.number_format($factura['totalFACTURA'],2),0,1,'R');

$pdf->Output('I', 'Factura_'.$factura['idFACTURA'].'.pdf');
