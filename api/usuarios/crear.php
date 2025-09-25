<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../controllers/UsuarioController.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "No se recibieron datos"]);
    exit;
}

// Instanciamos el controlador
$controller = new UsuarioController();

// Llamamos al método crear del controlador
$resultado = $controller->crear(
    $data['nombre'] ?? '',
    $data['correo'] ?? '',
    $data['password'] ?? '',
    $data['rol_id'] ?? 0,
    $data['estado'] ?? 1
);

if ($resultado === false) {
    echo json_encode(["success" => false, "message" => "No se pudo crear el usuario (correo duplicado o error)"]);
} else {
    echo json_encode(["success" => true, "message" => "Usuario creado correctamente", "id" => $resultado]);
}
