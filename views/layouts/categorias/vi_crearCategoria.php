<?php include BASE_RELATIVE_VIEWS . '/layouts/common/head.php'; ?>
<!--MODIFICAR CATEGORIA-->

<body>
    <div class="admin-contenedor">
        <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/menu_admin.php'; ?>
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
                <form name="frmGuardar" id="frmGuardar" class="" class="row g-3 needs-validation was-validated">
                    <div class="col-12 col-md-12">
                        <label for="nombre" class="form-label">Nombre Categoria *</label>
                        <input type="text" name="nombre" id="nombre" value="" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-12">
                        <label for="validationCustom04" class="form-label">Area</label>
                        <select name="id_area" id="id_area" class="form-select" required>
                            <option value="">Seleccione Uno</option>
                            <?php foreach ($tuplaAreas as $registro) : ?>
                                <option value="<?= $registro['id'] ?>"><?= $registro['nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <!-- Componentes Funcionales -->
                    <div id="respuestaGeneral"></div>

                    <input type="hidden" name="idUser" id="idUser" value="<?= $_SESSION["idUser"] ?>">
                    <!-- fin Componentes Funcionales -->
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex justify-content-end">                            
                            <div class="d-grid col-12 col-md-6 my-2"><button type="reset" class="btn btn-dark" onclick="document.location='<?= BASE_URL . 'Dashboard/dashboard'; ?>'">Cancelar</button></div>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-star">
                            <div class="col-12 col-md-6 d-grid gap-2 my-2"><button type="submit" name="btnGuardar" id="btnGuardar" class="btn btn-dark"> Guardar</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cargue de redireccionador por metodo Post -->
    <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/reenviador.php'; ?>
</body>
</html>

<script language="javascript">
    $(document).ready(function() {
        //Acción al procesar el Formulario de Guardado
        $("#frmGuardar").bind("submit", function() {
            var btnAccion = $("#btnGuardar");
            var dvRespuesta = $("#respuestaGeneral");
            $.ajax({
                type: "POST",
                url: "<?= BASE_SERVER ?>ws/AreaCategoria/create",
                data: $(this).serialize(),
                beforeSend: function() {
                    btnAccion.prop('disabled', true);
                    dvRespuesta.html('Procesando...<div class="spinner-border text-success"></div>');
                },
                success: function(data) {
                    const tupla = JSON.parse(data);
                    tupla.forEach(function(fila, index) {
                        switch (fila.status) {
                            case "created":
                                alert("Registro Creado");
                                redirect('<?= BASE_URL ?>Dashboard/gestionCategorias', fila.id);
                                break;

                            case "error":
                                alert("Error:" + fila.description);
                                break;
                        }
                    });
                },
                complete: function(data) {
                    dvRespuesta.html('');
                    btnAccion.prop('disabled', false);
                },
                error: function(data) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario</h4>');
                    btnAccion.prop('disabled', false);
                }
            });
            return false;
        });

    });

    //Redireccion por metodo post
    function redirect(url, key) {
        var formData = $("#reenviador")
        formData.prop("method", "POST");
        formData.prop("action", url);
        formData.append('<input type="text" name="key" id="key" value="' + key + '">');
        formData.submit();
    }
</script>