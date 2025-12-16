<?php
// guardar_cliente.php
require_once 'conexion.php';
header('Content-Type: application/json'); // Importante para que JS entienda la respuesta

try {
    $stmt = $pdo->prepare("INSERT INTO clientes (nombre, empresa, email, telefono, estado_venta) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nombre'],
        $_POST['empresa'],
        $_POST['email'],
        $_POST['telefono'],
        $_POST['estado']
    ]);
    
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}