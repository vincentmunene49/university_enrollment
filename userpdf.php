<?php
require('fpdf.php');


class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('universitylogo.png', 10, 6, 20, 20);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $w = $this->GetStringWidth('PROFILE');
        $this->Cell(30, 9, 'PROFILE', 0, 0, 'C',);
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    function Body()
    {
        // $this->SetFont('Arial', 'B', 15);
        // $this->Cell(40, 6, "PROFILE PHOTO:", 0, 0);
        $this->ln();
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(40, 6, "NAME:", 0, 0);
        $this->SetFont('Times', '', 12);
        $this->Cell(10, 6, $_POST['first_name'] . " " . $_POST['last_name']);
        $this->ln();
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(40, 6, "ADM NO:", 0, 0);
        $this->SetFont('Times', '', 12);
        $this->Cell(10, 6, $_POST['admission_number']);
        $this->ln();
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(40, 6, "PASSWORD:", 0, 0);
        $this->SetFont('Times', '', 12);
        $this->Cell(10, 6, $_POST['password']);
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Body();
$pdf->SetFont('Times', '', 12);
$pdf->Output();
