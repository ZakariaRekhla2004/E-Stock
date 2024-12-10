<?php
namespace App\Model\Dao;

use FPDF;

class PrimesPDF extends FPDF {
    private $primes;
    private $title;
    private $logoPath;

    public function __construct($primes, $title = 'Primes Calculation Report', $logoPath = "/public/assets/images/logo.png") {
        parent::__construct();
        $this->primes = $primes;
        $this->title = $title;
        $this->logoPath = $logoPath;
    }

    function Header() {
        // Set up page width
        $pageWidth = $this->GetPageWidth();
        
        // Left side: Title
        $this->SetFont('Arial', 'B', 15);
        $this->SetXY(10, 10);
        $this->Cell(100, 10, $this->title, 0, 0, 'L');
        
        // Right side: Logo (if provided)
        if ($this->logoPath && file_exists($this->logoPath)) {
            // Get logo dimensions and maintain aspect ratio
            list($logoWidth, $logoHeight) = getimagesize($this->logoPath);
            $maxLogoHeight = 20; // Maximum logo height in mm
            $scaleFactor = $maxLogoHeight / $logoHeight;
            $scaledLogoWidth = $logoWidth * $scaleFactor;
            
            // Position logo on the right side
            $this->SetXY($pageWidth - $scaledLogoWidth - 10, 10);
            $this->Image($this->logoPath, null, null, $scaledLogoWidth, $maxLogoHeight);
        }
        
        $this->Ln(20);
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
            $this->Cell($w[1], 6, number_format($prime->getChiffreAffaire(), 0) . ' ', 1, 0, 'R');
            $this->Cell($w[2], 6, number_format($prime->getPrime(), 0) . ' ', 1, 0, 'R');
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