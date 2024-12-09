<?php session_start(); ?>

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
        <a class="navbar-brand ps-3" href="../template/header.php">Contadorcito App</a>
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
                                <a class="nav-link collapsed" href="../sales/indexSales.php">
                                    Comprobantes de Ventas
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <!-- SECCION 3 -->
                                <a class="nav-link collapsed" href="../purchases/indexPurchases.php">
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
                <div class="container mt-4">
                    <h1 class="mb-4">Editar Comprobante de Venta</h1>

                    <!-- Formulario de Edición de Comprobante -->
                    <form method="POST" action="../../controllers/sales/editSalesController.php" enctype="multipart/form-data">
                        <!-- ID oculto -->
                        <input type="hidden" name="id" value="<?= ($comprobante['id']) ?>">

                        <div class="mb-3">
                            <label for="empresa_id" class="form-label">Empresa</label>
                            <select name="empresa_id" id="empresa_id" class="form-control" required>
                                <?php
                                include '../../controllers/companies/getCompanies.php';
                                foreach ($empresas as $empresa): ?>
                                    <option value="<?= htmlspecialchars($empresa['id']) ?>"
                                        <?= $empresa['id'] == $comprobante['empresa_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($empresa['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_comprobante" class="form-label">Tipo de Comprobante</label>
                            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" required>
                                <?php
                                // Incluir el controlador dentro del div
                                include '../../controllers/sales/getType.php';
                                foreach ($tiposComprobantes as $tipo): ?>
                                    <option value="<?= $tipo['id'] ?>" <?= $tipo['id'] == $comprobante['tipo_comprobante_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tipo['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="numero_comprobante" class="form-label">Número de Comprobante</label>
                            <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" value="<?= ($comprobante['numero']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_comprobante" class="form-label">Fecha</label>
                            <input type="date" name="fecha_comprobante" id="fecha_comprobante" class="form-control" value="<?= ($comprobante['fecha']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control" value="<?= ($comprobante['monto']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" name="cliente" id="cliente" class="form-control" value="<?= ($comprobante['cliente']) ?>" required>
                        </div>

                        <!-- Otros campos del formulario -->

                        <div class="mb-3">
                            <label for="archivo_pdf" class="form-label">Archivo PDF Actual</label>
                            <?php if (!empty($comprobante['archivo_pdf'])): ?>
                                <p>Nombre del archivo: <?php echo basename($comprobante['archivo_pdf']); ?></p>
                                <a href="../../uploads/comprobantes/<?php echo basename($comprobante['archivo_pdf']); ?>" target="_blank">Ver PDF</a>
                                <div>
                                    <label for="delete_pdf" class="form-check-label">
                                        <input type="checkbox" name="delete_pdf" value="yes" class="form-check-input"> Eliminar archivo PDF
                                    </label>
                                </div>
                            <?php else: ?>
                                <p>No hay archivo PDF actual.</p>
                            <?php endif; ?>
                            <input type="file" name="archivo_pdf" class="form-control" id="archivo_pdf">
                        </div>

                        <div class="mb-3">
                            <label for="archivo_json" class="form-label">Archivo JSON Actual</label>
                            <?php if (!empty($comprobante['archivo_json'])): ?>
                                <p>Nombre del archivo: <?php echo basename($comprobante['archivo_json']); ?></p>
                                <a href="../../uploads/comprobantes/<?php echo basename($comprobante['archivo_json']); ?>" target="_blank">Ver JSON</a>
                                <div>
                                    <label for="delete_json" class="form-check-label">
                                        <input type="checkbox" name="delete_json" value="yes" class="form-check-input"> Eliminar archivo JSON
                                    </label>
                                </div>
                            <?php else: ?>
                                <p>No hay archivo JSON actual.</p>
                            <?php endif; ?>
                            <input type="file" name="archivo_json" class="form-control" id="archivo_json">
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Comprobante</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
</body>

</html>
