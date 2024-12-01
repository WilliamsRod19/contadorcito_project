<?php
// Inicializar variable de búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Incluir archivo de configuración para conexión
include '../../config/conf.php';

// Consulta SQL básica
$sql = "SELECT e.id, e.nombre, t.tipo, e.direccion, e.telefono, e.email, e.created_at
        FROM tbl_empresas AS e
        INNER JOIN tbl_tipoempresa AS t ON e.tipo_empresa_id = t.id";

// Agregar condiciones de búsqueda si se proporcionó un término
if (!empty($search)) {
    $sql .= " WHERE e.nombre LIKE :search OR t.tipo LIKE :search OR e.direccion LIKE :search";
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
    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener la lista de empresas: " . $e->getMessage();
}
?>
