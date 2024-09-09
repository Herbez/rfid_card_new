<?php
require('fpdf186/fpdf.php');
include 'database.php';

// Create instance of the FPDF class
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

// Add header
$pdf->Cell(0,10,'Student Report',0,1,'C'); // Centered header
$pdf->Ln(10); // Add a line break for spacing

// Add table header
$pdf->Cell(40,10,'Name',1);
$pdf->Cell(30,10,'Card ID',1);
$pdf->Cell(30,10,'Year Of Study',1);
$pdf->Cell(20,10,'Class',1);
$pdf->Cell(40,10,'Department',1);
$pdf->Cell(30,10,'Check Time',1);
$pdf->Ln();

$pdo = Database::connect();
$sql = 'SELECT * 
        FROM table_the_iot_projects t
        LEFT JOIN report r 
        ON t.id = r.sid ORDER BY name ASC';
foreach ($pdo->query($sql) as $row) {
    $pdf->Cell(40,10,$row['name'],1);
    $pdf->Cell(30,10,$row['sid'],1);
    $pdf->Cell(30,10,$row['year_of_study'],1);
    $pdf->Cell(20,10,$row['class'],1);
    $pdf->Cell(40,10,$row['department'],1);
    $pdf->Cell(30,10,$row['datetime'],1);
    $pdf->Ln();
}

Database::disconnect();

// Output the PDF
$pdf->Output('D', 'Student_Report.pdf'); // 'D' forces the download
?>
