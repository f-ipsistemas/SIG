<div class="barra_lateral">
      <div class="logo">
        <img class="img-fluid" style="max-width: 120px;" src="<?= BASE_ASSETS . 'img/Cargolap.png'; ?>" alt="">
      </div>

      <nav class="nav">
        <div class="nav__entry nav__entry--active">
          <a class="icono-menu" href="<?= BASE_URL . 'Dashboard/dashboard'; ?>"  title="Menu"><i class="bi bi-house-fill"></i></a>
        </div>

        <div class="nav__entry nav__entry--active">
          <!--Agregar Documento-->
          <a class="icono-menu" href="<?= BASE_URL . 'Dashboard/gestionDocumentos'; ?>" title="Gestión Documentos"><i class="bi bi-file-earmark-plus"></i></a>

        </div>
        <div class="nav__entry nav__entry--active">
           <!--Mapa De procesos-->
          <a class="icono-menu" href="<?= BASE_URL . 'Dashboard/mapaProcesos'; ?>" title="Mapa de Procesos"><i class="bi bi-diagram-3-fill"></i></a>
        </div>
        <div class="nav__entry nav__entry--active">
           <!--Categorias-->
          <a class="icono-menu" href="<?= BASE_URL . 'Dashboard/gestionCategorias'; ?>" title="Gestión de Categorias"><i class="bi bi-tags"></i></a>
        </div>
        <div class="nav__entry nav__entry--active">
           <!--Tipos Documentos-->
          <a class="icono-menu tipo_doc" href="<?= BASE_URL . 'Dashboard/gestionTipoDocumento'; ?>" title="Gestión de Tipos Documentales"><img class="tipo_doc" src="" alt=""></a>
        </div>
        <div class="nav__entry nav__entry--active">
          <!-- Cerrar Sesion -->
          <a class="icono-menu" href="<?= BASE_URL . 'Dashboard/dashboard'; ?>" title="Cerrar Sesión"><i class="bi bi-box-arrow-left"></i></a>
        </div>
      </nav>
</div>