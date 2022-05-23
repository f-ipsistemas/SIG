<?php

require_once 'config/parameters.php';
require_once 'helpers/Utils.php';

class DashboardController
{

    function __construct()
    {
        if (!$_SESSION["idUser"]) {
            //Verificacion de Administrador
            Utils::adminAutorization();
        }
    }

    public function dashboard()
    {
        //Verificacion de Administrador
        Utils::adminAutorization();

        //DOC:2022-05-06:Data de la consulta
        $consulta = BASE_SERVER . "ws/Usuario/getOne&id=" . $_SESSION["idUser"];
        $data = file_get_contents($consulta);
        $tupla = json_decode($data, true);
        $nombreUsuario = $tupla[0]['nombre'];

        //Cargue de Vista
        require_once 'views/layouts/dashboard/vi_dashboard.php';
    }

    public function gestionCategorias()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        require_once 'views/layouts/categorias/vi_gestionCategorias.php';
    }

    public function crearCategoria()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        //DOC:2022-03-25: Carga la lísta de áreas activas
        $consulta = BASE_SERVER . "ws/Area/getAll";
        $data = file_get_contents($consulta);
        $tuplaAreas = json_decode($data, true);

        //DOC:2022-03-25: Carga la vista
        require_once 'views/layouts/categorias/vi_crearCategoria.php';
    }

    public function infoCategoria()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        $idCategoria = isset($_POST['key']) ? $_POST['key'] : false;
        if ($idCategoria) {
            //DOC:2022-04-19:Data de la consulta
            $consulta = BASE_SERVER . "ws/AreaCategoria/getOne&id=" . $idCategoria;
            $data = file_get_contents($consulta);
            $tuplaCategoria = json_decode($data, true);
            $idArea = $tuplaCategoria[0]['id_area'];
            $nombre = $tuplaCategoria[0]['nombre'];
            $estado = $tuplaCategoria[0]['estado'];

            //DOC:2022-04-19:Data de Lista
            $consulta = BASE_SERVER . "ws/Area/getAll";
            $data = file_get_contents($consulta);
            $tuplaAreas = json_decode($data, true);

            //DOC:2022-04-19: Carga la vista
            require_once 'views/layouts/categorias/vi_infoCategoria.php';
        } else {
            echo "Error: Se requiere una key";
        }
    }

    public function administrarCategorias()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        //DOC:2022-03-30: Carga la lísta de áreas activas
        $consulta = BASE_SERVER . "ws/Area/getAll";
        $data = file_get_contents($consulta);
        $tuplaAreas = json_decode($data, true);

        //DOC:2022-03-30: Carga la vista
        require_once 'views/layouts/categorias/vi_administrarCategorias.php';
    }

    public function gestionDocumentos()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        //Cargue de Vista
        require_once 'views/layouts/documentos/vi_gestionDocumentos.php';
    }

    public function crearDocumento()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        //DOC:2022-03-25: Carga la lísta de áreas activas
        $consulta = BASE_SERVER . "ws/Area/getAll";
        $data = file_get_contents($consulta);
        $tuplaAreas = json_decode($data, true);

        //DOC:2022-03-30: Carga la lísta de Tipos de Documentos
        $consulta = BASE_SERVER . "ws/TipoDocumento/getAll";
        $data = file_get_contents($consulta);
        $tuplaTipoDocumento = json_decode($data, true);

        //DOC:2022-03-25: Carga la vista
        require_once 'views/layouts/documentos/vi_crearDocumento.php';
    }

    public function administrarDocumentos()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        //DOC:2022-04-18: Carga la lísta de áreas activas
        $consulta = BASE_SERVER . "ws/Area/getAll";
        $data = file_get_contents($consulta);
        $tuplaAreas = json_decode($data, true);

        //DOC:2022-04-18: Carga la vista
        require_once 'views/layouts/documentos/vi_administrarDocumentos.php';
    }

    public function infoDocumento()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        $idDocumento = isset($_POST['key']) ? $_POST['key'] : false;
        if ($idDocumento) {
            //DOC:2022-04-20:Data de la consulta
            $consulta = BASE_SERVER . "ws/Documento/getOne&id=" . $idDocumento;
            $data = file_get_contents($consulta);
            $tuplaDocumento = json_decode($data, true);
            $nombre = $tuplaDocumento[0]['nombre'];
            $idArea = $tuplaDocumento[0]['id_area'];
            $idCategoria = $tuplaDocumento[0]['id_categoria'];
            $idTipoDocumento = $tuplaDocumento[0]['id_tipo_documento'];
            $descripcion = $tuplaDocumento[0]['descripcion'];
            $nombreArchivo = $tuplaDocumento[0]['nombre_archivo'];
            $estado = $tuplaDocumento[0]['estado'];

            //DOC:2022-04-20:Data de Lista
            $consulta = BASE_SERVER . "ws/Area/getAll";
            $data = file_get_contents($consulta);
            $tuplaAreas = json_decode($data, true);

            //DOC:2022-04-20:Data de Lista
            $consulta = BASE_SERVER . "ws/AreaCategoria/getAllxArea&id_area=" . $idArea;
            $data = file_get_contents($consulta);
            $tuplaCategorias = json_decode($data, true);

            //DOC:2022-03-30: Carga la lísta de Tipos de Documentos
            $consulta = BASE_SERVER . "ws/TipoDocumento/getAll";
            $data = file_get_contents($consulta);
            $tuplaTipoDocumento = json_decode($data, true);

            //DOC:2022-04-20:Data de Lista
            $consulta = BASE_SERVER . "ws/DocumentoTag/getAllxDocumento&id_documento=" . $idDocumento;
            $data = file_get_contents($consulta);
            $tuplaTags = json_decode($data, true);

            //DOC:2022-04-20: Carga la vista
            require_once 'views/layouts/documentos/vi_infoDocumento.php';
        } else {
            echo "Error: Se requiere una key";
        }
    }

    public function mapaProcesos()
    {
        if (!isset($_SESSION["admin"])) {
            $btnAdmin = "display:none";
        } else {
            $btnAdmin = "";
        }
        //DOC:2022-04-20: Carga la vista
        require_once 'views/layouts/consultas/vi_mapaProcesos.php';
    }

    public function listaDocumentosArea()
    {
        $idArea = isset($_REQUEST['key']) ? $_REQUEST['key'] : false;
        if ($idArea) {
            //DOC:2022-04-20:Data de tabla
            $consulta = BASE_SERVER . "ws/Documento/getAllxArea&id_area=" . $idArea;
            $data = file_get_contents($consulta);
            $tuplaListaDocumentos = json_decode($data, true);

            $bufferContent = null;
            foreach ($tuplaListaDocumentos as $registro) {

                //DOC:2022-04-20:Consulta Auxiliar
                $consultaAuxiliar = BASE_SERVER . "ws/AreaCategoria/getOne&id=" . $registro['id_categoria'];
                $dataAuxiliar = file_get_contents($consultaAuxiliar);
                $tuplaAuxiliar = json_decode($dataAuxiliar, true);
                foreach ($tuplaAuxiliar as $registroAuxiliar) {
                    $categoria = $registroAuxiliar['nombre'];
                }

                //DOC:2022-04-20:Consulta Auxiliar                
                $consultaAuxiliar = BASE_SERVER . "ws/TipoDocumento/getOne&id=" . $registro['id_tipo_documento'];
                $dataAuxiliar = file_get_contents($consultaAuxiliar);
                $tuplaAuxiliar = json_decode($dataAuxiliar, true);
                foreach ($tuplaAuxiliar as $registroAuxiliar) {
                    $tipoDocumento = $registroAuxiliar['nombre'];
                }

                $bufferContent .= '<tr>';
                $bufferContent .= '<td><button type="button" class="btn btn-dark" onclick="window.open(\'' . BASE_SERVER . 'Storage/' . $registro['nombre_archivo'] . '\', \'_blank\');" title="Descargar"><i class="bi bi-cloud-download"></i></td>';
                $bufferContent .= '<td>' . $registro['nombre'] . '</td>';
                $bufferContent .= '<td>' . $categoria . '</td>';
                $bufferContent .= '<td>' . $tipoDocumento . '</td>';
                $bufferContent .= '<td><div class="row"><button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $registro['id'] . '" aria-expanded="false" aria-controls="collapseExample">Ver <i class="bi bi-eye"></i></button><div class="collapse" id="collapse' . $registro['id'] . '"><div class="card card-body overflow-auto">' . $registro['descripcion'] . '</div></div></div></td>';
                $bufferContent .= '</tr>';
            }

            //DOC:2022-04-18: Carga la lísta de áreas activas
            $consulta = BASE_SERVER . "ws/Area/getAll";
            $data = file_get_contents($consulta);
            $tuplaAreas = json_decode($data, true);

            //DOC:2022-04-20: Carga la vista
            require_once 'views/layouts/consultas/vi_listaDocumentosArea.php';
        } else {
            echo "Error: Se requiere una key";
        }
    }

    public function busquedaAvanzada()
    {
        //DOC:2022-03-25: Carga la lísta de áreas activas
        $consulta = BASE_SERVER . "ws/Area/getAll";
        $data = file_get_contents($consulta);
        $tuplaAreas = json_decode($data, true);

        //DOC:2022-03-30: Carga la lísta de Tipos de Documentos
        $consulta = BASE_SERVER . "ws/TipoDocumento/getAll";
        $data = file_get_contents($consulta);
        $tuplaTipoDocumento = json_decode($data, true);

        //DOC:2022-03-25: Carga la vista
        require_once 'views/layouts/consultas/vi_busquedaAvanzada.php';
    }

    public function buscarDocumento()
    {
        $tipoBusqueda = isset($_POST['tipoBusqueda']) ? $_POST['tipoBusqueda'] : false;
        $texto = isset($_POST['txtCoincidencia']) ? $_POST['txtCoincidencia'] : false;
        $bufferContent = null;
        $listaDocumentos = array();
        if ($tipoBusqueda == "busquedaAvanzada") {
            $idArea = isset($_POST['id_area']) ? $_POST['id_area'] : false;
            $idCategoria = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : false;
            $idTipoDocumento = isset($_POST['id_tipo_documento']) ? $_POST['id_tipo_documento'] : false;

            //DOC:2022-04-27:Obtención de coincidencias por texto
            if ($texto) {
                $listaObtenida = Utils::coincidenciasTexto($texto);
                if (count($listaObtenida) != 0) {
                    array_push($listaDocumentos, $listaObtenida[0]);
                }
            }

            //DOC:2022-04-27:Obtención de coincidencias por Area seleccionada
            if ($idArea) {
                $listaObtenida = Utils::coincidenciasArea($idArea);
                if (count($listaObtenida) != 0) {
                    array_push($listaDocumentos, $listaObtenida[0]);
                }
            }

            //DOC:2022-04-27:Obtención de coincidencias por Categoria seleccionada
            if ($idCategoria) {
                $listaObtenida = Utils::coincidenciasCategoria($idCategoria);
                if (count($listaObtenida) != 0) {
                    array_push($listaDocumentos, $listaObtenida[0]);
                }
            }

            //DOC:2022-04-27:Obtención de coincidencias por Tipo de Documento seleccionado
            if ($idTipoDocumento) {
                $listaObtenida = Utils::coincidenciasTipoDocumento($idTipoDocumento);
                if (count($listaObtenida) != 0) {
                    array_push($listaDocumentos, $listaObtenida[0]);
                }
            }

            //DOC:2022-04-27:Eliminacion de ids repetidos
            $listaDocumentos = array_unique($listaDocumentos);
            if (count($listaObtenida) != 0) {
                array_push($listaDocumentos, $listaObtenida[0]);
                $bufferContent = Utils::filasDocumentosEncontrados($listaDocumentos);
            }
        } else {
            if ($texto) {
                //DOC:2022-04-27:Obtención de coincidencias por texto
                $listaObtenida = Utils::coincidenciasTexto($texto);

                //DOC:2022-04-26:Eliminacion de ids repetidos
                $listaDocumentos = array_unique($listaObtenida);
            }
        }

        //DOC:2022-04-27:Carga el buffer con el contenido que se visualizará en la vista               
        if (count($listaDocumentos) > 0) {
            $bufferContent = Utils::filasDocumentosEncontrados($listaDocumentos);
        } else {
            $bufferContent .= '<tr>';
            $bufferContent .= '<td colspan="6">No se encuentran coincidencias</td>';
            $bufferContent .= '</tr>';
        }
        //DOC:2022-04-20: Carga la vista
        require_once 'views/layouts/consultas/vi_listaDocumentosEncontrados.php';
    }

    public function gestionTipoDocumento()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        require_once 'views/layouts/tipodocumento/vi_gestionTipoDocumento.php';
    }

    public function crearTipoDocumento()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        //DOC:2022-03-25: Carga la lísta de áreas activas
        $consulta = BASE_SERVER . "ws/Tipodocumento/getAll";
        $data = file_get_contents($consulta);
        $tuplaAreas = json_decode($data, true);

        //DOC:2022-05-11: Carga la vista
        require_once 'views/layouts/tipodocumento/vi_crearTipoDocumento.php';
    }

    public function infoTipoDocumento()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        $idTipoDocumento = isset($_POST['key']) ? $_POST['key'] : false;
        if ($idTipoDocumento) {
            //DOC:2022-05-11:Data de la consulta
            $consulta = BASE_SERVER . "ws/TipoDocumento/getOne&id=" . $idTipoDocumento;
            $data = file_get_contents($consulta);
            $tuplaConsulta = json_decode($data, true);
            $nombre = $tuplaConsulta[0]['nombre'];
            $estado = $tuplaConsulta[0]['estado'];

            //DOC:2022-05-11: Carga la vista
            require_once 'views/layouts/tipodocumento/vi_infoTipoDocumento.php';
        } else {
            echo "Error: Se requiere una key";
        }
    }

    public function administrarTipoDocumento()
    {
        //DOC:2022-05-06: Verificacion de Administrador
        Utils::adminAutorization();

        $bufferContent = "";

        //DOC:2022-05-06: Carga la lísta de áreas activas
        $consultaAuxiliar = BASE_SERVER . "ws/TipoDocumento/getAllFull";
        $dataAuxiliar = file_get_contents($consultaAuxiliar);
        $tuplaAuxiliar = json_decode($dataAuxiliar, true);
        foreach ($tuplaAuxiliar as $registroAuxiliar) {
            $bufferContent .= '<tr>';
            $bufferContent .= '<td><button type="button" class="btn btn-dark" onclick="redirect(\'' . BASE_URL . 'Dashboard/infoTipoDocumento\',' . $registroAuxiliar['id'] . ')" title="Modificar"><i class="bi bi-gear-fill"></i></button></td></td>';
            $bufferContent .= '<td>' . $registroAuxiliar['nombre'] . '</td>';
            $bufferContent .= '<td>' . $registroAuxiliar['estado'] . '</td>';
            $bufferContent .= '</tr>';
        }

        //DOC:2022-05-06: Carga la vista
        require_once 'views/layouts/tipodocumento/vi_administrarTipoDocumento.php';
    }
}
