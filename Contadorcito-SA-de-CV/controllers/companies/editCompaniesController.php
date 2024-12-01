<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $tipo_empresa_id = $_POST['tipo_empresa_id'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Preparar la consulta SQL para actualizar la empresa
    $sql = "UPDATE tbl_Empresas SET 
            nombre = :nombre,
            tipo_empresa_id = :tipo_empresa_id,
            direccion = :direccion,
            telefono = :telefono,
            email = :email
            WHERE id = :id";

    try {
        // Preparar y ejecutar la consulta
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':tipo_empresa_id', $tipo_empresa_id);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al listado de empresas después de la actualización
            header('Location: ../../views/companies/indexCompanies.php');
            exit;
        } else {
            echo "Error al actualizar la empresa";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar la empresa: " . $e->getMessage();
    }
}
?>
