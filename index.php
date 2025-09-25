<?php
require_once __DIR__ . '/config/database.php';

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "✅ Conexión exitosa a la base de datos.";
} else {
    echo "❌ No se pudo conectar a la base de datos.";
}
