<?php
//header method for the request register
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../../config/database.php';
include_once '../../models/sub.categorias.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$subcat = new SubCategorias($db);

try {
    
    //Get post data
    $data = json_decode(file_get_contents("php://input"));
    //set values
    $subcat->nombre_sub_categoria = $data->nombre;
    $subcat->fk_id_categoria = $data->id_categoria;
    $subcat->imagen_sub = $data->img;

    if ($subcat->createSubCategoria()) {
        echo json_encode(
            array(
                "message"=>"Se ha agregado correctamente la sub categoria."
            )
        );
    } else {
        echo json_encode(
            array(
                "message"=>"No se ha agregado correctamente la sub categoria."
            )
        );
    }
    


} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>