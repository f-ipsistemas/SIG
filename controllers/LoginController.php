<?php
require_once 'config/parameters.php';
require_once 'helpers/Utils.php';

class LoginController {  
    public function login() {
        $idUser = isset($_GET['usr']) ? trim(strtoupper($_GET['usr'])) : false;
        if($idUser){
            //DOC:2022-03-25:Se evalua el privilegio de administración de SIG
            $consulta = "http://".LOCAL_IP."/Simec/ws/PrivilegioUsuario/getPrivilegiosUsuario&id_usuario=".$idUser;            
            $data = file_get_contents($consulta);
            $tupla = json_decode($data, true);              
            foreach ($tupla as $registro){
                if ($registro['id_objeto'] == 63){
                    $admin = true;
                    $_SESSION["admin"] = true;        
                    break;
                } else {
                    $admin = false;
                }                
            }
            //DOC:2022-03-25:Se crea la sesión del usuario
            $_SESSION["idUser"] = $idUser;
            
            //DOC:2022-03-25:Redirección a la seccion correspondiente
            //$redirec = $admin ? BASE_URL."Dashboard/dashboard" : BASE_URL."Dashboard/vista1";
            if($admin){
               $redirec = BASE_URL."Dashboard/dashboard";
            } else {
               $redirec = BASE_URL."Dashboard/mapaProcesos";
            }                                    
            header("Location:$redirec");
        } else {
            require_once 'views/layouts/layout2/vista2.php';
        }        
    }        
}
