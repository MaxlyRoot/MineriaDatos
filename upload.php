<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES['excelFile']['tmp_name']);
        if ($fileType === 'application/vnd.ms-excel' || $fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            try {
                $spreadsheet = IOFactory::load($_FILES['excelFile']['tmp_name']);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->rangeToArray('A1:J10'); // Leer las primeras 10 filas
                
                echo "<h2 class='text-center'>Vista Previa del Archivo</h2>";
                echo "<table class='table table-bordered'>";
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>Error al procesar el archivo: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>El archivo debe ser un archivo Excel (.xls o .xlsx).</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error al subir el archivo. Por favor intente de nuevo.</div>";
    }
}
