<?php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Bienvenido aqui van los usuarios krnal
</body>
</html>