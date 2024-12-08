<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Obtener todas las empresas disponibles
$sql = "SELECT e.id, e.nombre
        FROM tbl_Empresas e";
        
try {
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener las empresas: " . $e->getMessage();
    exit;
}

// Incluir vista para mostrar el formulario de agregar compra (addPurchases.php)
include '../../views/purchases/addPurchases.php';
