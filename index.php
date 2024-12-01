<?php
include_once "./Contadorcito-SA-de-CV/config/conf.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_POST['user']) ? $_POST['user'] : "";
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : "";

    try {
        // Consulta ajustada para las tablas tbl_Usuarios y tbl_Roles
        $query = "
            SELECT u.id AS id_usuario, u.nombre, u.usuario, u.clave, r.nombre_rol 
            FROM tbl_Usuarios u 
            INNER JOIN tbl_Roles r ON u.id_rol = r.id_rol 
            WHERE u.usuario = :user";
        
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $userFound = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Verificar si se encontró el usuario
        if ($userFound) {
            // Debug: Verificar la contraseña
            if (password_verify($pwd, $userFound["clave"])) {
                echo "Contraseña correcta<br>";
                
                session_start();
                $_SESSION["user"] = $userFound['nombre_rol'];
                $_SESSION["userID"] = $userFound['id_usuario'];
                $_SESSION["username"] = $userFound['nombre'];

                // Redireccionar según el rol del usuario
                if ($userFound['nombre_rol'] == 'Administrador') {
                    header('Location: ./Contadorcito-SA-de-CV/views/template/header.php');
                    exit();
                } elseif ($userFound['nombre_rol'] == 'Auxiliar') {
                    header('Location: ./Contadorcito-SA-de-CV/views/template/header.php');
                    exit();
                } else {
                    echo "Rol no reconocido: " . $userFound['nombre_rol'] . "<br>";
                }
            } else {
                echo "Contraseña incorrecta<br>";
            }
        } else {
            echo "Usuario no encontrado en la base de datos<br>";
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage() . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./Contadorcito-SA-de-CV/css/login.css">
    <title>Login Contadorcito SA de CV</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 m-1">
            <div class="col-md-6 col-sm-8 col-xl-4 col-lg-5 formulario">
                <form action="" method="POST">
                    <div class="form-group text-center pt-3">
                        <h1 class="text-light">Iniciar Sesion</h1>
                    </div>
                    <div class="form-group mx-sm-4 pt-3">
                        <input type="text" class="form-control" required name="user" placeholder="Usuario">
                    </div>
                    <div class="form-group mx-sm-4 pb-4">
                        <input type="password" class="form-control" required name="pwd" placeholder="Contraseña">
                    </div>
                    <div class="form-group mx-sm-4 pb-3">
                        <button type="submit" class="btn btn-block ingresar" value="Ingresar">Ingresar</button>
                    </div>
                    <div class="form-group mx-sm-4 text-center pb-5">
                        <span><a class="olvide" href="#">Olvidaste tu contraseña?</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>