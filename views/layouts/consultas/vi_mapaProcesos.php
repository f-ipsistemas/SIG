<?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/head.php'; ?>
<!--DASHBOARD/CARPETA USUARIO ESTANDAR-->
<body>
    <div class="container">
        <br>
        <h1 class="h1 text-center">Mapa de Procesos</h1>

        <form method="POST" action="<?= BASE_URL ?>Dashboard/buscarDocumento" class="row d-flex justify-content-end">
            <div class="col-auto ">
                <label for="Palabra" class="visually-hidden">Buscar</label>
                <input type="text" class="form-control" id="txtCoincidencia" name="txtCoincidencia"placeholder="(Palabra a buscar)">
            </div>
            <div class="col-auto ">
                <button type="submit" class="btn btn-dark mb-3">Buscar</button>                
                <a style="<?= $btnAdmin ?>" href="<?= BASE_URL . 'Dashboard/dashboard'; ?>"><i class="bi bi-house-fill"></i></a>                
            </div>
        </form>

        <hr>
        <div class="fondotabla">
            <div class="row ">
                <div class="col-12  col-md-1 d-flex justify-content-end x">
                    <div class="d-grid col-12 palabra_estrategico" ></div>
                </div>
                <div class="col-12 col-md-11">
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <div class="d-grid col-12 col-md-6 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',4)" >OFICIAL DE<br> CUMPLIMIENTO</a></div>
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-star">
                            <div class="col-12 col-md-6 d-grid gap-2 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',5)">AUDITORIA <br>INTERNA</a></div>
                        </div>
                    </div>

                    <div class="row ">
                                                    
                        <div class="col-12 col-md-6 d-flex justify-content-center">
                            <div class="d-grid gap-2  col-12 col-md-6 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',1)">GERENCIA</a></div>
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-center">
                            <div class="col-12 col-md-6 d-grid gap-2 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',6)">HSEQ</a></div>
                        </div>           </div>
                </div>
            </div>
            <hr>
            <div class="row ">
                <div class="col-12  col-md-1 d-flex justify-content-end ">
                    <div class="d-grid col-12 palabra_misional" ></div>
                </div>
                <div class="col-12 col-md-11 ">
                    <div class="row">
                        <!--Misional-->
                        <div class="col-12 ">
                            <div class="row gap-1">
                                <div class=" col-12 col-md-12 ">
                                    <div class="col-12 col-md-3 d-grid gap-2 "><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',7)">GESTION <br>COMERCIAL</a></div>
                                </div>
                                <div class=" col-12 col-md-12 ">
                                    <div class="col-12 col-md-3 d-grid gap-2 "><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',9)">LOGISTICA</a></div>
                                </div>
                                <div class=" col-12 col-md-12 ">
                                    <div class="col-12 col-md-3 d-grid gap-2 "><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',8)">CONTROL Y<br> MONITOREO</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12  col-md-1 d-flex justify-content-end ">
                    <div class="d-grid col-12 palabra_apoyo" ></div>
                </div>
                <div class="col-12 col-md-11 gap-3">
                    <div class="row ">
                        <div class="col-12  col-md-6 ">
                            <div class=" d-grid  col-12  col-md-6 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',3)">COMPRAS</a></div>
                        </div>
                        <div class="col-12 col-md-6  d-flex justify-content-end">
                            <div class="col-12  col-md-6 d-grid gap-2 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',10)">TALENTO<br> HUMANO</a></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-12 col-md-6 d-flex justify-content-center">
                            <div class=" d-grid col-12 col-md-6 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',13)">REVISOR<br> FISCAL</a></div>
                        </div>
                        <div class=" col-12 col-md-6 d-flex justify-content-center">
                            <div class="col-12 col-md-6 d-grid gap-2 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',11)">GERENCIA <br>TECNOLOGICA</a></div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class=" col-12 col-md-6 d-flex justify-content-end">
                            <div class=" d-grid col-12 col-md-6 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',12)">GESTION <br>DOCUMENTAL</a></div>
                        </div>
                        <div class=" col-12 col-md-6 d-flex justify-content-star">
                            <div class="col-12 col-md-6 d-grid gap-2 my-1"><a class="boton-1" href="#" onclick="redirect('<?= BASE_URL ?>Dashboard/listaDocumentosArea',13)">GESTION <br>FINANCIERA</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Cargue de redireccionador por metodo Post -->
    <?php require_once BASE_RELATIVE_VIEWS . 'layouts/common/reenviador.php'; ?>
</body>
</html>
<script>
    $(document).ready(function() {});
    //Redireccion por metodo post
    function redirect(url, key) {
        var formData = $("#reenviador")
        formData.prop("method", "POST");
        formData.prop("action", url);
        formData.append('<input type="text" name="key" id="key" value="' + key + '">');
        formData.submit();
    }
</script>