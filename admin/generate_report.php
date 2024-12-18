<?php
// Include the FPDF library
require('fpdf/fpdf.php');

// Create a new FPDF object
$pdf = new FPDF();

// Add a page to the PDF
$pdf->AddPage();

// Set title font
$pdf->SetFont('Arial', 'B', 16);

// Add the title
$pdf->Cell(200, 10, 'Student Attendance Report', 0, 1, 'C');

// Add the logo
$pdf->Image('img/logo.png', 10, 10, 30); // Adjust the size and position of the logo

// Line break after the title
$pdf->Ln(20);

// Set table header font
$pdf->SetFont('Arial', 'B', 12);

// Add table headers
$pdf->Cell(30, 10, 'Name', 1, 0, 'C');
$pdf->Cell(30, 10, 'Card ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Year of Study', 1, 0, 'C');
$pdf->Cell(40, 10, 'Class', 1, 0, 'C');
$pdf->Cell(50, 10, 'Date', 1, 1, 'C'); // New line after header

// Set table body font
$pdf->SetFont('Arial', '', 12);

// Fetch report data from the database
require 'dbconn.php'; // Ensure the connection is set
$sql = "SELECT t.name, t.year_of_study, t.class, r.sid,  r.datetime 
        FROM report r
        JOIN table_the_iot_projects t ON t.id = r.sid";
$query = $conn->prepare($sql);
$query->execute();
$all_users = $query->fetchAll(PDO::FETCH_ASSOC);

// Loop through the results and add them to the table
foreach ($all_users as $row) {
    $pdf->Cell(30, 10, htmlspecialchars($row['name']), 1, 0, 'C');
    $pdf->Cell(30, 10, htmlspecialchars($row['sid']), 1, 0, 'C');
    $pdf->Cell(30, 10, htmlspecialchars($row['year_of_study']), 1, 0, 'C');
    $pdf->Cell(40, 10, htmlspecialchars($row['class']), 1, 0, 'C');
    $pdf->Cell(50, 10, htmlspecialchars($row['datetime']), 1, 1, 'C');
}

// Output the PDF
$pdf->Output('D', 'student_report.pdf');
?>
