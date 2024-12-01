<?php
// echo "<script>console.log('ok')</script>";
// Incluir archivo de configuración
include '../../config/conf.php';
// Verificar si se ha pasado un ID de usuario a editar
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
    $action = $_GET['action'];

    // Obtener los detalles del usuario
    $sql = "SELECT u.*, r.nombre_rol 
            FROM tbl_Usuarios u
            INNER JOIN tbl_Roles r ON u.id_rol = r.id_rol
            WHERE u.id = :id_usuario";
    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<script>console.log('$id_usuario')</script>";

        if (!$usuario) {
            // Si el usuario no existe, redirigir al listado de usuarios
            //header('Location: ../../views/users/indexUsers.php');
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener el usuario: " . $e->getMessage();
    }

    // Dependiendo de la acción, incluir la vista correspondiente
    if ($action == 'edit') {
        include '../../views/users/editUsers.php'; // Aquí debes incluir la vista de edición de usuario
    } else if ($action == 'delete') {
        include '../../views/users/deleteUsers.php'; // Aquí puedes incluir la vista de eliminación de usuario
    } else {
        throw new Exception("Acción no válida.");
    }
} else {
    // Si no se pasa un ID, redirigir al listado de usuarios
    header('Location: ../../views/users/indexUsers.php');
    exit;
}
