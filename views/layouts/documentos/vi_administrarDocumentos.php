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
                        Administrador de Documentos
                    </p>
                </div>
            </div>
            <div class="admin-contenido">

                <!-- boton de añadir documento -->
                <div class="row">
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <a href="<?= BASE_URL . 'Dashboard/crearDocumento'; ?>" class="btn btn btn-dark my-2"><i class="bi bi-plus-circle"></i> Añadir Documento</a>
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

                <!-- Tabla -->
                <div class="table-responsive">
                    <table id="tblDatos" class="table table-light">
                        <thead>
                            <tr class="table-active">
                                <th>Acciones</th>
                                <th>Nombre Documento</th>
                                <th>Area</th>
                                <th>Categoria</th>
                                <th>Tipo Doc</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th>Acciones</th>
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
            listAsync('listarDocumentosXArea', id_area);
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
                    //console.log(response)
                    $.each(tupla, function(id, row) {
                        if (!row.status) {
                            let area = getName('<?= BASE_SERVER ?>ws/Area/getOne&id=' + row.id_area);
                            let categoria = getName('<?= BASE_SERVER ?>ws/AreaCategoria/getOne&id=' + row.id_categoria);
                            let tipo_documento = getName('<?= BASE_SERVER ?>ws/TipoDocumento/getOne&id=' + row.id_tipo_documento);
                            let fila = '<tr>';
                            fila += '<td>';
                            fila += '<button type="button" class="btn btn-dark" onclick="redirect(\'<?= BASE_URL ?>Dashboard/infoDocumento\',' + row.id + ')" title="Modificar"><i class="bi bi-gear-fill"></i></button> ';
                            fila += '<button type="button" class="btn btn-dark" onclick="window.open(\'<?= BASE_SERVER ?>Storage/' + row.nombre_archivo + '\', \'_blank\');" title="Descargar"><i class="bi bi-cloud-download"></i></button>';
                            fila += '</td>';
                            fila += '<td>' + row.nombre + '</td>';
                            fila += '<td>' + area + '</td>';
                            fila += '<td>' + categoria + '</td>';
                            fila += '<td>' + tipo_documento + '</td>';
                            fila += '<td><div class="row"><button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + row.id + '" aria-expanded="false" aria-controls="collapseExample">Ver <i class="bi bi-eye"></i></button><div class="collapse" id="collapse' + row.id + '"><div class="card card-body overflow-auto">' + row.descripcion + '</div></div></div></td>';                            
                            fila += '</tr>';
                            $('#tblDatos>tbody').append(fila);
                        } else {
                            console.log(row.status);
                        }
                    });
                },
                complete: function(data) {
                    dvRespuesta.html("");
                    //btnAccion.prop('disabled', false);
                },
                error: function(data) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario</h4>');
                    //btnAccion.prop('disabled', false);
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

    function getName(consulta) {
        let response = null;
        $.ajax({
            url: consulta,
            type: 'GET',
            dataType: 'html',
            async: false,
            success: function(data) {
                let nombre;
                const tupla = JSON.parse(data);
                $.each(tupla, function(id, row) {
                    nombre = row.nombre;
                });
                response = nombre;
            },
        });
        return response;
    }
</script>