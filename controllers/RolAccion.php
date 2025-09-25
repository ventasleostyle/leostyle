<?php
// ===============================================
// CONTROLADOR DE ACCIONES DE ROL
// Separa la lógica de Crear / Editar / Eliminar
// ===============================================

require_once __DIR__ . '/RolController.php';

$controlador = new RolController();
$accion = $_POST['accion'] ?? null;

// ===============================================
// CREAR
// ===============================================
if ($accion === 'crear') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion'] ?? '');

    $id = $controlador->crear($nombre, $descripcion);

    if ($id) {
        header("Location: ../views/Rol/Listar.php?estado=ok&msg=Rol%20creado");
    } else {
        header("Location: ../views/Rol/Listar.php?estado=error&msg=No%20se%20pudo%20crear%20(el%20nombre%20ya%20existe)");
    }
    exit;
}

// ===============================================
// EDITAR
// ===============================================
if ($accion === 'editar') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    $ok = $controlador->editar($id, $nombre, $descripcion);

    if ($ok) {
        header("Location: ../views/Rol/Listar.php?estado=ok&msg=Rol%20actualizado");
    } else {
        header("Location: ../views/Rol/Listar.php?estado=error&msg=No%20se%20pudo%20actualizar");
    }
    exit;
}

// ===============================================
// ELIMINAR
// ===============================================
if ($accion === 'eliminar') {
    $id = intval($_POST['id']);

    $ok = $controlador->eliminar($id);

    if ($ok) {
        header("Location: ../views/Rol/Listar.php?estado=ok&msg=Rol%20eliminado");
    } else {
        header("Location: ../views/Rol/Listar.php?estado=error&msg=No%20se%20pudo%20eliminar");
    }
    exit;
}

// ===============================================
// SI NO VIENE UNA ACCIÓN VÁLIDA
// ===============================================
header("Location: ../views/Rol/Listar.php?estado=error&msg=Acci%C3%B3n%20no%20reconocida");
exit;
