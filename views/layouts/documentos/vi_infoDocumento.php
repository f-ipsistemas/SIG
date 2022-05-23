<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>
<!-- Modificar Documento -->

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
                        Información del Documento                        
                    </p>
                </div>
            </div>
            <div class="admin-contenido">
                <!-- Formulario Datos del Documento -->
                <form ame="frmGuardar" id="frmGuardar" class="row g-3 needs-validation was-validated">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre Documento *</label>
                        <input type="text" name="nombre" id="nombre" value="<?= $nombre ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="id_area" class="form-label">Area</label>
                        <select name="id_area" id="id_area" onchange="listAsync('listarCategorias',this.value)" class="form-select" required>
                            <option value="">Seleccione Uno</option>
                            <?php foreach ($tuplaAreas as $registro) : ?>
                                <option value="<?= $registro['id'] ?>" <?= $registro['id'] == $idArea ? 'selected="selected"' : ''  ?>><?= $registro['nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_categoria" class="form-label">Categoria</label>
                        <select name="id_categoria" id="id_categoria" class="form-select" required>
                            <?php foreach ($tuplaCategorias as $registro) : ?>
                                <option value="<?= $registro['id'] ?>" <?= $registro['id'] == $idCategoria ? 'selected="selected"' : ''  ?>><?= $registro['nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_tipo_documento" class="form-label">Tipo Documento</label>
                        <select name="id_tipo_documento" id="id_tipo_documento" class="form-select" required>
                            <option value="" selected>Seleccione Uno</option>
                            <?php foreach ($tuplaTipoDocumento as $registro) : ?>
                                <option value="<?= $registro['id'] ?>" <?= $registro['id'] == $idCategoria ? 'selected="selected"' : ''  ?>><?= $registro['nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <!-- DIV CABECERA -->
                    <div class="row my-1">
                        <div class="col-6 fondo-fila ">Nombre Tag</div>
                        <div class="col-6 fondo-fila d-grid justify-content-center ">Borrar</div>
                    </div>
                    <br>
                    <!-- DIV FILAS FOREACH-->
                    <?php foreach ($tuplaTags as $registro) : ?>
                        <div id="tag-<?= $registro['id'] ?>" class="row">
                            <div class="col-6 fondo-cabecera"><?= $registro['nombre'] ?></div>
                            <div class="col-6 fondo-cabecera d-grid justify-content-center ">
                                <button type="button" onclick="deleteTag(<?= $_SESSION["idUser"] ?>,<?= $registro['id'] ?>)"><i class="bi bi-x-circle"></i></button>
                            </div>
                        </div>
                    <?php endforeach ?>

                    <div class="col-md-6">
                        <label for="tags" class="form-label">Tags de Busqueda: </label>
                        <textarea id="tags" name="tags" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción: </label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="form-control" required><?= $descripcion ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="A" <?= $estado == "A" ? 'selected="selected"' : '' ?>>Activo</option>
                            <option value="I" <?= $estado == "I" ? 'selected="selected"' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label">Descargar Documento</label><br>
                        <a href="<?= BASE_SERVER ?>Storage/<?= $nombreArchivo ?>" target="_blank" class="btn btn-dark" title="Descargar"><i class="bi bi-cloud-download"></i></a>
                    </div>                    
                    <!-- Componentes Funcionales -->
                    <div id="rptFrmGuardar"></div>
                    <div id="rptGeneral"></div>
                    <div id="respuestaGeneral"></div>
                    <div id="rptUploadFile"></div>

                    <input type="hidden" name="nombre_archivo" id="nombre_archivo" value="<?= $nombreArchivo ?>">
                    <input type="hidden" name="idUser" id="idUser" value="<?= $_SESSION["idUser"] ?>">
                    <input type="hidden" name="id" id="id" value="<?= $idDocumento ?>">
                    <!--Fin Componentes Funcionales -->

                    <div class="row">
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <div class="d-grid col-12 col-md-6 my-2"><button type="reset" class="btn btn-dark">Limpiar</button></div>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-star">
                            <div class="col-12 col-md-6 d-grid gap-2 my-2"><button type="submit" name="btnGuardar" id="btnGuardar" class="btn btn-dark"> Guardar</button></div>
                        </div>
                    </div>
                </form>

                <!-- Formlario Carga de Documento -->
                <form id="frmUploadFile" method="post" enctype="multipart/form-data" class="was-validated">
                    <!--<form action="row g-3 needs-validation">-->
                    <div class="col-md-12 d-grid justify-content-center">
                        <label for="uploadFile" style="text-align: center;" class="form-label">Selecione el archivo en formato <br> PDF / JPG / Word -Excel- Power Point</label>
                        <input id="uploadFile" name="uploadFile" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pps,.ppsx,.jpg,.jpeg" class="form-control" />
                        <button id="btnUploadFile" type="submit" class="btn btn-dark">Cargar</button>
                        <input type="hidden" name="action" id="action" value="uploadFile">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cargue de redireccionador por metodo Post -->
    <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/reenviador.php'; ?>
</body>

</html>
<script lang="javascript">
    $(document).ready(function(e) {
        //frmGuardar
        $("#frmGuardar").bind("submit", function() {
            var btnAccion = $("#btnGuardar");
            var dvRespuesta = $("#respuestaGeneral");
            $.ajax({
                type: "POST",
                //url: '<?= BASE_URL ?>controllers/AsynController.php',
                url: '<?= BASE_SERVER ?>ws/Documento/updateOne',
                data: $(this).serialize(),
                beforeSend: function() {
                    btnAccion.prop('disabled', true);
                    dvRespuesta.html('Procesando...<div class="spinner-border text-success"></div>');
                },
                success: function(data) {
                    const tupla = JSON.parse(data);
                    tupla.forEach(function(fila, index) {
                        switch (fila.status) {
                            case "warning":
                            case "error":
                                alert(fila.description);
                                break;

                            case "updated":
                            case "created":
                                alert("Registro Actualizado");
                                redirect('<?= BASE_URL ?>Dashboard/infoDocumento', <?= $idDocumento ?>);
                                break;
                        }
                    });
                },
                complete: function() {
                    dvRespuesta.html('');
                    btnAccion.prop('disabled', false);
                },
                error: function(e) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario, ' + e + '</h4>');
                    btnAccion.prop('disabled', false);
                }
            });
            return false;
        });

        //FrmUpload Asincrono (Carga de Archivo)
        $("#frmUploadFile").on('submit', (function(e) {
            let dvRespuesta = $("#rptUploadFile");
            let btnAccion = $("#btnUploadFile");
            e.preventDefault();
            $.ajax({
                url: "<?= BASE_URL ?>controllers/AsynController.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //$("#rptUploadFile").fadeOut();                    
                },
                success: function(data) {
                    const tupla = JSON.parse(data);
                    $.each(tupla, function(id, row) {
                        if (row.status == "ok") {
                            $("#nombre_archivo").val(row.filaname);
                            dvRespuesta.html("Documento Cargado").fadeIn();
                            $("#uploadFile").prop('disabled', true);
                            btnAccion.prop('disabled', true);
                            $("#btnGuardar").prop('disabled', false);
                        } else {
                            dvRespuesta.html(row.status + ":" + row.description).fadeIn();
                            $("#uploadFile").prop('disabled', false);
                            btnAccion.prop('disabled', false);
                        }
                    });
                },
                error: function(e) {
                    dvRespuesta.html(e).fadeIn();
                    console.log(e);
                }
            });
        }));
    });

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

    //Consulta Asyncrona
    function deleteTag(idUser, id) {
        /* console.log(id); */
        if (id != null && idUser != null) {
            var parametros = {
                "idUser": idUser,
                "id": id
            };
            var dvRespuesta = $("#tag-" + id);
            console.log(dvRespuesta);
            $.ajax({
                data: parametros,
                url: '<?= BASE_SERVER ?>ws/DocumentoTag/delete',
                type: 'POST',
                beforeSend: function() {
                    dvRespuesta.html('<div class="spinner-border text-success"></div>');
                },
                success: function(response) {
                    const tupla = JSON.parse(response);
                    $.each(tupla, function(id, row) {
                        if (row.status == "deleted") {
                            dvRespuesta.html("").fadeOut;
                        } else {
                            alert("Error al eliminar el registro");
                        }
                    });
                },
                error: function(data) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario</h4>');
                }
            });
        }
    }

    //Consulta Asyncrona 

    function deleteFile(key) {
        if (key != "") {
            var parametros = {
                "action": "deleteFile",
                "key": key
            };
            //var dvRespuesta = $("#rptGeneral");
            $.ajax({
                data: parametros,
                url: '<?= BASE_URL ?>controllers/AsynController.php',
                type: 'POST',
                beforeSend: function() {
                    console.log("Iniciando Borrado");
                },
                success: function(response) {
                    console.log(response);
                },
                complete: function(data) {
                    console.log("Procesado:" + data);
                },
                error: function(data) {
                    console.log("Error:" + data);                    
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