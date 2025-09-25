<?php
class Database {
    private $conn;

    public function getConnection() {
        $this->conn = null;

        // Variables de entorno (Render u otro hosting)
        $db_host = getenv("DB_HOST") ?: "127.0.0.1";
        $db_name = getenv("DB_NAME") ?: "leostyle";
        $db_user = getenv("DB_USER") ?: "root";
        $db_pass = getenv("DB_PASS") ?: "";
        $db_port = getenv("DB_PORT") ?: "3306";

        try {
            $this->conn = new PDO(
                "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8",
                $db_user,
                $db_pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "❌ Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}
