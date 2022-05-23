<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>

<body>
    <div class="container">
        <h1 class="h1 text-center">SIG</h1>
        <div class="row">
            <div class="col-12 col-ms-6 d-flex justify-content-center">Ruta/Actual(Busqueda avanzada)</div>
            <div class="col-12 col-ms-6 d-flex justify-content-end"> <a href="<?= BASE_URL . 'Dashboard/mapaProcesos'; ?>"><i class="bi bi-house-fill"></i></a>
            </div>
        </div>

        <form method="POST" action="<?= BASE_URL ?>Dashboard/buscarDocumento" class="row g-3 needs-validation">
            <div class="col-md-4">
                <label for="txtCoincidencia" class="form-label">Coincidencia</label>
                <input type="text" id="txtCoincidencia" name="txtCoincidencia" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="id_area" class="form-label">Area</label>
                <select name="id_area" id="id_area" onchange="listAsync('listarCategorias',this.value)" class="form-select">
                    <option value="">Seleccione Uno</option>
                    <?php foreach ($tuplaAreas as $registro) : ?>
                        <option value="<?= $registro['id'] ?>"><?= $registro['nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="id_categoria" class="form-label">Categoria</label>
                <select name="id_categoria" id="id_categoria" class="form-select">
                    <option value="">Seleccione Uno</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="id_tipo_documento" class="form-label">Tipo Documento</label>
                <select name="id_tipo_documento" id="id_tipo_documento" class="form-select">
                    <option value="" selected>Seleccione Uno</option>
                    <?php foreach ($tuplaTipoDocumento as $registro) : ?>
                        <option value="<?= $registro['id'] ?>"><?= $registro['nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="validationCustom04" class="form-label">Fecha: </label>
                <!-- PARA V.1.1 AGREGAR FECHA DESDE - HASTA -->
                <input type="date" id="start" class="form-control" name="trip-start" value="fecha actual" min="2015-01-01" max="2022-12-31" disabled>
            </div>

            <!-- Componentes Funcionales -->
            <input type="hidden" id="tipoBusqueda" name="tipoBusqueda" value="busquedaAvanzada">
            <!-- fin Componentes Funcionales -->
            
            <div class="row">
                <div class="col-12 col-md-6 d-flex justify-content-end">
                    <div class="d-grid col-12 col-md-6 my-2"><button class="btn btn-dark">Limpiar</button></div>
                </div>

                <div class="col-12 col-md-6 d-flex justify-content-star">
                    <div class="col-12 col-md-6 d-grid gap-2 my-2"><button class="btn btn-dark">Buscar</button></div>
                </div>
            </div>

        </form>
    </div>
    <!-- Cargue de redireccionador por metodo Post -->
    <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/reenviador.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {});


    //Consulta Asyncrona (Cargue de Lista)
    function listAsync(action, key) {
        if (key != "") {
            var parametros = {
                "action": action,
                "key": key
            };
            var dvRespuesta = $("#rptGeneral");
            $.ajax({
                data: parametros,
                url: '<?= BASE_URL ?>controllers/AsynController.php',
                type: 'POST',
                beforeSend: function() {
                    dvRespuesta.html('<div class="spinner-border text-success"></div>');
                },
                success: function(response) {
                    const $select = $('#id_categoria');
                    $select.empty();
                    $select.append('<option value="" selected>Seleccione Uno</option>');
                    const tupla = JSON.parse(response);
                    $.each(tupla, function(id, row) {
                        $select.append('<option value=' + row.id + '>' + row.nombre + '</option>');
                    });
                },
                complete: function(data) {
                    dvRespuesta.html("");
                },
                error: function(data) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario</h4>');
                }
            });
        }
    }

    //Redireccion por metodo post
    function redirect(url, key) {
        var formData = $("#reenviador")
        formData.prop("method", "POST");
        formData.prop("action", url);
        formData.append('<input type="text" name="key" id="key" value="' + key + '">');
        formData.submit();
    }
</script>