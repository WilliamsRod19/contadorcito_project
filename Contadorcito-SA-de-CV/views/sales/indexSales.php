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
    <link href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
            <div class="container-fluid mt-4 p-5">
                    <h1 class="mb-4">Gestión de Comprobantes de Venta</h1>

                    <!-- Botón para Agregar Comprobante -->
                    <div class="mb-4 d-flex justify-content-start">
                        <a href="../../views/sales/addSales.php" class="btn btn-success">
                            <i class="fas fa-plus"></i> Agregar Comprobante
                        </a>
                    </div>

                    <!-- Formulario de Búsqueda -->
                    <form method="POST" action="" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar comprobante..." value="<?= htmlspecialchars($search ?? '') ?>">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>

                    <!-- Tabla de Comprobantes de Venta -->
                    <table class="table table-bordered" id="salesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Empresa</th>
                                <th>Tipo de Comprobante</th>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Cliente</th>
                                <th>Archivo PDF</th>
                                <th>Archivo JSON</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../../controllers/sales/indexSalesController.php';
                            foreach ($comprobantes as $comprobante): ?>
                                <tr>
                                    <td><?php echo $comprobante['id']; ?></td>
                                    <td><?php echo htmlspecialchars($comprobante['empresa_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($comprobante['tipo_comprobante']); ?></td>
                                    <td><?php echo htmlspecialchars($comprobante['numero']); ?></td>
                                    <td><?php echo htmlspecialchars($comprobante['fecha']); ?></td>
                                    <td><?php echo htmlspecialchars($comprobante['monto']); ?></td>
                                    <td><?php echo htmlspecialchars($comprobante['cliente']); ?></td>                                    
                                    <td>
                                        <?php if ($comprobante['archivo_pdf']): ?>
                                            <a href="<?= htmlspecialchars($comprobante['archivo_pdf']); ?>" target="_blank">Ver PDF</a>
                                        <?php else: ?>
                                            No disponible
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($comprobante['archivo_json']): ?>
                                            <a href="<?= htmlspecialchars($comprobante['archivo_json']); ?>" target="_blank">Ver JSON</a>
                                        <?php else: ?>
                                            No disponible
                                        <?php endif; ?>
                                    </td>
                                        
                                    <td><?php echo htmlspecialchars($comprobante['created_at']); ?></td>
                                    <td>
                                        <!-- Botón de Editar -->
                                        <a href="../../controllers/sales/getSaleById.php?id=<?= $comprobante['id'] ?>&action=edit"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <!-- Botón de Eliminar -->
                                        <a href="../../controllers/sales/getSaleById.php?id=<?= $comprobante['id'] ?>&action=delete"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este comprobante?')">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                    </td>
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
    <script src="../../js/datatables-simple-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        // Add date range filter for sales table
        function addDateRangeFilter() {
            // Create date filter container
            const filterContainer = document.createElement('div');
            filterContainer.innerHTML = `
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="min-date" class="form-label fw-bold">Fecha Inicial:</label>
                            <input type="date" id="min-date" class="form-control ">
                        </div>
                        <div class="col-md-6">
                            <label for="max-date" class="form-label fw-bold">Fecha Final:</label>
                            <input type="date" id="max-date" class="form-control ">
                        </div>
                    </div>
                </div>
            `;


            // Insert the filter container before the table
            const tableContainer = document.querySelector('#salesTable');
            tableContainer.parentNode.insertBefore(filterContainer, tableContainer);

            // Initialize DataTable with date range filtering
            const table = $("#salesTable").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5', 
                        orientation: 'landscape', 
                        pageSize: 'A4',
                        title: 'Reporte de Compras',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                columnDefs: [{
                    targets: <?php echo ($_SESSION["user"] == "Administrador") ? 10 : 9; ?>,
                    orderable: false,
                    searchable: false
                }],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });

            // Custom date range filtering for the Date (Fecha) column
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const minDateStr = document.getElementById('min-date').value;
                    const maxDateStr = document.getElementById('max-date').value;
                    
                    // Index of the date column (adjust if needed, in this case it's the 4th column - index 4)
                    const dateColumnIndex = 4; 
                    const rowDate = data[dateColumnIndex];

                    // If no date range is set, show all rows
                    if (!minDateStr && !maxDateStr) {
                        return true;
                    }

                    // Parse dates
                    const rowDateTime = new Date(rowDate).getTime();
                    const minDateTime = minDateStr ? new Date(minDateStr).getTime() : null;
                    const maxDateTime = maxDateStr ? new Date(maxDateStr).getTime() : null;

                    // Filtering logic
                    if (minDateTime && maxDateTime) {
                        return rowDateTime >= minDateTime && rowDateTime <= maxDateTime;
                    } else if (minDateTime) {
                        return rowDateTime >= minDateTime;
                    } else if (maxDateTime) {
                        return rowDateTime <= maxDateTime;
                    }

                    return true;
                }
            );

            // Trigger filtering when date inputs change
            document.getElementById('min-date').addEventListener('change', function() {
                table.draw();
            });

            document.getElementById('max-date').addEventListener('change', function() {
                table.draw();
            });
        }

        // Call the function when the document is ready
        document.addEventListener('DOMContentLoaded', addDateRangeFilter);
    </script>
    
</body>

</html>