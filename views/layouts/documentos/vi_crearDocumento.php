<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>
<!--AÑADIR DOCUMENTO-->

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
                <!-- Formulario Datos del Documento -->
                <form ame="frmGuardar" id="frmGuardar" class="row g-3 needs-validation was-validated">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre Documento *</label>
                        <input type="text" name="nombre" id="nombre" value="" class="form-control" required>

                    </div>
                    <div class="col-md-6">
                        <label for="id_area" class="form-label">Area</label>
                        <select name="id_area" id="id_area" onchange="listAsync('listarCategorias',this.value)" class="form-select" required>
                            <option value="">Seleccione Uno</option>
                            <?php foreach ($tuplaAreas as $registro) : ?>
                                <option value="<?= $registro['id'] ?>"><?= $registro['nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_categoria" class="form-label">Categoria</label>
                        <select name="id_categoria" id="id_categoria" class="form-select" required>
                            <option value="">Seleccione Uno</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_tipo_documento" class="form-label">Tipo Documento</label>
                        <select name="id_tipo_documento" id="id_tipo_documento" class="form-select" required>
                            <option value="" selected>Seleccione Uno</option>
                            <?php foreach ($tuplaTipoDocumento as $registro) : ?>
                                <option value="<?= $registro['id'] ?>"><?= $registro['nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tags" class="form-label">Tags de Busqueda: </label>
                        <textarea id="tags" name="tags" rows="3" class="form-control" placeholder="Para agregar los tags de manera correcta digite una coma(,) luego de cada palabra. Ejemplo: palabra,texto,tags" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción: </label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="form-control" required></textarea>
                    </div>
                    <hr>

                    <!-- Componentes Funcionales -->
                    <div id="rptFrmGuardar"></div>
                    <div id="rptGeneral"></div>
                    <input type="hidden" name="nombre_archivo" id="nombre_archivo">
                    <input type="hidden" name="idUser" id="idUser" value="<?= $_SESSION["idUser"] ?>">
                    <!--Fin Componentes Funcionales -->

                    <div class="row">
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <div class="d-grid col-12 col-md-6 my-2"><button type="reset" class="btn btn-dark">Limpiar</button></div>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-star">
                            <div class="col-12 col-md-6 d-grid gap-2 my-2"><button type="submit" name="btnGuardar" id="btnGuardar" disabled="disabled" class="btn btn-dark"> Guardar</button></div>
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
    <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/reenviador.php'; ?>
</body>

</html>
<script lang="javascript">
    $(document).ready(function(e) {
        //frmGuardar
        $("#frmGuardar").on('submit', (function(e) {
            let dvRespuesta = $("#rptFrmGuardar");
            let btnAccion = $("#btnGuardar");
            e.preventDefault();
            $.ajax({
                url: "<?= BASE_SERVER ?>ws/Documento/create",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    let filename = $("#nombre_archivo").val();
                    if (filename == "") {
                        alert("Debe cargar un archivo");
                        return false;
                    }
                    btnAccion.prop('disabled', true);
                    dvRespuesta.html('Procesando...<div class="spinner-border text-success"></div>');
                },
                success: function(data) {
                    const tupla = JSON.parse(data);
                    let idDocumento = null;
                    $.each(tupla, function(id, row) {
                        if (row.status == "created") {
                            idDocumento = row.id;
                            //Revisión Tags
                            let tags = $("#tags").val().split(",");
                            tags.forEach(element => {
                                //Almacen de Tags
                                $.post("<?= BASE_SERVER ?>ws/DocumentoTag/create", {
                                        id_documento: row.id,
                                        nombre: element,
                                        idUser: <?= $_SESSION["idUser"] ?>
                                    })
                                    .done(function(dataTag) {
                                        //console.log(dataTag);
                                    });
                            });
                        } else {
                            alert("Error al crear el documento");
                            console.log(data);
                        }
                    });
                    alert("Registro Creado");
                    redirect('<?= BASE_URL ?>Dashboard/infoDocumento', idDocumento);
                },
                complete: function(data) {
                    dvRespuesta.html('');
                    btnAccion.prop('disabled', false);
                },
                error: function(e) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario, ' + e + '</h4>');
                    btnAccion.prop('disabled', false);
                }
            });
        }));

        //FrmUpload Asincrono (Carga de Archivo)
        $("#frmUploadFile").on('submit', (function(e) {
            //let dvRespuesta = $("#rptUploadFile");
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
                            console.log("Documento Cargado");                            
                            $("#uploadFile").prop('disabled', true);
                            btnAccion.prop('disabled', true);
                            $("#btnGuardar").prop('disabled', false);
                        } else {
                            console.log(row.status + ":" + row.description);
                            $("#uploadFile").prop('disabled', false);
                            btnAccion.prop('disabled', false);
                        }
                    });
                },
                error: function(e) {
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

    //Redireccion por metodo post
    function redirect(url, key) {
        var formData = $("#reenviador")
        formData.prop("method", "POST");
        formData.prop("action", url);
        formData.append('<input type="text" name="key" id="key" value="' + key + '">');
        formData.submit();
    }
</script>