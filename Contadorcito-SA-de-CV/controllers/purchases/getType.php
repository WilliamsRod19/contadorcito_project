<?php
// Incluir archivo de configuración y conexión a la base de datos
include '../../config/conf.php';

try {
    // Consulta para obtener los tipos de comprobantes
    $sql = "SELECT id, nombre FROM tbl_TipoComprobante";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $tiposComprobantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los tipos de comprobantes: " . $e->getMessage();
    $tiposComprobantes = [];
}
