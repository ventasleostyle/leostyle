<?php
require_once __DIR__ . '/../config/database.php';

class Rol {
    private PDO $conexion;
    private string $tabla = "roles";

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->getConnection();
    }

    // LISTAR
    public function listar(): array {
        $sql = "SELECT rol_id, rol_nombre, rol_descripcion FROM {$this->tabla} ORDER BY rol_id ASC";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER POR ID
    public function obtenerPorId(int $id): ?array {
        $sql = "SELECT rol_id, rol_nombre, rol_descripcion FROM {$this->tabla} WHERE rol_id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([":id" => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    // VERIFICAR DUPLICADO DE NOMBRE
    public function existeNombre(string $nombre, ?int $excluirId = null): bool {
        $sql = "SELECT COUNT(*) FROM {$this->tabla} WHERE rol_nombre = :nombre";
        $params = [":nombre" => $nombre];
        if ($excluirId !== null) {
            $sql .= " AND rol_id <> :id";
            $params[":id"] = $excluirId;
        }
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($params);
        return (bool)$stmt->fetchColumn();
    }

    // CREAR
    public function crear(string $nombre, ?string $descripcion): int {
        $sql = "INSERT INTO {$this->tabla} (rol_nombre, rol_descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => $descripcion
        ]);
        return (int)$this->conexion->lastInsertId();
    }

    // EDITAR
    public function editar(int $id, string $nombre, ?string $descripcion): bool {
        $sql = "UPDATE {$this->tabla}
                SET rol_nombre = :nombre, rol_descripcion = :descripcion
                WHERE rol_id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => $descripcion,
            ":id" => $id
        ]);
    }

    // ELIMINAR
    public function eliminar(int $id): bool {
        $sql = "DELETE FROM {$this->tabla} WHERE rol_id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}
