<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>

<body>
    <div class="container">
        <h1 class="headline text-center">SIG</h1>
        <div class="row">
            <div class="col-12  d-flex justify-content-center ">Resultado de la Búsqueda</div>
            <div class="row">
                <div class="col-12 col-md-6 col-sm-4  ">
                    <p>Palabra Buscada</p>
                </div>

                <div class="col-12 col-md-6 col-sm-8 d-flex justify-content-end ">
                    <a href="<?= BASE_URL . 'Dashboard/busquedaAvanzada'; ?>" class="boton"><button class="btn btn-dark " type="button"><i class="bi bi-zoom-in"></i> Busqueda Avanzada </button></a>
                    <a href="<?= BASE_URL . 'Dashboard/mapaProcesos'; ?>" class="mx-3"><i class="bi bi-house-fill"></i></a>
                </div>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-light">
                <thead>
                    <tr class="table-active">
                        <th>Descargar</th>
                        <th>Nombre Documento</th>
                        <th>Area</th>
                        <th>Categoria</th>
                        <th>Tipo Doc</th>
                        <th>Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $bufferContent ?>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <th>Descargar</th>
                        <th>Nombre Documento</th>
                        <th>Area</th>
                        <th>Categoria</th>
                        <th>Tipo Doc</th>
                        <th>Descripcion</th>
                    </tr>
                </tfoot>                
            </table>
        </div>
    </div>
</body>

</html>