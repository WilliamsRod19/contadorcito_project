<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Verificar si se ha pasado un ID de empresa a editar
if (isset($_GET['id'])) {
    $id_empresa = $_GET['id'];
    $action = $_GET['action'];

    // Obtener los detalles de la empresa
    $sql = "SELECT e.*, t.tipo AS nombre_tipo_empresa
    FROM tbl_Empresas e
    INNER JOIN tbl_TipoEmpresa t ON e.tipo_empresa_id = t.id
    WHERE e.id = :id_empresa;";
    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id_empresa', $id_empresa);
        $stmt->execute();
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$empresa) {
            // Si la empresa no existe, redirigir al listado de empresas
            header('Location: ../../views/companies/indexCompanies.php');
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener la empresa: " . $e->getMessage();
    }
    if ($action == 'edit') {
        include '../../views/companies/editCompanies.php'; // Cambia a tu vista de edición de usuario
    } else if ($action == 'delete') {
        include '../../views/companies/deleteCompanies.php'; // Cambia a tu vista de eliminación de usuario
    } else {
        throw new Exception("Acción no válida.");
    }
} else {
    // Si no se pasa un ID, redirigir al listado de empresas
    header('Location: ../../views/companies/indexCompanies.php');
    exit;
}
