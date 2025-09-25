<?php
if (!isset($titulo)) {
    $titulo = "LEO-STYLE";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> | LEO-STYLE</title>
    <link rel="icon" href="../../img/LS-Logo.jpg" type="image/png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 3px solid #d4af37;
        }
        .navbar-brand img {
            height: 40px;
        }
        .nav-link {
            font-weight: 600;
            color: #000 !important;
        }
        .nav-link:hover {
            color: #d4af37 !important;
        }
        footer {
            background: #fff;
            border-top: 3px solid #d4af37;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/leo-style/index.php">
                <img src="../../img/LS-Logo.jpg" alt="LEO-STYLE">
                <span class="ms-2 fw-bold">LEO-STYLE</span>
            </a>
            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/leo-style/views/Rol/Listar.php">Roles</a></li>
                    <li class="nav-item"><a class="nav-link" href="/leo-style/views/Usuario/Listar.php">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
