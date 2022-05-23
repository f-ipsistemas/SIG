<?php
class Utils
{
    public static function coincidenciasTexto($texto)
    {
        $textoFormateado = str_replace(" ", "%20", $texto);
        $listaDocumentos = array();

        //DOC:2022-04-26:Data de la consulta por el nombre del documento
        $campo = "nombre";
        $consulta = BASE_SERVER . "ws/Documento/find&campo=" . $campo . "&valor=" . $textoFormateado;
        $data = file_get_contents($consulta);
        $tuplaNomnreDocumento = json_decode($data, true);

        //DOC:2022-04-26:Data de la consulta por la descripcion del documento
        $campo = "descripcion";
        $consulta = BASE_SERVER . "ws/Documento/find&campo=" . $campo . "&valor=" . $textoFormateado;
        $data = file_get_contents($consulta);
        $tuplaDescripcionDocumento = json_decode($data, true);

        //DOC:2022-04-26:Data de la consulta por tag del documento
        $campo = "nombre";
        $consulta = BASE_SERVER . "ws/DocumentoTag/find&campo=" . $campo . "&valor=" . $textoFormateado;
        $data = file_get_contents($consulta);
        $tuplaDocumentoTag = json_decode($data, true);

        //DOC:2022-04-26:Creacion de lista unica de resultados
        foreach ($tuplaNomnreDocumento as $registro) {
            array_push($listaDocumentos, $registro['id']);
        }
        foreach ($tuplaDescripcionDocumento as $registro) {
            array_push($listaDocumentos, $registro['id']);
        }
        foreach ($tuplaDocumentoTag as $registro) {
            array_push($listaDocumentos, $registro['id_documento']);
        }

        return $listaDocumentos;
    }

    public static function coincidenciasArea($idArea)
    {
        $listaDocumentos = array();

        //DOC:2022-04-27:Lista de documentos coincidentes con al area
        $consulta = BASE_SERVER . "ws/Documento/getAllxArea&id_area=" . $idArea;
        $data = file_get_contents($consulta);
        $tuplaListaDocumentosArea = json_decode($data, true);

        //DOC:2022-04-26:Creacion de lista unica de resultados
        foreach ($tuplaListaDocumentosArea as $registro) {
            array_push($listaDocumentos, $registro['id']);
        }
        return $listaDocumentos;
    }


    public static function coincidenciasCategoria($idCategoria)
    {
        $listaDocumentos = array();

        //DOC:2022-04-27:Lista de documentos coincidentes con al area
        $consulta = BASE_SERVER . "ws/Documento/getAllxCategoria&id_categoria=" . $idCategoria;
        $data = file_get_contents($consulta);
        $tuplaListaDocumentosCategoria = json_decode($data, true);

        //DOC:2022-04-26:Creacion de lista unica de resultados
        foreach ($tuplaListaDocumentosCategoria as $registro) {
            array_push($listaDocumentos, $registro['id']);
        }
        return $listaDocumentos;
    }


    public static function coincidenciasTipoDocumento($idTipodocumento)
    {
        $listaDocumentos = array();

        //DOC:2022-04-27:Lista de documentos coincidentes con al area
        $consulta = BASE_SERVER . "ws/Documento/getAllxTipoDocumento&id_tipo_documento=" . $idTipodocumento;
        $data = file_get_contents($consulta);
        $tuplaListaDocumentosTipoDocumento = json_decode($data, true);

        //DOC:2022-04-26:Creacion de lista unica de resultados
        foreach ($tuplaListaDocumentosTipoDocumento as $registro) {
            array_push($listaDocumentos, $registro['id']);
        }
        return $listaDocumentos;
    }

    public static function filasDocumentosEncontrados($listaDocumentos)
    {
        $bufferContent = null;
        //DOC:2022-04-26:Formateo de string de ids
        $valores = implode(",", $listaDocumentos);

        //DOC:2022-04-26:Data de documentos encontrados
        $consulta = BASE_SERVER . "ws/Documento/getIn&valores=" . $valores;
        $data = file_get_contents($consulta);
        $tuplaListaDocumentos = json_decode($data, true);
        foreach ($tuplaListaDocumentos as $registro) {
            //DOC:2022-04-20:Consulta Auxiliar
            $consultaAuxiliar = BASE_SERVER . "ws/Area/getOne&id=" . $registro['id_area'];
            $dataAuxiliar = file_get_contents($consultaAuxiliar);
            $tuplaAuxiliar = json_decode($dataAuxiliar, true);
            foreach ($tuplaAuxiliar as $registroAuxiliar) {
                $area = $registroAuxiliar['nombre'];
            }

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
            $bufferContent .= '<td>' . $area . '</td>';
            $bufferContent .= '<td>' . $categoria . '</td>';
            $bufferContent .= '<td>' . $tipoDocumento . '</td>';            
            $bufferContent .= '<td><div class="row "><button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$registro['id'].'" aria-expanded="false" aria-controls="collapseExample">Ver <i class="bi bi-eye"></i></button><div class="collapse" id="collapse'.$registro['id'].'"><div class="card card-body overflow-auto">'. $registro['descripcion'] .'</div></div></div></td>';
            $bufferContent .= '</tr>';
        }
        return $bufferContent;
    }


    public static function adminAutorization(){
        if(!isset($_SESSION["admin"])){
            header("Location:". BASE_URL . "Error/e401");            
            die();
        }        
    }

    /*    
    public static function contentPrivilegios($idComponente){        
        if ($_SESSION['id_usuario'] == 1) //Admin
        {
             return true;
        }
        else
        {
            $result = false;
            foreach ($_SESSION['objetos'] as $value) {
                if($value == $idComponente){
                    $result = true;
                    break;
                }
            }
            return $result;           
        }
    }

    public static function uploadAsyncFile() {
        $result = false;
        if (array_key_exists('HTTP_X_FILE_NAME', $_SERVER) && array_key_exists('CONTENT_LENGTH', $_SERVER)) {
            $fileName = md5(uniqid())."---".$_SERVER['HTTP_X_FILE_NAME'];
            $contentLength = $_SERVER['CONTENT_LENGTH'];
        } else throw new Exception("Error retrieving headers");

        $path = 'uploadFiles/';
        if (!$contentLength > 0) {
            throw new Exception('No file uploaded!');
        }
        file_put_contents(
            $path . $fileName,
            file_get_contents("php://input")
        );        
       // chmod($path.$fileName, 0777);
        
        if($fileName)
        {
            $result = $fileName;
        }        
        return $result;
    }    

    public static function nombreEstado($idEstado){
        $estado = new Estado();
        $estado->setIdEstado($idEstado);
        $estado->getOne();
        return $estado->getNombre();
    }

    public static function addHitorial ($radicado,$descripcion,$usuario){
        $result = false;
        $historial = new Historial();        
        $historial->setIdRadicado($radicado);
        $historial->setDescripcion($descripcion);
        $historial->setIdUsuario($usuario);
        $historial = $historial->create();
        if ($historial){
            $result = $historial;
        }        
        return $result;
    }

    public static function urlSimec(){
        if(strpos($_SERVER['REMOTE_ADDR'], ipLocal) === false){
            $result = simecPublico;            
        } else {
            $result = simecLocal;
        }
        return $result;
    }

    public static function fechaHora($fechaHora){
        $fechaHora = explode(" ", $fechaHora);
        return $fechaHora;
    }

    public static function remitenteDestinatario($tipoRadicado,$idRemitente,$idDestinatario){
        switch($tipoRadicado){
            case 1:
                //Remitente - usuario
                $remitente = new UsuarioExterno();
                $remitente->setId($idRemitente);
                $remitente->getOne();
                //Destinatario - ente
                $destinatario = new Ente();
                $destinatario->setIdEnte($idDestinatario);
                $destinatario->getOne();
                //Respuesta
                $remitenteDestinatario = array($remitente->getNombre(),$destinatario->getNombre());
                break;
            case 2:
                //Remitente - ente
                $remitente = new Ente();
                $remitente->setIdEnte($idRemitente);
                $remitente->getOne();
                //Destinatario - usuario
                $destinatario = new UsuarioExterno();
                $destinatario->setId($idDestinatario);
                $destinatario->getOne();                
                break;    
            case 3:
                //Remitente - usuario
                $remitente = new UsuarioExterno();
                $remitente->setId($idRemitente);
                $remitente->getOne();
                //Destinatario - usuario
                $destinatario = new UsuarioExterno();
                $destinatario->setId($idDestinatario);
                $destinatario->getOne();
                break;        
        }
        $remitenteDestinatario = array($remitente->getNombre(),$destinatario->getNombre());
        return $remitenteDestinatario;
    }      
*/
}
