<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>
<!--GESTION DE DOCUMENTOS-->

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
                        Ruta o Ubicacion Actual // Ejemplo:Inicio
                    </p>
                </div>
            </div>
            <div class="admin-contenido">

                <div class="row">
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <a href="<?= BASE_URL . 'Dashboard/crearCategoria'; ?>" class="btn btn btn-dark my-2"><i class="bi bi-plus-circle"></i> Añadir Categoria</a>
                    </div>
                </div>

                <!-- Selector de Areas -->
                <div class="col-12 col-md-6">
                    <label for="">Area</label>
                    <select name="id_area" id="id_area" class="form-select my-2">
                        <option value="">Seleccione Uno</option>
                        <?php foreach ($tuplaAreas as $registro) : ?>
                            <option value="<?= $registro['id'] ?>"><?= $registro['nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="table-responsive">
                    <table id="tblDatos" class="table table-light">
                        <thead>
                            <tr class="table-active">
                                <th>Acciones</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th>Acciones</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="respuestaGeneral"></div>
    <!-- Cargue de redireccionador por metodo Post -->
    <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/reenviador.php'; ?>
</body>

</html>
<script language="javascript">
    $(document).ready(function() {
        $('#id_area').change(function() {
            let id_area = $('#id_area').val();
            listAsync('listarCategorias', id_area);
        });           
    });

    //Consulta Asyncrona
    function listAsync(action, key) {
        if (key != "") {
            var parametros = {
                "action": action,
                "key": key
            };
            var dvRespuesta = $("#respuestaGeneral");
            $.ajax({
                data: parametros,
                url: '<?= BASE_URL ?>controllers/AsynController.php',
                type: 'POST',
                beforeSend: function() {
                    dvRespuesta.html('<div class="spinner-border text-success"></div>');
                },
                success: function(response) {
                    $("#tblDatos>tbody").empty();
                    const tupla = JSON.parse(response);
                    $.each(tupla, function(id, row) {
                        if (row.status) {
                            console.log(row.status);
                        } else {
                            let fila = '<tr>';                            
                            fila += '<td><button type="button" class="btn btn-dark" onclick="redirect(\'<?= BASE_URL ?>Dashboard/infoCategoria\',' + row.id + ')" title="Modificar"><i class="bi bi-gear-fill"></i></button></td>';
                            fila += '<td>' + row.nombre + '</td>';
                            fila += '<td>' + row.estado + '</td>';
                            fila += '</tr>';
                            $('#tblDatos>tbody').append(fila);
                        }
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

    function redirect(url, key) {
        var formData = $("#reenviador")
        formData.prop("method", "POST");
        formData.prop("action", url);
        formData.append('<input type="text" name="key" id="key" value="' + key + '">');
        formData.submit();
    }
</script>