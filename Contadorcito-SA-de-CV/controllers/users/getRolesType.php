<?php
// Incluir archivo de configuración
include '../../config/conf.php';

try {
    // Consultar los roles disponibles en la base de datos
    $sql = "SELECT * FROM tbl_Roles";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    
    // Obtener los roles
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Si hay un error en la consulta
    echo "Error al obtener los roles: " . $e->getMessage();
}
?>
