<?php
//header method for the request register
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../../config/database.php';
include_once '../../models/moderador.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

try {
    $moderador = new Moderador($db);
    // obtengo la información
    $data = json_decode(file_get_contents("php://input"));
    // seteo la data
    $moderador->fk_id_usuario = $data->id_usuario;
    // realizo el query
    if($moderador->logUsuario()){
        echo json_encode(
            array( "message" => "Registro de actividad realizado.")
        );
    } else {
        echo json_encode(
            array( "message" => "No se pudo realizar el registro de actividad.")
        );
    }
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>