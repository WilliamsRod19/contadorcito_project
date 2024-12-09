<?php
// Inicializar variable de búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Incluir archivo de configuración para conexión
include '../../config/conf.php';

// Consulta SQL para obtener los comprobantes de venta con sus relaciones
$sql = "SELECT cv.id, emp.nombre AS empresa_nombre, tc.nombre AS tipo_comprobante, 
               cv.numero, cv.fecha, cv.monto, cv.cliente, cv.archivo_pdf, cv.archivo_json, 
               cv.created_at
        FROM tbl_Comprobantes_Venta cv
        INNER JOIN tbl_Empresas emp ON cv.empresa_id = emp.id
        INNER JOIN tbl_TipoComprobante tc ON cv.tipo_comprobante_id = tc.id
        ORDER BY cv.id ASC";

// Agregar condiciones de búsqueda si se proporcionó un término
if (!empty($search)) {
    $sql .= " WHERE emp.nombre LIKE :search 
              OR tc.nombre LIKE :search 
              OR cv.numero LIKE :search 
              OR cv.cliente LIKE :search";
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
    echo "Error al obtener la lista de comprobantes: " . $e->getMessage();
}
?>
