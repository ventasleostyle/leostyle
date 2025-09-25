<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Rol.php';

class UsuarioController {
    private Usuario $modelo;
    private Rol $modeloRol;

    public function __construct() {
        $this->modelo = new Usuario();
        $this->modeloRol = new Rol();
    }

    // Listar usuarios
    public function listar(): array {
        return $this->modelo->listar();
    }

    // Listar roles (para los selects)
    public function listarRoles(): array {
        return $this->modeloRol->listar();
    }

    // Crear usuario
    public function crear(string $nombre, string $correo, string $password, int $rol_id, int $estado = 1): int|false {
        if ($this->modelo->existeCorreo($correo)) {
            return false; // Correo duplicado
        }
        return $this->modelo->crear($nombre, $correo, $password, $rol_id, $estado);
    }

    // Editar usuario
    public function editar(int $id, string $nombre, string $correo, ?string $password, int $rol_id, int $estado): bool {
        if ($this->modelo->existeCorreo($correo, $id)) {
            return false; // Correo duplicado
        }
        return $this->modelo->editar($id, $nombre, $correo, $password, $rol_id, $estado);
    }

    // Eliminar usuario
    public function eliminar(int $id): bool {
        return $this->modelo->eliminar($id);
    }

    // Obtener usuario por ID
    public function obtenerPorId(int $id): ?array {
        return $this->modelo->obtenerPorId($id);
    }
}
