<?php
// Incluir archivo de configuración y conexión
include '../../config/conf.php';

// Función para eliminar los archivos asociados
function deleteFiles($archivo_pdf, $archivo_json) {
    // Eliminar archivo PDF si existe
    if ($archivo_pdf && file_exists($archivo_pdf)) {
        unlink($archivo_pdf);
    }

    // Eliminar archivo JSON si existe
    if ($archivo_json && file_exists($archivo_json)) {
        unlink($archivo_json);
    }
}

// Verificar si se ha pasado el ID y la acción
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_comprobante = $_GET['id'];

    // Obtener los detalles del comprobante para obtener los archivos
    $sql = "SELECT archivo_pdf, archivo_json FROM tbl_Comprobantes_Compra WHERE id = :id_comprobante";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id_comprobante', $id_comprobante, PDO::PARAM_INT);
    $stmt->execute();
    $comprobante = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comprobante) {
        // Llamar a la función para eliminar los archivos
        deleteFiles($comprobante['archivo_pdf'], $comprobante['archivo_json']);

        // Ahora eliminar el comprobante de la base de datos
        $sql_delete = "DELETE FROM tbl_Comprobantes_Compra WHERE id = :id_comprobante";
        $stmt_delete = $connection->prepare($sql_delete);
        $stmt_delete->bindParam(':id_comprobante', $id_comprobante, PDO::PARAM_INT);

        if ($stmt_delete->execute()) {
            // Redirigir al listado de comprobantes después de la eliminación
            header('Location: ../../views/purchases/indexPurchases.php');
            exit;
        } else {
            die("Error al eliminar el comprobante.");
        }
    } else {
        die("Comprobante no encontrado.");
    }
} else {
    // Si no se pasa un ID o la acción no es 'delete', redirigir
    header('Location: ../../views/purchases/indexPurchases.php');
    exit;
}
?>
