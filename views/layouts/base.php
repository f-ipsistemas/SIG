<!doctype html>
<html lang="es">
<head>
    <title></title>
    <?php require_once base_relative . 'common/head.php'; ?>
</head>

<body>
    <?php require_once base_relative . 'common/menu.php'; ?>
    <div class="container">
        <h1>Transferir Guías</h1>
        <br>
        <div class="justify-content-center">
            <div class="row">
                <div class="container-fluid">
                    <!--INICIO ACORDEON-->
                    <div class="card">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h4 class="card-text">Viaje: <?= $id_viaje ?> <i class="fas fa-truck" style="font-size:24px"></i> <?= $vehiculo->getPlaca() ?></h4>
                                        <h2 class="card-title"><i class="fas fa-user-astronaut" style="font-size:24px"></i> <?= $conductor->getNombres() ?> <?= $conductor->getApellidos() ?></h2>
                                        <h4 class="card-text"><i class="fas fa-calendar-alt" style="font-size:24px"></i> <?= $fechaHora[0] ?> <i class="fas fa-clock" style="font-size:24px"></i> <?= $fechaHora[1] ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form name="frmGuardar" id="frmGuardar" method="POST" action="<?= base_url ?>controllers/AsynController.php" class="was-validated">
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Seleccione Las Guías a Transferir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select style="width: 100%; height:auto;" id="origen" name="origen" multiple="multiple">
                                                    <?php while ($fila = $listaGuias->fetch_object()) : ?>
                                                        <option value="<?= $fila->id_guia ?>"><?= $fila->numero ?> - <?= substr($fila->destino, 0, 40) ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td>
                                                <button type="button" class="btn btn-secondary bg-color-cargolap" id="enviar" data-toggle="tooltip" data-placement="left" title="Incorporar Guías a la Transferencia">
                                                    <i class="far fa-arrow-alt-circle-down " style="font-size:24px"></i> 
                                                </button>

                                                <button type="button" class="btn btn-secondary bg-color-cargolap" id="recibir" data-toggle="tooltip" data-placement="right" title="Retirar Guías de la Transferencia">
                                                    <i class="far fa-arrow-alt-circle-up" style="font-size:24px"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Seleccione El Viaje De Destino</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><select class="form-control" id="viajeDestino" name="viajeDestino" onchange="actionAsync('listarGuiasViaje',this.value)" required="true">
                                                    <option value="">Seleccione uno</option>
                                                    <?= $bufferActivos ?>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td><select style="width: 100%; height:auto;" id="destino" name="destino[]" multiple="multiple" required="true"></select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="respuestaGeneral"></div>
                            <input type="hidden" name="action" id="action" value="transferirViaje">
                            <input type="hidden" name="viaje" id="viaje" value="<?= $id_viaje ?>">
                            <button type="submit" name="btnGuardar" id="btnGuardar" class="form-control btn btn-secondary bg-color-cargolap rounded submit px-3"><i class="fas fa-save"></i> Guardar</button>
                        </form>
                        <!--Fin de acordion-->
                    </div>
                </div>
            </div>
        </div>
        <?php require_once base_relative . 'common/alertGeneral.php'; ?>
</body>

</html>
<script language="javascript">
    $(document).ready(function() {
        //Acción al procesar el Formulario de Guardado Transferencia
        $("#frmGuardar").bind("submit", function() {
            selectAllItems();
            var btnAccion = $("#btnGuardar");
            var dvRespuesta = $("#respuestaGeneral");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: $(this).serialize(),
                beforeSend: function() {
                    btnAccion.prop('disabled', true);
                    dvRespuesta.html('Procesando...<div class="spinner-border text-success"></div>');
                },
                success: function(data) {
                    var respuesta = data.split("|*|");
                    switch (respuesta[0]) {
                        case "error":
                            dvRespuesta.html(respuesta[1]);
                            break;

                        case "tupla":
                            dvRespuesta.html(respuesta[1]);
                            break;

                        case "url":
                            $("#alertaContenido").html("Registro Guardado con Exito");
                            $("#alertaCerrar").click(function() {
                                document.location = respuesta[1];
                            });
                            $("#alertaX").click(function() {
                                document.location = respuesta[1];
                            });
                            $("#alerta").modal("show");
                            break;

                        default:
                            dvRespuesta.html(data);
                            break;
                    }
                },
                complete: function(data) {
                    //dvRespuesta.html("Completado");
                    //btnAccion.prop('disabled', false);
                },
                error: function(data) {
                    dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario</h4>');
                    btnAccion.prop('disabled', false);
                }
            });
            return false;
        });

    });

    //Pasar Guias
    $(function() {
        $("#enviar").click(function() {
            $('#origen option:selected').appendTo("#destino");
        });
    });

    //Recibir Guias
    $(function() {
        $("#recibir").click(function() {
            $('#destino option:selected').appendTo("#origen");
        });
    });

    //Selecciona todos los items de selectorMultiple a enviar
    function selectAllItems() {
        var elements = document.getElementById("destino").options;
        for (var i = 0; i < elements.length; i++) {
            elements[i].selected = true;
        }
    }

    //Consulta Asyncrona
    function actionAsync(action, key) {
        var parametros = {
            "action": action,
            "key": key
        };
        var dvRespuesta = $("#respuestaGeneral");
        $.ajax({
            data: parametros,
            url: '<?= base_url ?>controllers/AsynController.php',
            type: 'POST',
            beforeSend: function() {
                dvRespuesta.html('<div class="spinner-border text-success"></div>');
            },
            success: function(response) {
                var respuesta = response.split("|*|");
                switch (respuesta[0]) {
                    case "error":
                        dvRespuesta.html(respuesta[1]);
                        break;

                    case "tupla":
                        dvRespuesta.html(respuesta[1]);
                        break;

                    case "url":
                        $("#alertaContenido").html("Registro Guardado con Exito");
                        $("#alertaCerrar").click(function() {
                            document.location = respuesta[1];
                        });
                        $("#alertaX").click(function() {
                            document.location = respuesta[1];
                        });
                        $("#alerta").modal("show");
                        break;

                    default:
                        dvRespuesta.html(response);
                        break;
                }
            }
        });
    }
</script>