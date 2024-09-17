<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?error=Por favor, inicia sesión.');
    exit();
}

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$excelPreviewHtml = '';
if (isset($_SESSION['file_path'])) {
    $filePath = $_SESSION['file_path'];
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->rangeToArray('A1:E10', null, true, true, true);

    $excelPreviewHtml .= '<table class="table table-bordered"><thead><tr>';

    foreach (array_keys($data[1]) as $header) {
        $excelPreviewHtml .= '<th>' . htmlspecialchars($header) . '</th>';
    }
    $excelPreviewHtml .= '</tr></thead><tbody>';

    foreach ($data as $row) {
        $excelPreviewHtml .= '<tr>';
        foreach ($row as $cell) {
            $excelPreviewHtml .= '<td>' . htmlspecialchars($cell) . '</td>';
        }
        $excelPreviewHtml .= '</tr>';
    }

    $excelPreviewHtml .= '</tbody></table>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mineria de Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1abc9c, #16a085);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dashboard {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 900px;
            background-color: #ffffff;
        }
        .btn-startup {
            background-color: #1abc9c;
            color: white;
            font-weight: 600;
        }
        .btn-startup:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="dashboard">
        <h2 class="text-center">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

        <h3>Cargar archivo Excel</h3>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="excelFile" class="form-label">Selecciona un archivo Excel</label>
                <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xlsx, .xls" required>
            </div>
            <button type="submit" class="btn btn-startup w-100">Cargar archivo</button>
        </form>

        <h3 class="mt-4">Vista previa del archivo Excel</h3>
        <div id="excelPreview">
            <?php echo $excelPreviewHtml; ?>
        </div>

        <a href="logout.php" class="btn btn-startup w-100 mt-3">Cerrar sesión</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
