<?php
require_once __DIR__ . '/../models/Rol.php';

class RolController {
    private Rol $modelo;

    public function __construct() {
        $this->modelo = new Rol();
    }

    // LISTAR
    public function listar(): array {
        return $this->modelo->listar();
    }

    // CREAR
    public function crear(string $nombre, ?string $descripcion): int|false {
        if ($this->modelo->existeNombre($nombre)) {
            return false; // ya existe
        }
        return $this->modelo->crear($nombre, $descripcion);
    }

    // EDITAR
    public function editar(int $id, string $nombre, ?string $descripcion): bool {
        if ($this->modelo->existeNombre($nombre, $id)) {
            return false; // nombre duplicado
        }
        return $this->modelo->editar($id, $nombre, $descripcion);
    }

    // ELIMINAR
    public function eliminar(int $id): bool {
        return $this->modelo->eliminar($id);
    }

    // OBTENER POR ID
    public function obtenerPorId(int $id): ?array {
        return $this->modelo->obtenerPorId($id);
    }
}
