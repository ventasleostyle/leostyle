<?php
require_once __DIR__ . '/UsuarioController.php';

$controlador = new UsuarioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'crear') {
        $ok = $controlador->crear($_POST['nombre'], $_POST['correo'], $_POST['password'], intval($_POST['rol_id']), intval($_POST['estado']));
        header("Location: /leo-style/views/Usuario/Listar.php?estado=" . ($ok ? "ok" : "error") . "&msg=" . ($ok ? "Usuario creado" : "Correo ya existe"));
        exit;
    }

    if ($accion === 'editar') {
        $ok = $controlador->editar(intval($_POST['id']), $_POST['nombre'], $_POST['correo'], $_POST['password'] ?: null, intval($_POST['rol_id']), intval($_POST['estado']));
        header("Location: /leo-style/views/Usuario/Listar.php?estado=" . ($ok ? "ok" : "error") . "&msg=" . ($ok ? "Usuario actualizado" : "Correo ya existe"));
        exit;
    }

    if ($accion === 'eliminar') {
        $ok = $controlador->eliminar(intval($_POST['id']));
        header("Location: /leo-style/views/Usuario/Listar.php?estado=" . ($ok ? "ok" : "error") . "&msg=" . ($ok ? "Usuario eliminado" : "Error al eliminar"));
        exit;
    }
}
