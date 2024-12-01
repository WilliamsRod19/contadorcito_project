<?php
// Incluir archivo de configuración para la conexión a la base de datos
include '../../config/conf.php';

// Verificar si se ha enviado el ID del usuario desde el formulario
if (isset($_POST['id'])) {
    $usuario_id = $_POST['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM tbl_Usuarios WHERE id = :id";

    try {
        // Preparar la consulta
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id', $usuario_id);

        // Ejecutar la eliminación
        $stmt->execute();

        // Redirigir de vuelta al listado de usuarios
        header("Location: ../../views/users/indexUsers.php");
        exit;
    } catch (PDOException $e) {
        echo "Error al eliminar el usuario: " . $e->getMessage();
    }
} else {
    echo "No se proporcionó el ID del usuario.";
}
?>
