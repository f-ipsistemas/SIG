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
            Gestión de Tipos de Documento
          </p>
        </div>
      </div>

      <div class="admin-contenido">
        <div class="row">
          <div class="col-12 col-lg-4">
            <!-- Añadir TipoDocumento -->
            <a href="<?= BASE_URL . 'Dashboard/crearTipoDocumento'; ?>">
              <div class="card rojo">
                <div class="value">Añadir Tipo de Documento</div>
              </div>
            </a>
          </div>

          <div class="col-12 col-lg-4">
            <!-- Ver o editar TipoDocumento -->
            <a href="<?= BASE_URL . 'Dashboard/administrarTipoDocumento'; ?>">
              <div class="card rojo">
                <div class="value">Administrar Tipo De Documentos</div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>