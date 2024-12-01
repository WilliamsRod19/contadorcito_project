<?php
    session_start();
    if ($_SESSION["user"]=="") {
        header("Location: ../views/index.php");
    }
    session_destroy();
    header("Location: ../../../index.php");
?>