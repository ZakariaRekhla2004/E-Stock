<?php
// App/Controllers/PdfController.php

require_once '/vendor/tecnickcom/tcpdf.php';

function generatePdf($primes) {
    // Create a new PDF instance
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator('Primes App');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Primes Calculées');
    $pdf->SetSubject('Primes Report');

    // Set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Primes Calculées', 'Liste des primes');

    // Set header and footer fonts
    $pdf->setHeaderFont(['helvetica', '', 10]);
    $pdf->setFooterFont(['helvetica', '', 8]);

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 10);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage();

    // Add a logo
    $imageFile = '/public/assets/images/e-stock.png'; // Path to your logo
    $pdf->Image($imageFile, 15, 10, 20, 20, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

    // Set title
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 15, 'Primes Calculées', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

    // Add a blank line
    $pdf->Ln(10);

    // Set table headers
    $pdf->SetFont('helvetica', '', 12);
    $html = '
        <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>ID</th>
                    <th>Nom du Commercial</th>
                    <th>Prime (€)</th>
                    <th>Chiffre d\'Affaire (€)</th>
                    <th>Année</th>
                </tr>
            </thead>
            <tbody>
    ';

    // Populate table rows
    foreach ($primes as $prime) {
        $html .= '
            <tr>
                <td>' . htmlspecialchars($prime->getId()) . '</td>
                <td>' . htmlspecialchars($prime->getCommercialName()) . '</td>
                <td>' . number_format($prime->getPrime(), 0) . '</td>
                <td>' . number_format($prime->getChiffreAffaire(), 0) . '</td>
                <td>' . htmlspecialchars($prime->getYear()) . '</td>
            </tr>
        ';
    }

    $html .= '
            </tbody>
        </table>
    ';

    // Write table to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF
    $pdf->Output('primes_calculees.pdf', 'I');
}