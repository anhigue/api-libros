<?php
//header method for the request register
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../../config/database.php';
include_once '../../models/articulos.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

try {
    $articulos = new Articulos($db);

    $data = json_decode(file_get_contents("php://input"));

    $articulos->fk_id_usuario = $data->id_usuario;
    // realizo el query
    $stmt = $articulos->getMyArticulos();
    // retorno un json
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>