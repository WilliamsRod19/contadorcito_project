<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Verificar si se ha pasado un ID de comprobante y una acción
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id_comprobante = $_GET['id'];
    $action = $_GET['action'];

    // Obtener los detalles del comprobante de venta
    $sql = "SELECT c.*, 
        t.nombre AS nombre_tipo_comprobante, 
        e.nombre AS nombre_empresa
        FROM tbl_Comprobantes_Venta c  
        INNER JOIN tbl_TipoComprobante t ON c.tipo_comprobante_id = t.id 
        INNER JOIN tbl_Empresas e ON c.empresa_id = e.id
        WHERE c.id = :id_comprobante;
        ";
    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id_comprobante', $id_comprobante, PDO::PARAM_INT);
        $stmt->execute();
        $comprobante = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$comprobante) {
            // Si el comprobante no existe, redirigir al listado de ventas
            header('Location: ../../views/sales/indexSales.php'); 
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener el comprobante de venta: " . $e->getMessage();
        exit;
    }

    // Manejar la acción solicitada
    if ($action == 'edit') {
        include '../../views/sales/editSales.php';
    } elseif ($action == 'delete') {
        include '../../views/sales/deleteSales.php';  
    } else {
        throw new Exception("Acción no válida.");
    }
} else {
    // Si no se pasa un ID o acción, redirigir al listado de ventas
    header('Location: ../../views/sales/indexSales.php');  
    exit;
}
?>
