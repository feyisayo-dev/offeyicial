<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once('tcpdf/tcpdf.php');

if (isset($_FILES['images']) && !empty($_FILES['images']['tmp_name'])) {
    $size = false;

    $size = $_POST['pdfSizeLimit'];
    $name = $_POST['name'];
    $nameedit = str_replace(' ', '_', $name);

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator('OFFEYICIAL');
    $pdf->SetAuthor('OFFEYICIAL');
    $pdf->SetTitle('BANK');
    $pdf->SetSubject('BANK');
    $pdf->SetKeywords('PDF, Image, Conversion');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();

    $maxWidth = 210;
    $maxHeight = 297;
    foreach ($_FILES['images']['tmp_name'] as $key => $imageFile) {
        if (is_uploaded_file($imageFile)) {
            $originalFileName = $_FILES['images']['name'][$key];
            $imageExt = pathinfo($originalFileName, PATHINFO_EXTENSION);
            list($originalWidth, $originalHeight) = getimagesize($imageFile);

            if ($originalWidth > $originalHeight) {
                $newWidth = $maxWidth;
                $newHeight = ($originalHeight / $originalWidth) * $maxWidth;
            } else {
                $newWidth = ($originalWidth / $originalHeight) * $maxHeight;
                $newHeight = $maxHeight;
            }
            $pdf->Image($imageFile, '', '', $newWidth, $newHeight, $imageExt, '', '', false, 300, '', false, false, 0);

            $pdf->AddPage();
        }
    }
    // Check if the user wants to compress the PDF
    if ($size = true) {
        // Original PDF path
        $pdfP = $nameedit.'.pdf';
        $pdfPath = 'books/' . $pdfP;
        $outputPdfPath = __DIR__ . '/' . $pdfPath;

        $pdf->Output($outputPdfPath, 'F');

        if (file_exists($outputPdfPath)) {
            $compressedPath = $nameedit . 'compressed.pdf';
            $compressedPdfPath = 'books/' . $compressedPath;
            $outputCompressedPdfPath = __DIR__ . '/' . $compressedPdfPath;
            // echo $outputPdfPath;
            // echo $outputCompressedPdfPath;
            $cmd = "gswin32 -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$outputCompressedPdfPath $outputPdfPath";
            exec($cmd);

            if (file_exists($outputCompressedPdfPath)) {
                unlink($outputPdfPath);

                rename($outputCompressedPdfPath, $outputPdfPath);

                echo $pdfP;
            } else {
                echo 'Error: Compressed PDF file not found.';
            }
        } else {
            echo 'Error: Original PDF file not found.';
        }
    } else {
        $pdfP = uniqid() . '.pdf';

        $pdfPath = 'books/' . $pdfP;

        $pdfOutputPath = __DIR__ . '/' . $pdfPath;

        $pdf->Output($pdfOutputPath, 'F');

        echo $pdfP;
    }
} else {
    echo 'No images were uploaded.';
}
