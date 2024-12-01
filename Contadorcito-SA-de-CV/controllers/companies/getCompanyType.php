<?php
// Incluir archivo de configuración
include '../../config/conf.php';

try {
    // Obtener todos los tipos de empresas
    $sql = "SELECT * FROM tbl_TipoEmpresa";
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    // Almacenar los tipos de empresa
    $tipos_empresa = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los tipos de empresa: " . $e->getMessage();
}
?>
