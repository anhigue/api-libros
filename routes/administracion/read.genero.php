<?php

//Required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Include db and object

include_once '../../config/database.php';
include_once '../../models/generos.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$tipoUsuario = new Generos($db);

//Query products
$stmt = $tipoUsuario->read();
$num = $stmt->rowCount();

//Check if more than 0 record found
if($num > 0){

    //products array
    $tipoUsuario_arr = array();
    $tipoUsuario = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        
        $tipoUsuario_arr = array(
            "id_genero"            =>  $id_genero,
            "nombre_genero"          =>  $nombre_genero
        );

        array_push($tipoUsuario,$tipoUsuario_arr);
    }

    echo json_encode($tipoUsuario);
}else{
    echo json_encode(
        array("messege" => "No hay tipos de genero ingresados.")
    );
}
