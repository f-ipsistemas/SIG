<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once '../config/parameters.php';
/*
require_once '../config/db.php';
require_once '../helpers/Utils.php';
require_once '../models/Cliente.php';
*/

if (isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
	//Adicionar al array cada nueva función		
	$listaAcciones = array(
		'False',
		'listarCategorias',
		'uploadFile',
		'crearDocumento',
		'listarDocumentosXArea',
		'updateCategoria',
		'deleteFile'
	);
	$existe = array_search(strval($action), $listaAcciones);
	if ($existe) {
		$action();
	} else {
		echo '<h2><span style="color: red">Error:</h2></span><h4>No se reconoce la acción</h4>';
	}
} else {
	echo '<h2><span style="color: red">Error:</h2></span><h4>No se recibió una acción</h4>';
}

function listarCategorias()
{
	$idArea = isset($_POST['key']) ? $_POST['key'] : false;
	if ($idArea) {
		$consulta = BASE_SERVER . "ws/AreaCategoria/getAllxArea&id_area=" . $idArea;
		$response = file_get_contents($consulta);
	} else {
		$response[] = ['status' => "error", 'description' => "A key is required"];
	}
	print_r($response);
}

function uploadFile()
{
	$valid_extensions = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pps', 'ppsx', 'jpg', 'jpeg'); // valid extensions
	$path = SERVER_RELATIVE . 'Storage/'; // upload directory		
	if (!empty($_FILES['uploadFile'])) {
		$myFile = $_FILES['uploadFile']['name'];
		$tmp = $_FILES['uploadFile']['tmp_name'];
		// get uploaded file's extension
		$ext = strtolower(pathinfo($myFile, PATHINFO_EXTENSION));
		// replace spaces in the filename
		$myFile = str_replace(" ", "_", $myFile);
		// can upload same image using rand function		
		$filename = strtolower(uniqid() . "-" . $myFile);
		// check's valid format
		if (in_array($ext, $valid_extensions)) {
			$path = $path . $filename;
			if (move_uploaded_file($tmp, $path)) {
				$response[] = ['status' => "ok", 'filaname' => $filename];
			} else {
				if ($_FILES["uploadFile"]["error"] == 1){
					$response[] = ['status' => "error", 'description' => "Filesize Error"];
				} else {
					$response[] = ['status' => "error", 'description' => "loading file error #" . $_FILES["uploadFile"]["error"]];
				}
				
			}
		} else {
			$response[] = ['status' => "error", 'description' => "invalid extension"];
		}
	} else {
		$response[] = ['status' => "error", 'description' => "did not select any file"];
	}
	echo json_encode($response);
}

function listarDocumentosXArea()
{
	$id_area = isset($_POST['key']) ? $_POST['key'] : false;
	if ($id_area) {
		$consulta = BASE_SERVER . "ws/Documento/getAllxArea&id_area=" . $id_area;
		$response = file_get_contents($consulta);
		print_r($response);
	} else {
		$response[] = ['status' => "error", 'description' => "A key is required"];
		print_r($response);
	}
}

//2022:05:10: No se usa
function updateCategoria()
{
	//DOC:2022-05-09: Se deja como referencia, pero no se usa por error en acentos al actualizar los campos de texto por QueryParam, se reemplaza enviando el contenido completo por el metodo updeteOne
	$idUser = isset($_POST['idUser']) ? $_POST['idUser'] : false;
	$idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : false;
	$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
	$idArea = isset($_POST['id_area']) ? $_POST['id_area'] : false;
	$estado = isset($_POST['estado']) ? $_POST['estado'] : false;
	if ($idUser && $idCategoria) {
		$consulta = BASE_SERVER . "ws/AreaCategoria/getOne&id=" . $idCategoria;
		$data = file_get_contents($consulta);
		$tuplaCategoria = json_decode($data, true);
		//DOC:2022-04-19: Revision de campos para actializar
		if ($nombre != $tuplaCategoria[0]['nombre']) {
			//DOC:2022-04-19: Revision espacios en blanco
			$nombre = str_replace(" ", "%20", $nombre);
			$consulta = BASE_SERVER . "ws/AreaCategoria/update&id=" . $idCategoria . "&campo=nombre&valor='" . $nombre . "'&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}
		if ($idArea != $tuplaCategoria[0]['id_area']) {
			$consulta = BASE_SERVER . "ws/AreaCategoria/update&id=" . $idCategoria . "&campo=id_area&valor=" . $idArea . "&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}
		if ($estado != $tuplaCategoria[0]['estado']) {
			$consulta = BASE_SERVER . "ws/AreaCategoria/update&id=" . $idCategoria . "&campo=estado&valor='" . $estado . "'&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}
	} else {
		$response[] = ['status' => "error", 'description' => "A key is required"];
	}
	print_r($response);
}

//2022:05:10: No se usa
function updateDocumento()
{
	//DOC:2022-05-09: Se deja como referencia, pero no se usa por error en acentos al actualizar los campos de texto por QueryParam, se reemplaza enviando el contenido completo por el metodo updeteOne
	$idUser = isset($_POST['idUser']) ? $_POST['idUser'] : false;
	$idDocumento = isset($_POST['idDocumento']) ? $_POST['idDocumento'] : false;

	if ($idUser && $idDocumento) {
		//DOC:2022-04-20: Recopilación de datos
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
		$idArea = isset($_POST['id_area']) ? $_POST['id_area'] : false;
		$idCategoria = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : false;
		$idTipoDocumento = isset($_POST['id_tipo_documento']) ? $_POST['id_tipo_documento'] : false;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
		$tags = isset($_POST['tags']) ? $_POST['tags'] : false;
		$nombreArchivo = isset($_POST['nombre_archivo']) ? $_POST['nombre_archivo'] : false;
		$estado = isset($_POST['estado']) ? $_POST['estado'] : false;

		//DOC:2022-04-20: Consulta de datos actuales
		$consulta = BASE_SERVER . "ws/Documento/getOne&id=" . $idDocumento;
		$data = file_get_contents($consulta);
		$tuplaCategoria = json_decode($data, true);

		//DOC:2022-04-20: Revision de campos para actializar
		if ($nombre != $tuplaCategoria[0]['nombre']) {
			//DOC:2022-04-20: Revision espacios en blanco
			$nombre = str_replace(" ", "%20", $nombre);
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idDocumento . "&campo=nombre&valor='" . $nombre . "'&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}
		if ($idArea != $tuplaCategoria[0]['id_area']) {
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idDocumento . "&campo=id_area&valor=" . $idArea . "&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}

		if ($idCategoria != $tuplaCategoria[0]['id_categoria']) {
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idDocumento . "&campo=id_categoria&valor=" . $idCategoria . "&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}

		if ($idTipoDocumento != $tuplaCategoria[0]['id_tipo_documento']) {
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idDocumento . "&campo=id_tipo_documento&valor=" . $idTipoDocumento . "&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}

		if ($descripcion != $tuplaCategoria[0]['descripcion']) {
			$descripcion = str_replace(" ", "%20", $descripcion);
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idDocumento . "&campo=descripcion&valor='" . $descripcion . "'&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}

		if ($nombreArchivo != $tuplaCategoria[0]['nombre_archivo']) {
			$nombreArchivo = str_replace(" ", "%20", $nombreArchivo);
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idDocumento . "&campo=nombre_archivo&valor='" . $nombreArchivo . "'&idUser=" . $idUser;
			$response = file_get_contents($consulta);

			//DOC:2022-04-25: Elimina el archivo existente al ser reemplazado por uno nuevo
			$path = BASE_RELATIVE . 'storage/' . $tuplaCategoria[0]['nombre_archivo'];
			unlink($path);
		}

		if ($estado != $tuplaCategoria[0]['estado']) {
			$consulta = BASE_SERVER . "ws/Documento/update&id=" . $idCategoria . "&campo=estado&valor='" . $estado . "'&idUser=" . $idUser;
			$response = file_get_contents($consulta);
		}

		if ($tags) {
			$tags = explode(",", $tags);
			foreach ($tags as $valor) {
				$descripcion = str_replace(" ", "%20", trim($valor));
				$consulta = BASE_SERVER . "ws/DocumentoTag/create&id_documento=" . $idDocumento . "&nombre=" . $descripcion . "&idUser=" . $idUser;
				$response = file_get_contents($consulta);
			}
		}

		if (isset($response)) {
			print_r($response);
		} else {
			echo ('[{"status":"warning","description":"found no changes"}]');
		}
	} else {
		echo ('[{"status":"error","description":"idUser and idDocumento are requireds"}]');
	}
}
