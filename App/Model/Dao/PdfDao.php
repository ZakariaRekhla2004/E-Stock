<?php
require('fpdf/fpdf.php');

class PrimesPDF extends FPDF {
    private $primes;
    private $title;

    public function __construct($primes, $title = 'Primes Calculation Report') {
        parent::__construct();
        $this->primes = $primes;
        $this->title = $title;
    }

    function Header() {
        // Logo or Company Name
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, $this->title, 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function GeneratePrimesTable() {
        // Table Header
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(96, 208, 228); // Light blue header
        $this->SetTextColor(255);
        $header = ['Commercial', 'Chiffre d\'Affaire', 'Prime', 'Année'];
        $w = [60, 40, 40, 50];
        
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();

        // Table Content
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(0);
        
        foreach($this->primes as $prime) {
            $this->Cell($w[0], 6, $prime->getCommercialName(), 1);
            $this->Cell($w[1], 6, number_format($prime->getChiffreAffaire(), 0) . ' €', 1, 0, 'R');
            $this->Cell($w[2], 6, number_format($prime->getPrime(), 0) . ' €', 1, 0, 'R');
            $this->Cell($w[3], 6, $prime->getYear(), 1);
            $this->Ln();
        }
    }

    function RenderPDF() {
        $this->AliasNbPages();
        $this->AddPage();
        $this->GeneratePrimesTable();
        $this->Output('F', 'primes_report.pdf'); // Save to file
        $this->Output('I', 'primes_report.pdf'); // Open in browser
    }
}

