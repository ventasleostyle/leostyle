<?php
require_once __DIR__ . '/../../controllers/UsuarioController.php';
$controlador = new UsuarioController();
$usuarios = $controlador->listar();
$roles = $controlador->listarRoles();
$titulo = "Listado de Usuarios";
include __DIR__ . "/../layout/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Listado de Usuarios</h2>
  <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalCrear">+ Nuevo usuario</button>
</div>

<?php if (isset($_GET['estado'])): ?>
  <div class="alert alert-<?= $_GET['estado']==='ok'?'success':'danger' ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_GET['msg'] ?? '') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Estado</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= $u['usu_id'] ?></td>
            <td><?= htmlspecialchars($u['usu_nombre']) ?></td>
            <td><?= htmlspecialchars($u['usu_correo']) ?></td>
            <td><?= htmlspecialchars($u['rol_nombre']) ?></td>
            <td><?= $u['usu_estado'] ? 'Activo' : 'Inactivo' ?></td>
            <td class="text-center">
              <!-- Editar -->
              <button class="btn btn-sm btn-outline-dark btn-editar"
                      data-id="<?= $u['usu_id'] ?>"
                      data-nombre="<?= htmlspecialchars($u['usu_nombre']) ?>"
                      data-correo="<?= htmlspecialchars($u['usu_correo']) ?>"
                      data-rol="<?= $u['rol_nombre'] ?>"
                      data-estado="<?= $u['usu_estado'] ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEditar">
                <i class="fas fa-edit"></i>
              </button>
              <!-- Eliminar -->
              <button class="btn btn-sm btn-outline-danger btn-eliminar"
                      data-id="<?= $u['usu_id'] ?>"
                      data-nombre="<?= htmlspecialchars($u['usu_nombre']) ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEliminar">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/leo-style/controllers/UsuarioAccion.php" class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Nuevo Usuario</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="crear">

        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select name="rol_id" class="form-select" required>
            <option value="">Seleccione un rol</option>
            <?php foreach ($roles as $r): ?>
              <option value="<?= $r['rol_id'] ?>"><?= htmlspecialchars($r['rol_nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Estado</label>
          <select name="estado" class="form-select">
            <option value="1" selected>Activo</option>
            <option value="0">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-dark">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/leo-style/controllers/UsuarioAccion.php" class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" id="editar_id">

        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" id="editar_nombre" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" id="editar_correo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña (opcional)</label>
          <input type="password" name="password" id="editar_password" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select name="rol_id" id="editar_rol" class="form-select" required>
            <?php foreach ($roles as $r): ?>
              <option value="<?= $r['rol_id'] ?>"><?= htmlspecialchars($r['rol_nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Estado</label>
          <select name="estado" id="editar_estado" class="form-select">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-warning">Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/leo-style/controllers/UsuarioAccion.php" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Eliminar Usuario</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="eliminar">
        <input type="hidden" name="id" id="eliminar_id">
        <p>¿Seguro que deseas eliminar al usuario <strong id="eliminar_nombre"></strong>?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-danger">Eliminar</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Editar
  document.querySelectorAll(".btn-editar").forEach(btn => {
    btn.addEventListener("click", () => {
      document.getElementById("editar_id").value = btn.getAttribute("data-id");
      document.getElementById("editar_nombre").value = btn.getAttribute("data-nombre");
      document.getElementById("editar_correo").value = btn.getAttribute("data-correo");
      document.getElementById("editar_rol").value = btn.getAttribute("data-rol");
      document.getElementById("editar_estado").value = btn.getAttribute("data-estado");
    });
  });

  // Eliminar
  document.querySelectorAll(".btn-eliminar").forEach(btn => {
    btn.addEventListener("click", () => {
      document.getElementById("eliminar_id").value = btn.getAttribute("data-id");
      document.getElementById("eliminar_nombre").textContent = btn.getAttribute("data-nombre");
    });
  });
});
</script>

<?php include __DIR__ . "/../layout/footer.php"; ?>
