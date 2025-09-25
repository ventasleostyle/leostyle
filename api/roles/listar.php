<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../../controllers/RolController.php';

$controller = new RolController();
$roles = $controller->listar();

// Reducir salida solo a id y nombre
$resultado = array_map(function($r) {
    return [
        "id" => $r['rol_id'],
        "nombre" => $r['rol_nombre']
    ];
}, $roles);

echo json_encode([
    "success" => true,
    "data" => $resultado
]);
