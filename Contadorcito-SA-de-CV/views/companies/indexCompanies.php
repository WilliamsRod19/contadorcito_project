<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "Administrador") {
    header("Location: ../../index.php");
    exit();
}
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
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
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Contadorcito App</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!--VACIO--->
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
                                <!-- SECCION 1 -->
                                <a class="nav-link collapsed" href="../companies/indexCompanies.php">
                                    Empresas
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>

                                <?php if ($_SESSION["user"] == "Administrador") { ?>
                                    <!-- SECCION 2 -->
                                    <a class="nav-link collapsed" href="../users/indexUsers.php">
                                        Usuarios
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                <?php }; ?>
                                <!-- SECCION 3 -->
                                <a class="nav-link collapsed" href="#">
                                    Comprobantes de Ventas
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <!-- SECCION 3 -->
                                <a class="nav-link collapsed" href="#">
                                    Comprobante de Compras
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?= $_SESSION["username"] ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-4 p-5">
                    <h1 class="mb-4">Gestión de Empresas</h1>

                    <!-- Botón de Crear Empresa -->
                    <a href="../companies/addCompanies.php" class="btn btn-success mb-4">
                        <i class="fas fa-plus"></i> Crear Empresa
                    </a>

                    <!-- Formulario de Búsqueda -->
                    <form method="POST" action="" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar empresa..." value="<?= htmlspecialchars($search ?? '') ?>">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>

                    <!-- Tabla de Empresas -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../../controllers/companies/indexCompaniesController.php'; // Controlador de empresas
                            foreach ($empresas as $empresa): ?>
                                <tr>
                                    <td><?php echo $empresa['id']; ?></td>
                                    <td><?php echo htmlspecialchars($empresa['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['tipo']); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['direccion'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['telefono'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['email'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($empresa['created_at']); ?></td>

                                    <?php if ($_SESSION["user"] == "Administrador"): ?>
                                        <td>
                                            <a href="../../controllers/companies/getCompanyById.php?action=edit&id=<?php echo $empresa['id']; ?>" class="btn btn-primary btn-action">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <a href="../../controllers/companies/getCompanyById.php?action=delete&id=<?php echo $empresa['id']; ?>" class="btn btn-danger btn-action" onclick="return confirm('¿Está seguro de eliminar esta empresa?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
</body>

</html>