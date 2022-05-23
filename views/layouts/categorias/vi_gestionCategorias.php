<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>

<body>
  <div class="admin-contenedor">
    <?php include BASE_RELATIVE_VIEWS . '/layouts/common/menu_admin.php'; ?>
    <div class="admin-menu">
      <div class="admin-header">
        <div>
          <h1 class="headline">
            Sistema Integrado de Gestión
          </h1>
          <p class="sub-headline">
            Inicio
          </p>
        </div>
      </div>

      <div class="admin-contenido">
        <div class="row">
          <div class="col-12 col-lg-4">
            <!-- Añadir categorias -->
            <a href="<?= BASE_URL . 'Dashboard/crearCategoria'; ?>">
              <div class="card rojo">
                <div class="value">Añadir Categoria</div>
              </div>
            </a>
          </div>

          <div class="col-12 col-lg-4">
            <!-- Ver o editar categorias -->
            <a href="<?= BASE_URL . 'Dashboard/administrarCategorias'; ?>">
              <div class="card rojo">
                <div class="value">Administrar Categorias</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>