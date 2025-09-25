<?php
// ===============================================
// Importamos el controlador
// ===============================================
require_once __DIR__ . '/../../controllers/RolController.php';

// Instanciamos el controlador y pedimos los roles
$controlador = new RolController();
$roles = $controlador->listar();

// Definimos el título de la página (se usa en el header)
$titulo = "Listado de Roles";
include __DIR__ . "/../layout/header.php";
?>

<?php 
// ===============================================
// MOSTRAR ALERTAS DE ESTADO (crear, editar, eliminar)
// Ej: ?estado=ok&msg=Rol%20creado
// ===============================================
if (isset($_GET['estado'], $_GET['msg'])): 
    $tipo = $_GET['estado'] === 'ok' ? 'success' : 'danger';
?>
  <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_GET['msg']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<!-- =============================================== -->
<!-- ENCABEZADO CON BOTÓN NUEVO ROL -->
<!-- =============================================== -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Listado de Roles</h2>

  <!-- Botón que abre el modal para crear -->
  <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalCrear">
    + Nuevo rol
  </button>
</div>

<!-- =============================================== -->
<!-- TABLA DE ROLES -->
<!-- =============================================== -->
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($roles)): ?>
          <?php foreach ($roles as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['rol_id']) ?></td>
              <td><?= htmlspecialchars($r['rol_nombre']) ?></td>
              <td><?= htmlspecialchars($r['rol_descripcion']) ?></td>
              <td class="text-center">
                <!-- Botón EDITAR -->
                <button 
                  class="btn btn-sm btn-outline-dark btn-editar"
                  data-id="<?= $r['rol_id'] ?>"
                  data-nombre="<?= htmlspecialchars($r['rol_nombre']) ?>"
                  data-descripcion="<?= htmlspecialchars($r['rol_descripcion']) ?>"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEditar">
                  <i class="fas fa-edit"></i>
                </button>

                <!-- Botón ELIMINAR -->
                <button 
                  class="btn btn-sm btn-outline-danger ms-1 btn-eliminar"
                  data-id="<?= $r['rol_id'] ?>"
                  data-nombre="<?= htmlspecialchars($r['rol_nombre']) ?>"
                  data-bs-toggle="modal"
                  data-bs-target="#modalEliminar">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center">No hay roles registrados</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- =============================================== -->
<!-- MODAL CREAR ROL -->
<!-- =============================================== -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/leo-style/controllers/RolAccion.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo rol</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="crear">
        <div class="mb-3">
          <label class="form-label">Nombre <span class="text-danger">*</span></label>
          <input type="text" name="nombre" class="form-control" maxlength="50" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <input type="text" name="descripcion" class="form-control" maxlength="150">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-dark">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- =============================================== -->
<!-- MODAL EDITAR ROL -->
<!-- =============================================== -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/leo-style/controllers/RolAccion.php" class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Editar Rol</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="editar">
        <input type="hidden" name="id" id="editar_id">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <textarea class="form-control" id="editar_descripcion" name="descripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
      </div>
    </form>
  </div>
</div>

<!-- =============================================== -->
<!-- MODAL ELIMINAR ROL -->
<!-- =============================================== -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/leo-style/controllers/RolAccion.php" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="eliminar">
        <input type="hidden" name="id" id="eliminar_id">
        <p>¿Seguro que desea eliminar el rol <strong id="eliminar_nombre"></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
      </div>
    </form>
  </div>
</div>

<!-- =============================================== -->
<!-- SCRIPT PARA LLENAR MODALES -->
<!-- =============================================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Rellenar modal EDITAR
  document.querySelectorAll(".btn-editar").forEach(b => {
    b.addEventListener("click", () => {
      document.getElementById("editar_id").value = b.dataset.id;
      document.getElementById("editar_nombre").value = b.dataset.nombre;
      document.getElementById("editar_descripcion").value = b.dataset.descripcion;
    });
  });

  // Rellenar modal ELIMINAR
  document.querySelectorAll(".btn-eliminar").forEach(b => {
    b.addEventListener("click", () => {
      document.getElementById("eliminar_id").value = b.dataset.id;
      document.getElementById("eliminar_nombre").textContent = b.dataset.nombre;
    });
  });
});
</script>

<?php include __DIR__ . "/../layout/footer.php"; ?>
