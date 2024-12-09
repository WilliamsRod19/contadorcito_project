<?php
// Incluir el archivo de configuración
include '../../config/conf.php';

// Función para actualizar un comprobante de venta
function updateComprobanteVenta($id, $empresa_id, $tipo_comprobante, $numero_comprobante, $fecha_comprobante, $monto, $cliente, $archivo_pdf, $archivo_json) {
    global $connection;
    $sql = "UPDATE tbl_Comprobantes_Venta SET 
            empresa_id = :empresa_id,
            tipo_comprobante_id = :tipo_comprobante,
            numero = :numero_comprobante,
            fecha = :fecha_comprobante,
            monto = :monto,
            cliente = :cliente,
            archivo_pdf = :archivo_pdf,
            archivo_json = :archivo_json
            WHERE id = :id";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':empresa_id', $empresa_id);
    $stmt->bindParam(':tipo_comprobante', $tipo_comprobante);
    $stmt->bindParam(':numero_comprobante', $numero_comprobante);
    $stmt->bindParam(':fecha_comprobante', $fecha_comprobante);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':cliente', $cliente);
    $stmt->bindParam(':id', $id);
    $stmt->bindValue(':archivo_pdf', $archivo_pdf, PDO::PARAM_STR);
    $stmt->bindValue(':archivo_json', $archivo_json, PDO::PARAM_STR);
    
    return $stmt->execute();
}

// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
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

    // Obtener los detalles del comprobante de venta actual
    $sql = "SELECT archivo_pdf, archivo_json FROM tbl_Comprobantes_Venta WHERE id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $comprobante = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$comprobante) {
        die("Comprobante no encontrado.");
    }

    // Inicializar las variables de archivo
    $pdf_path = $comprobante['archivo_pdf'];  // Mantener el archivo anterior si no se sube uno nuevo
    $json_path = $comprobante['archivo_json'];  // Mantener el archivo anterior si no se sube uno nuevo

    // Manejo de archivos PDF
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == 0) {
        $archivo_pdf = $_FILES['archivo_pdf'];
        if ($archivo_pdf['type'] !== 'application/pdf') {
            die("El archivo debe ser un PDF.");
        }

        // Eliminar archivo PDF anterior si existe y si se sube un nuevo archivo
        if (!empty($comprobante['archivo_pdf'])) {
            unlink('../../uploads/comprobantes/' . basename($comprobante['archivo_pdf'])); // Eliminar archivo antiguo
        }

        // Obtener el nombre original del archivo y mantenerlo
        $pdf_original_name = pathinfo($archivo_pdf['name'], PATHINFO_BASENAME);  // Mantener solo el nombre original con la extensión
        $pdf_path = '../../uploads/comprobantes/' . $pdf_original_name;
        move_uploaded_file($archivo_pdf['tmp_name'], $pdf_path);
    }

    // Eliminar archivo PDF si el usuario decide borrar
    if (isset($_POST['delete_pdf']) && $_POST['delete_pdf'] == 'yes') {
        // Solo eliminar el archivo si no hay un archivo nuevo subido
        if (!isset($_FILES['archivo_pdf']) || $_FILES['archivo_pdf']['error'] != 0) {
            if (!empty($comprobante['archivo_pdf'])) {
                unlink('../../uploads/comprobantes/' . basename($comprobante['archivo_pdf'])); // Eliminar archivo PDF
                $pdf_path = NULL;  // Establecer archivo PDF a NULL en la base de datos
            }
        } else {
            // Si se ha subido un archivo nuevo, no hacer nada con el archivo anterior
            $pdf_path = $_FILES['archivo_pdf']['name'];
        }
    }

    // Manejo de archivos JSON
    if (isset($_FILES['archivo_json']) && $_FILES['archivo_json']['error'] == 0) {
        $archivo_json = $_FILES['archivo_json'];
        if ($archivo_json['type'] !== 'application/json') {
            die("El archivo debe ser un JSON.");
        }

        // Eliminar archivo JSON anterior si existe y si se sube un nuevo archivo
        if (!empty($comprobante['archivo_json'])) {
            unlink('../../uploads/comprobantes/' . basename($comprobante['archivo_json'])); // Eliminar archivo antiguo
        }

        // Obtener el nombre original del archivo y mantenerlo
        $json_original_name = pathinfo($archivo_json['name'], PATHINFO_BASENAME);  // Mantener solo el nombre original con la extensión
        $json_path = '../../uploads/comprobantes/' . $json_original_name;
        move_uploaded_file($archivo_json['tmp_name'], $json_path);
    }

    // Eliminar archivo JSON si el usuario decide borrar
    if (isset($_POST['delete_json']) && $_POST['delete_json'] == 'yes') {
        // Solo eliminar el archivo si no hay un archivo nuevo subido
        if (!isset($_FILES['archivo_json']) || $_FILES['archivo_json']['error'] != 0) {
            if (!empty($comprobante['archivo_json'])) {
                unlink('../../uploads/comprobantes/' . basename($comprobante['archivo_json'])); // Eliminar archivo JSON
                $json_path = NULL;  // Establecer archivo JSON a NULL en la base de datos
            }
        } else {
            // Si se ha subido un archivo nuevo, no hacer nada con el archivo anterior
            $json_path = $_FILES['archivo_json']['name'];
        }
    }

    // Validar que al menos un archivo esté presente (PDF o JSON)
    if (empty($pdf_path) && empty($json_path)) {
        die("Debe subir al menos un archivo (PDF o JSON).");
    }

    // Actualizar el comprobante de venta en la base de datos usando la función de actualización
    if (updateComprobanteVenta($id, $empresa_id, $tipo_comprobante, $numero_comprobante, $fecha_comprobante, $monto, $cliente, $pdf_path, $json_path)) {
        header('Location: ../../views/sales/indexSales.php');
        exit;
    } else {
        die("Error al actualizar el comprobante de venta.");
    }
}
?>
