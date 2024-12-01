<?php
// Incluir archivo de configuración
include '../../config/conf.php';


// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario']; // Usuario
    $password = $_POST['password']; // Nueva contraseña (si se proporciona)
    $activo = isset($_POST['Estado']) ? $_POST['Estado'] : 1;
    $id_rol = $_POST['rol']; // Rol del usuario

    echo "<script>console.log('$id_rol $activo')</script>";

    // Preparar la consulta SQL básica para actualizar los datos del usuario (sin la contraseña)
    $sql = "UPDATE tbl_Usuarios SET 
            nombre = :nombre,
            email = :email,
            usuario = :usuario,
            activo = :activo,
            id_rol = :id_rol";
    
    // Solo agregar la actualización de la contraseña si se ha proporcionado una nueva contraseña
    if (!empty($password)) {
        // Si se proporciona una nueva contraseña, hashea la nueva contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", clave = :clave";  // Incluir la actualización de la contraseña en la consulta
    }
    
    $sql .= " WHERE id = :id";  // Asegúrate de que la consulta termine correctamente
    
    try {
        // Preparar la consulta SQL
        $stmt = $connection->prepare($sql);
        
        // Asignar los parámetros
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':id_rol', $id_rol);
        
        // Si se proporciona una nueva contraseña, también la asignamos
        if (!empty($password)) {
            $stmt->bindParam(':clave', $hashedPassword);
        }
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al listado de usuarios después de la actualización
            header('Location: ../../views/users/indexUsers.php');
            exit;
        } else {
            echo "Error al actualizar el usuario";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar el usuario: " . $e->getMessage();
    }
}
?>
