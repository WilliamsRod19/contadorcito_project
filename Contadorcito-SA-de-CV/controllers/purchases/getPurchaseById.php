<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Verificar si se ha pasado un ID de comprobante y una acción
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id_comprobante = $_GET['id'];
    $action = $_GET['action'];

    // Obtener los detalles del comprobante
    $sql = "SELECT c.*, 
        t.nombre AS nombre_tipo_comprobante, 
        e.nombre AS nombre_empresa
        FROM tbl_Comprobantes_Compra c
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
            // Si el comprobante no existe, redirigir al listado
            header('Location: ../../views/purchases/indexPurchases.php');
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener el comprobante: " . $e->getMessage();
        exit;
    }

    // Manejar la acción solicitada
    if ($action == 'edit') {
        include '../../views/purchases/editPurchase.php';
    } elseif ($action == 'delete') {
        include '../../views/purchases/deletePurchase.php';
    } else {
        throw new Exception("Acción no válida.");
    }
} else {
    // Si no se pasa un ID o acción, redirigir al listado
    header('Location: ../../views/purchases/indexPurchases.php');
    exit;
}
