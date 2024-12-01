<?php
// Incluir archivo de configuración
include '../../config/conf.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashear la contraseña
    $id_rol = $_POST['rol'];

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO tbl_Usuarios (nombre, email, usuario, clave, activo, id_rol, created_at) 
            VALUES (:nombre, :email, :usuario, :clave, :activo, :id_rol, NOW())";

    try {
        // Preparar y ejecutar la consulta
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindValue(':activo', ($_POST['Estado'] == 1) ? TRUE : FALSE, PDO::PARAM_BOOL);
        $stmt->bindParam(':id_rol', $id_rol);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al listado de usuarios después de registrar
            header('Location: ../../views/users/indexUsers.php');
            exit;
        } else {
            echo "Error al registrar el usuario.";
        }
    } catch (PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>
