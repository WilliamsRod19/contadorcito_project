<?php
// Inicializar variable de búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Incluir archivo de configuración para conexión
include '../../config/conf.php';

// Consulta SQL para obtener los comprobantes de compra con sus relaciones
$sql = "SELECT cc.id, emp.nombre AS nombre_empresa, tc.nombre AS nombre_tipoComprobantes, 
               cc.numero, cc.fecha, cc.monto, cc.proveedor, cc.archivo_pdf, cc.archivo_json, 
               cc.created_at
        FROM tbl_Comprobantes_Compra cc
        INNER JOIN tbl_Empresas emp ON cc.empresa_id = emp.id
        INNER JOIN tbl_TipoComprobante tc ON cc.tipo_comprobante_id = tc.id
        ORDER BY cc.id ASC";

// Agregar condiciones de búsqueda si se proporcionó un término
if (!empty($search)) {
    $sql .= " WHERE emp.nombre LIKE :search 
              OR tc.nombre LIKE :search 
              OR cc.numero LIKE :search 
              OR cc.proveedor LIKE :search";
}

try {
    // Preparar consulta
    $stmt = $connection->prepare($sql);
    
    // Asignar parámetros si se busca algo
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    
    // Ejecutar consulta
    $stmt->execute();
    $comprobantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener la lista de comprobantes de compra: " . $e->getMessage();
}
?>
