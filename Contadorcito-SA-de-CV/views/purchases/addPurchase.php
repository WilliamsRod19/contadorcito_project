<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != "Administrador") {
    header("Location: ../../index.php");
    exit();
}
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registrar Comprobante de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../template/header.php">Contadorcito App</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!--VACIO-->
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../../controllers/login/logout.php">Cerrar Sesion</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Herramientas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="../companies/indexCompanies.php">
                                    Empresas
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>

                                <!-- SECCION 2 solo visible para administradores -->
                                <?php if ($_SESSION["user"] == "Administrador") { ?>
                                    <a class="nav-link collapsed" href="../users/indexUsers.php">
                                        Usuarios
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                <?php }; ?>

                                <a class="nav-link collapsed" href="../sales/indexSales.php">
                                    Comprobantes de Ventas
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>

                                <a class="nav-link collapsed" href="../purchases/indexPurchases.php">
                                    Comprobante de Compras
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <?= $_SESSION["username"] ?? "Usuario no autenticado" ?></div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-5">
                    <h1>Registrar Comprobante de Compra</h1>
                    <form method="POST" action="../../controllers/purchases/addPurchaseControler.php" enctype="multipart/form-data" onsubmit="return validateFiles()">
                        <div class="mb-3">
                            <label for="empresa" class="form-label">Empresa</label>
                            <select name="empresa_id" id="empresa" class="form-control" required>
                                <option value="" selected>Seleccione una empresa</option>
                                <?php
                                // Obtener las empresas desde el controlador
                                include '../../controllers/companies/getCompanies.php';

                                // Iterar sobre las empresas y mostrarlas en el dropdown
                                foreach ($empresas as $empresa): ?>
                                    <option value="<?=($empresa['id']) ?>"><?=($empresa['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_comprobante" class="form-label">Tipo de Comprobante</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" required>
                                <option value="1">Crédito Fiscal</option>
                                <option value="2">Consumidor Final</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="numero_comprobante" class="form-label">Número de Comprobante</label>
                            <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_comprobante" class="form-label">Fecha del Comprobante</label>
                            <input type="date" name="fecha_comprobante" id="fecha_comprobante" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" name="monto" id="monto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <input type="text" name="proveedor" id="proveedor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="archivo_pdf" class="form-label">Adjuntar PDF</label>
                            <input type="file" name="archivo_pdf" id="archivo_pdf" class="form-control" accept=".pdf">
                        </div>
                        <div class="mb-3">
                            <label for="archivo_json" class="form-label">Adjuntar JSON</label>
                            <input type="file" name="archivo_json" id="archivo_json" class="form-control" accept=".json">
                        </div>
                        <button type="submit" class="btn btn-success">Registrar Comprobante</button>
                    </form>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script>
        function validateFiles() {
            const pdfFile = document.getElementById('archivo_pdf').files.length;
            const jsonFile = document.getElementById('archivo_json').files.length;
            
            if (pdfFile === 0 && jsonFile === 0) {
                alert('Por favor, adjunte al menos un archivo PDF o JSON.');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>

</html>
