$(document).ready(function(e) {
    //frmGuardar
    $("#frmGuardar").on('submit', (function(e) {
        let dvRespuesta = $("#rptFrmGuardar");
        let btnAccion = $("#btnGuardar");
        e.preventDefault();
        $.ajax({
            url: "http://localhost/Simec/ws/Documento/create",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                let filename = $("#url").val(); 
                if (filename == ""){
                    alert("debe cargar un archivo");
                    return false;
                }                    
                //$("#rptUploadFile").fadeOut();                    
            },
            success: function(data) {                    
                alert("Procedió");
                console.log(data);
                /*
                const tupla = JSON.parse(data);
                $.each(tupla, function(id, row) {
                    if (row.status == "ok") {
                        $("#url").val(row.filaname);                            
                    }
                });
                */
            },
            complete: function(data) {
                alert("Completado");
                
                //$("#uploadFile").prop('disabled', true);
                //btnAccion.prop('disabled', true);
            },
            error: function(e) {
                frmUploadFile.html(e).fadeIn();
            }
        });
    }));


    //FrmUpload Asincrono
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
                        $("#url").val(row.filaname);                            
                    }
                });
            },
            complete: function(data) {
                $("#uploadFile").prop('disabled', true);
                btnAccion.prop('disabled', true);
            },
            error: function(e) {
                frmUploadFile.html(e).fadeIn();
            }
        });
    }));
});

//Consulta Asyncrona
function actionAsync(action, key) {
    var parametros = {
        "action": action,
        "key": key
    };
    var dvRespuesta = $("#rptGeneral");
    if (key) {
        $.ajax({
            data: parametros,
            url: '<?= BASE_URL ?>controllers/AsynController.php',
            type: 'POST',
            beforeSend: function() {
                dvRespuesta.html('<div class="spinner-border text-success"></div>');
            },
            success: function(response) {
                //dvRespuesta.html(response);                
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
                //btnAccion.prop('disabled', false);
            },
            error: function(data) {
                dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>No se pudo enviar el formulario</h4>');
                //btnAccion.prop('disabled', false);
            }
        });
    } else {
        dvRespuesta.html('<h2><span style="color: red">Error:</h2></span><h4>Seleccione una opcion</h4>');
    }
}