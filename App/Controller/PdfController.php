<?php
namespace App\Controllers;

use App\Model\Dao\PrimeDAO;
use TCPDF;

class PDFController {
    public function generatePdf() {
        // Enable full error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        try {
            // Verify PrimeDAO existence
            if (!class_exists(PrimeDAO::class)) {
                throw new \Exception("PrimeDAO class not found");
            }

            // Fetch primes data from the database
            $primeDao = new PrimeDAO();
            $primes = $primeDao->getAllPrime();

            // Verify primes data
            if (empty($primes)) {
                throw new \Exception("No prime data found");
            }

            // Create PDF instance with explicit parameters
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('Primes App');
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('Primes Calculées');
            $pdf->SetSubject('Primes Report');
            $pdf->SetMargins(10, 20, 10);
            $pdf->AddPage();

            // Add logo (with more robust path checking)
            $imageFile = __DIR__ . '/../../public/assets/images/e-stock.png';
            if (file_exists($imageFile)) {
                $pdf->Image($imageFile, 15, 10, 20, 20, 'PNG');
            } else {
                // Log that image was not found
                error_log("Logo file not found: " . $imageFile);
            }

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 15, 'Primes Calculées', 0, 1, 'C');

            // Prepare HTML table
            $html = '<table border="1" cellpadding="4">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th>ID</th>
                        <th>Nom du Commercial</th>
                        <th>Prime (€)</th>
                        <th>Chiffre d\'Affaire (€)</th>
                        <th>Année</th>
                    </tr>
                </thead>
                <tbody>';

            // Populate table rows
            foreach ($primes as $prime) {
                $html .= '<tr>
                    <td>' . htmlspecialchars($prime->getId() ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars($prime->getCommercialName() ?? 'N/A') . '</td>
                    <td>' . number_format($prime->getPrime() ?? 0, 0) . '</td>
                    <td>' . number_format($prime->getChiffreAffaire() ?? 0, 0) . '</td>
                    <td>' . htmlspecialchars($prime->getYear() ?? 'N/A') . '</td>
                </tr>';
            }

            $html .= '</tbody></table>';

            // Add HTML table to PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Output PDF
            $pdf->Output('primes_calculees.pdf', 'I');
            exit; // Prevent any additional output after PDF generation
        } catch (\Exception $e) {
            // More detailed error logging
            error_log("PDF Generation Error: " . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
            die(); // Stop execution
        }
    }
}