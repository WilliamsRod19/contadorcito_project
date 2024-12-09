<?php
// Incluir archivo de configuración y conexión a la base de datos
include '../../config/conf.php';

try {
    // Consulta para obtener los tipos de comprobantes relacionados con ventas
    $sql = "SELECT id, nombre FROM tbl_TipoComprobante"; // Cambia el nombre de la tabla si es necesario
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $tiposComprobantes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Cambiar el nombre de la variable para reflejar "venta"
} catch (PDOException $e) {
    echo "Error al obtener los tipos de comprobantes de ventas: " . $e->getMessage();
    $tiposComprobantes = [];
}
?>
