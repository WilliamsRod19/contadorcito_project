<?php
// Inicializar variable de búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Incluir archivo de configuración para conexión
include '../../config/conf.php';

// Consulta SQL básica para la tabla tbl_Usuarios
$sql = "SELECT u.*, r.nombre_rol 
            FROM tbl_Usuarios u
            INNER JOIN tbl_Roles r ON u.id_rol = r.id_rol";

// Agregar condiciones de búsqueda si se proporcionó un término
if (!empty($search)) {
    $sql .= " WHERE nombre LIKE :search OR email LIKE :search OR usuario LIKE :search";
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
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener la lista de usuarios: " . $e->getMessage();
}
?>
