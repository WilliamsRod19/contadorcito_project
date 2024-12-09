<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Iniciar la sesión
session_start(); // Asegúrate de iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $empresa_id = $_POST['empresa_id'];
    $tipo_comprobante = $_POST['tipo_comprobante'];
    $numero_comprobante = $_POST['numero_comprobante'];
    $fecha_comprobante = $_POST['fecha_comprobante'];
    $monto = $_POST['monto'];
    $cliente = $_POST['cliente'];

    // Validar campos requeridos
    if (empty($empresa_id) || empty($tipo_comprobante) || empty($numero_comprobante) || 
        empty($fecha_comprobante) || empty($monto) || empty($cliente)) {
        die("Todos los campos son obligatorios.");
    }

    // Manejo de archivos
    $upload_dir = '../../uploads/comprobantes_ventas/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Inicializar las variables de archivo
    $pdf_path = null;
    $json_path = null;

    // Validar archivo PDF si se ha subido
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == 0) {
        $archivo_pdf = $_FILES['archivo_pdf'];
        if ($archivo_pdf['type'] !== 'application/pdf') {
            die("El archivo debe ser un PDF.");
        }

        $pdf_filename = basename($archivo_pdf['name']);
        $pdf_path = $upload_dir . $pdf_filename;

        // Evitar sobrescribir archivos con el mismo nombre
        $counter = 1;
        while (file_exists($pdf_path)) {
            $pdf_path = $upload_dir . pathinfo($pdf_filename, PATHINFO_FILENAME) . "_" . $counter . "." . pathinfo($pdf_filename, PATHINFO_EXTENSION);
            $counter++;
        }

        if (!move_uploaded_file($archivo_pdf['tmp_name'], $pdf_path)) {
            die("Error al subir el archivo PDF.");
        }
    }

    // Validar archivo JSON si se ha subido
    if (isset($_FILES['archivo_json']) && $_FILES['archivo_json']['error'] == 0) {
        $archivo_json = $_FILES['archivo_json'];
        if ($archivo_json['type'] !== 'application/json') {
            die("El archivo debe ser un JSON.");
        }

        $json_filename = basename($archivo_json['name']);
        $json_path = $upload_dir . $json_filename;

        // Evitar sobrescribir archivos con el mismo nombre
        $counter = 1;
        while (file_exists($json_path)) {
            $json_path = $upload_dir . pathinfo($json_filename, PATHINFO_FILENAME) . "_" . $counter . "." . pathinfo($json_filename, PATHINFO_EXTENSION);
            $counter++;
        }

        if (!move_uploaded_file($archivo_json['tmp_name'], $json_path)) {
            die("Error al subir el archivo JSON.");
        }
    }

    // Verificar si al menos un archivo fue subido
    if (!$pdf_path && !$json_path) {
        die("Debe adjuntar al menos un archivo PDF o JSON.");
    }

    // Guardar en la base de datos
    $sql = "INSERT INTO tbl_Comprobantes_Venta 
            (empresa_id, tipo_comprobante_id, numero, fecha, monto, cliente, archivo_pdf, archivo_json, created_at) 
            VALUES 
            (:empresa_id, :tipo_comprobante, :numero_comprobante, :fecha_comprobante, :monto, :cliente, :archivo_pdf, :archivo_json, NOW())";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':empresa_id', $empresa_id);
        $stmt->bindParam(':tipo_comprobante', $tipo_comprobante);
        $stmt->bindParam(':numero_comprobante', $numero_comprobante);
        $stmt->bindParam(':fecha_comprobante', $fecha_comprobante);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':cliente', $cliente);

        // Asignar NULL si no se subió archivo
        $stmt->bindValue(':archivo_pdf', $pdf_path ? $pdf_path : NULL, PDO::PARAM_STR);
        $stmt->bindValue(':archivo_json', $json_path ? $json_path : NULL, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header('Location: ../../views/sales/indexSales.php');
            exit;
        } else {
            die("Error al registrar el comprobante.");
        }
    } catch (PDOException $e) {
        die("Error al registrar el comprobante: " . $e->getMessage());
    }
}
?>
