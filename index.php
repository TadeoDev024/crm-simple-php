<?php
// 1. Incluir el archivo de conexión
require_once 'conexion.php';

try {
    // 2. Preparar y ejecutar la consulta
    // Ordenamos por ID descendente para ver los más recientes primero
    $sql = "SELECT * FROM clientes ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    
    // Obtenemos todos los datos en un array asociativo
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Contamos clientes para el KPI de la tarjeta superior
    $totalClientes = count($clientes);

} catch (PDOException $e) {
    die("Error al cargar datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Dashboard | PHP + MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; width: 260px; background: #212529; color: #fff; }
        .nav-link { color: #adb5bd; }
        .nav-link:hover, .nav-link.active { color: #fff; background-color: rgba(255,255,255,0.1); }
        @media (max-width: 768px) { .d-flex { flex-direction: column; } .sidebar { width: 100%; min-height: auto; } }
    </style>
</head>
<body>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="bi bi-rocket-takeoff-fill me-2 fs-4"></i><span class="fs-4 fw-bold">Mi CRM</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li><a href="#" class="nav-link"><i class="bi bi-people me-2"></i> Clientes</a></li>
            </ul>
        </div>

        <main class="w-100 p-4 overflow-auto">
            
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Resumen General</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-lg"></i> Nuevo Cliente</button>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Clientes</h6>
                                <h2 class="mb-0 fw-bold"><?php echo $totalClientes; ?></h2>
                            </div>
                            <div class="text-primary fs-1 opacity-25"><i class="bi bi-people-fill"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6 class="text-muted mb-1">Ventas Mes</h6><h2 class="mb-0 fw-bold text-success">$45,200</h2></div>
                            <div class="text-success fs-1 opacity-25"><i class="bi bi-graph-up-arrow"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6 class="text-muted mb-1">Pendientes</h6><h2 class="mb-0 fw-bold text-warning">5</h2></div>
                            <div class="text-warning fs-1 opacity-25"><i class="bi bi-exclamation-circle-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-gray-800">Listado de Clientes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">ID</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Contacto</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col" class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($totalClientes > 0): ?>
                                    <?php foreach($clientes as $cliente): ?>
                                        
                                        <?php 
                                            $badgeColor = match($cliente['estado_venta']) {
                                                'Nuevo' => 'bg-info text-dark',
                                                'Contactado' => 'bg-primary',
                                                'Negociación' => 'bg-warning text-dark',
                                                'Cerrado - Ganado' => 'bg-success',
                                                'Cerrado - Perdido' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        ?>

                                        <tr>
                                            <td class="ps-4 text-muted">#<?= $cliente['id'] ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($cliente['nombre']) ?></div>
                                                <small class="text-muted">Creado: <?= date('d/m/Y', strtotime($cliente['fecha_creacion'])) ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($cliente['empresa']) ?></td>
                                            <td>
                                                <div class="small"><?= htmlspecialchars($cliente['email']) ?></div>
                                                <div class="small text-muted"><?= htmlspecialchars($cliente['telefono']) ?></div>
                                            </td>
                                            <td>
                                                <span class="badge <?= $badgeColor ?>">
                                                    <?= htmlspecialchars($cliente['estado_venta']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="#" class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></a>
                                                <a href="#" class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No hay clientes registrados.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
    div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formNuevoCliente">
          <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Empresa</label>
            <input type="text" name="empresa" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Nuevo">Nuevo</option>
                <option value="Contactado">Contactado</option>
                <option value="Negociación">Negociación</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="js/main.js"></script>
</html>