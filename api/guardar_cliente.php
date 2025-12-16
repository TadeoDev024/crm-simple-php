<?php
// api/guardar_cliente.php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // 1. Validar que sea petición POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // 2. Validar campos obligatorios
    if (empty($_POST['nombre'])) {
        throw new Exception('El nombre es obligatorio');
    }

    // 3. Sanitización básica (opcional, PDO ya protege SQL Injection, pero limpiamos espacios)
    $nombre   = trim($_POST['nombre']);
    $empresa  = trim($_POST['empresa'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $estado   = trim($_POST['estado'] ?? 'Nuevo');

    // 4. Insertar
    $pdo = getDBConnection();
    $sql = "INSERT INTO clientes (nombre, empresa, email, telefono, estado_venta) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([$nombre, $empresa, $email, $telefono, $estado]);
    
    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>