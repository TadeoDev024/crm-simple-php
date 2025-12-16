<?php
require_once 'config/database.php';

// Lógica de datos al principio
$pdo = getDBConnection();
$stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
$clientes = $stmt->fetchAll();
$totalClientes = count($clientes);

// Inicio de la vista
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<main class="w-100 p-4 overflow-auto">
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Resumen General</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-lg"></i> Nuevo Cliente
            </button>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Clientes</h6>
                        <h2 class="mb-0 fw-bold"><?= $totalClientes ?></h2>
                    </div>
                    <div class="text-primary fs-1 opacity-25"><i class="bi bi-people-fill"></i></div>
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
                                    </td>
                                    <td><span class="badge <?= $badgeColor ?>"><?= htmlspecialchars($cliente['estado_venta']) ?></span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-4">No hay datos.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>