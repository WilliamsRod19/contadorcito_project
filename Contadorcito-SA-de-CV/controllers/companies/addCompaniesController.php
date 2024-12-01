<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $tipo_empresa_id = $_POST['tipo_empresa_id'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Preparar la consulta SQL para insertar la nueva empresa
    $sql = "INSERT INTO tbl_Empresas (nombre, tipo_empresa_id, direccion, telefono, email, created_at) 
            VALUES (:nombre, :tipo_empresa_id, :direccion, :telefono, :email, NOW())";

    try {
        // Preparar y ejecutar la consulta
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':tipo_empresa_id', $tipo_empresa_id);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al listado de empresas después de registrar
            header('Location: ../../views/companies/indexCompanies.php');
            exit;
        } else {
            echo "Error al registrar la empresa";
        }
    } catch (PDOException $e) {
        echo "Error al registrar la empresa: " . $e->getMessage();
    }
}
?>
