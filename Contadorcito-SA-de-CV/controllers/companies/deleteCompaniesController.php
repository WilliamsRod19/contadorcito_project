<?php
// Incluir archivo de configuración para la conexión a la base de datos
include '../../config/conf.php';

// Verificar si se ha enviado el ID de la empresa desde el formulario
if (isset($_POST['id'])) {
    $empresa_id = $_POST['id'];

    // Eliminar la empresa de la base de datos
    $sql = "DELETE FROM tbl_Empresas WHERE id = :id";

    try {
        // Preparar la consulta
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id', $empresa_id);

        // Ejecutar la eliminación
        $stmt->execute();

        // Redirigir de vuelta al listado de empresas
        header("Location: ../../views/companies/indexCompanies.php");
        exit;
    } catch (PDOException $e) {
        echo "Error al eliminar la empresa: " . $e->getMessage();
    }
} else {
    echo "No se proporcionó el ID de la empresa.";
}
?>
