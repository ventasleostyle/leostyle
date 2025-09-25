<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Listar todos los usuarios con su rol
    public function listar(): array {
        $sql = "SELECT u.usu_id, u.usu_nombre, u.usu_correo, u.usu_estado,
                       r.rol_nombre
                FROM usuarios u
                INNER JOIN roles r ON u.rol_id = r.rol_id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear usuario
    public function crear(string $nombre, string $correo, string $password, int $rol_id, int $estado = 1): int|false {
        $sql = "INSERT INTO usuarios (usu_nombre, usu_correo, usu_password, rol_id, usu_estado)
                VALUES (:nombre, :correo, :password, :rol_id, :estado)";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            ":nombre" => $nombre,
            ":correo" => $correo,
            ":password" => md5($password), // ⚠️ Se usa MD5 como en roles iniciales
            ":rol_id" => $rol_id,
            ":estado" => $estado
        ]);
        return $ok ? $this->db->lastInsertId() : false;
    }

    // Editar usuario
    public function editar(int $id, string $nombre, string $correo, ?string $password, int $rol_id, int $estado): bool {
        if ($password) {
            $sql = "UPDATE usuarios
                    SET usu_nombre = :nombre, usu_correo = :correo, usu_password = :password,
                        rol_id = :rol_id, usu_estado = :estado
                    WHERE usu_id = :id";
            $params = [
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":password" => md5($password),
                ":rol_id" => $rol_id,
                ":estado" => $estado,
                ":id" => $id
            ];
        } else {
            $sql = "UPDATE usuarios
                    SET usu_nombre = :nombre, usu_correo = :correo,
                        rol_id = :rol_id, usu_estado = :estado
                    WHERE usu_id = :id";
            $params = [
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":rol_id" => $rol_id,
                ":estado" => $estado,
                ":id" => $id
            ];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar usuario
    public function eliminar(int $id): bool {
        $sql = "DELETE FROM usuarios WHERE usu_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    // Obtener por ID
    public function obtenerPorId(int $id): ?array {
        $sql = "SELECT * FROM usuarios WHERE usu_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Comprobar si el correo ya existe (para evitar duplicados)
    public function existeCorreo(string $correo, ?int $id = null): bool {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE usu_correo = :correo";
        if ($id) {
            $sql .= " AND usu_id != :id";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":correo", $correo);
        if ($id) $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
