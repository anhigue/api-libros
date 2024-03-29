<?php

class Articulos
{
    //db conn and table
    private $conn;
    private $table_name = "tb_articulos";

    //object properties
    public $id_articulo;
    public $titulo_articulo;
    public $fecha_creacion;
    public $fecha_publicacion;
    public $estado_articulo;
    public $fk_id_estado;
    public $visita_articulo;
    public $plantilla_articulo;
    public $fk_id_articulo;
    public $fk_id_usuario;

    //object imagen articulo
    public $id_articulo_imagen;
    public $path;

    //object parrafo articulo
    public $id_articulo_parrafo;
    public $parrafo_articulo;

    //object link aticulo
    public $id_articulo_link;
    public $link_articulo;

    //object sub categoria articulo
    public $categoria;
    public $sub_categoria;

    //by limit and offset
    public $limit;
    public $offset;

    //by subcategoria
    public $id_sub_categoria;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //crea un articulo
    public function createA() {
        $query = "INSERT INTO ".$this->table_name." (titulo_articulo,fecha_creacion,fecha_publicacion,estado_articulo,fk_id_estado,visita_articulo,plantilla_articulo,fk_id_usuario) 
                    VALUES (:titulo,NOW(),NULL,true,:estado,0,:plantilla,:id_usuario);";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->titulo_articulo=htmlspecialchars(strip_tags($this->titulo_articulo));
        $this->fk_id_estado=htmlspecialchars(strip_tags($this->fk_id_estado));
        $this->plantilla_articulo=htmlspecialchars(strip_tags($this->plantilla_articulo));
        $this->fk_id_usuario=htmlspecialchars(strip_tags($this->fk_id_usuario));
        //bind foreign key and the path
        $stmt->bindParam(":titulo", $this->titulo_articulo);
        $stmt->bindParam(":estado", $this->fk_id_estado);
        $stmt->bindParam(":plantilla", $this->plantilla_articulo);
        $stmt->bindParam(":id_usuario", $this->fk_id_usuario);
        //execute
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function createAImagen(){
        $query = "INSERT INTO tb_articulo_imagen VALUES (0,:id,:img);";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_articulo=htmlspecialchars(strip_tags($this->fk_id_articulo));
        $this->path=htmlspecialchars(strip_tags($this->path));
        //bind foreign key and the path
        $stmt->bindParam(":id", $this->fk_id_articulo);
        $stmt->bindParam(":img", $this->path);
        //execute
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function createAParrafo(){
        $query = "INSERT INTO tb_articulo_parrafo VALUES (0,:id,:parrafo);";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_articulo=htmlspecialchars(strip_tags($this->fk_id_articulo));
        $this->parrafo_articulo=htmlspecialchars(strip_tags($this->parrafo_articulo));
        //bind foreign key and the path
        $stmt->bindParam(":id", $this->fk_id_articulo);
        $stmt->bindParam(":parrafo", $this->parrafo_articulo);
        //execute
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function createALink(){
        $query = "INSERT INTO tb_articulo_link VALUES (0,:id,:link);";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_articulo=htmlspecialchars(strip_tags($this->fk_id_articulo));
        $this->link_articulo=htmlspecialchars(strip_tags($this->link_articulo));
        //bind foreign key and the path
        $stmt->bindParam(":id", $this->fk_id_articulo);
        $stmt->bindParam(":link", $this->link_articulo);
        //execute
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function getArticulo(){
        $query = "SELECT * FROM ".$this->table_name." WHERE id_articulo = ?";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->id_articulo=htmlspecialchars(strip_tags($this->id_articulo));
        //bind foreign key and the path
        $stmt->bindParam(1, $this->id_articulo);
        //execute
        $stmt->execute();
        return $stmt;
    }

    public function getArticuloImagen(){
        $query = "SELECT * FROM tb_articulo_imagen WHERE fk_id_articulo = ?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_articulo=htmlspecialchars(strip_tags($this->fk_id_articulo));
        //bind foreign key and the path
        $stmt->bindParam(1, $this->fk_id_articulo);
        //execute
        $stmt->execute();
        //get values
        return $stmt;
    }

    public function getArticuloParrafo(){
        $query = "SELECT * FROM tb_articulo_parrafo WHERE fk_id_articulo = ?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_articulo=htmlspecialchars(strip_tags($this->fk_id_articulo));
        //bind foreign key and the path
        $stmt->bindParam(1, $this->fk_id_articulo);
        //execute
        $stmt->execute();
        //get values
        return $stmt;
    }

    public function getArticuloLink(){
        $query = "SELECT * FROM tb_articulo_link WHERE fk_id_articulo = ?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_articulo=htmlspecialchars(strip_tags($this->fk_id_articulo));
        //bind foreign key and the path
        $stmt->bindParam(1, $this->fk_id_articulo);
        //execute
        $stmt->execute();
        return $stmt;
    }

    public function getArticuloCategorias(){
        $query = "SELECT SC.nombre_sub_categoria AS sub_categoria, c.nombre_categoria as categoria 
            FROM tb_articulos a 
            LEFT OUTER JOIN tb_sub_categoria_articulo sa ON a.id_articulo = sa.fk_id_articulo 
            LEFT OUTER JOIN tb_sub_categorias sc ON sa.fk_id_sub_categoria = sc.id_sub_categoria 
            LEFT OUTER JOIN tb_categorias c ON sc.fk_id_categoria = c.id_categoria
            WHERE a.id_articulo = ?";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->id_articulo=htmlspecialchars(strip_tags($this->id_articulo));
        //bind foreign key and the path
        $stmt->bindParam(1, $this->id_articulo);
        //execute
        $stmt->execute();
        return $stmt;
    }

    public function deleteArticulo(){
        $query = "UPDATE tb_articulos SET estado_articulo=0 WHERE id_articulo = ?";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->id_articulo=htmlspecialchars(strip_tags($this->id_articulo));
        //bind foreign key and the path
        $stmt->bindParam(1, $this->id_articulo);
        //execute
        if($stmt->execute())
        {
            return true;
        }else {
            return false;
        }
    }

    public function getMaxArticulo() {
        $query = "SELECT MAX(id_articulo) AS id_articulo FROM ". $this->table_name. ";";
        //prepare
        $stmt = $this->conn->prepare($query);
        //execute
        $stmt->execute();
        // return execute
        return $stmt;
    }

    public function getAll() {
        $query = "SELECT s.id_articulo as id_articulo FROM tb_articulos s;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //execute
        $stmt->execute();
        // return execute
        return $stmt;
    }

    public function getDestacados() {
        $query = "SELECT s.id_articulo as id_articulo, s.visita_articulo as visita FROM tb_articulos s ORDER BY s.visita_articulo DESC LIMIT 4;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //execute
        $stmt->execute();
        // return execute
        return $stmt;
    }

    public function getLimitOffset($limit,$offset){
        $query = "SELECT s.id_articulo as id_articulo FROM tb_articulos s ORDER BY s.fecha_publicacion LIMIT ? OFFSET ?";
        //prepare
        $stmt = $this->conn->prepare($query);
        //bind foreign key and the path
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
        //execute
        $stmt->execute();
        // return execute
        return $stmt;
    }

    public function getCount() {
        $query = "SELECT COUNT(*) as total FROM tb_articulos s;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //execute
        $stmt->execute();
        //return row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // return execute
        return $row['total'];
    }

    public function updateVista(){
        $query = "UPDATE tb_articulos SET visita_articulo=visita_articulo + 1 WHERE id_articulo = ?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //bind
        $stmt->bindParam(1,$this->id_articulo, PDO::PARAM_INT);
        //execute
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getArticuloTitulo(){
        $query = "SELECT * FROM tb_articulos WHERE titulo_articulo = ?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->titulo_articulo=htmlspecialchars(strip_tags($this->titulo_articulo));
        //bind
        $stmt->bindParam(1,$this->titulo_articulo);
        //execute
        $stmt->execute();
        return $stmt;
    }

    public function searchDinamicByCategorias(){
        /**/
        $query = "SET @table_name:='tb_sub_categoria_articulo';";
        // prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->id_sub_categoria=htmlspecialchars(strip_tags($this->id_sub_categoria));
        //bind
        $stmt->bindParam(1,$this->id_sub_categoria);
        //execute
        if ($stmt->execute()){
            $query = "SET @num:= ?;";
            // prepare
            $stmt = $this->conn->prepare($query);
            //sanitize
            $this->id_sub_categoria=htmlspecialchars(strip_tags($this->id_sub_categoria));
            //bind
            $stmt->bindParam(1,$this->id_sub_categoria);
            //lo ejecuto
            if ($stmt->execute()) {
                $query = "SET @sql:=CONCAT('SELECT * FROM ',@table_name, ' WHERE fk_id_sub_categoria =', @num);";
                // prepare
                $stmt = $this->conn->prepare($query);
                //lo ejecuto
                if ($stmt->execute()){
                    $query = "PREPARE dynamic_statement FROM @sql;";
                    // prepare
                    $stmt = $this->conn->prepare($query);
                    //lo ejecuto
                    if($stmt->execute()){
                        $query = "EXECUTE dynamic_statement;";
                        // prepare
                        $stmt = $this->conn->prepare($query);
                        //lo ejecuto
                        $stmt->execute();
                        return $stmt;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;   
            }
        } else {
            return array( "message" => "Error al declarar la variable de tabla.");
        }
    }

    public function getMyArticulos(){
        $query = "SELECT * FROM tb_articulos WHERE fk_id_usuario = ?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->fk_id_usuario=htmlspecialchars(strip_tags($this->fk_id_usuario));
        //bind
        $stmt->bindParam(1,$this->fk_id_usuario);
        //execute
        $stmt->execute();
        //return the execute
        return $stmt;
    }

    // esta funcion edita el encabesado de un articulo
    public function editArticulo(){
        $query = "UPDATE tb_articulos SET titulo_articulo=?, plantilla_articulo=? WHERE id_articulo=?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->titulo_articulo=htmlspecialchars(strip_tags($this->titulo_articulo));
        $this->plantilla_articulo=htmlspecialchars(strip_tags($this->plantilla_articulo));
        $this->id_articulo=htmlspecialchars(strip_tags($this->id_articulo));
        //bind
        $stmt->bindParam(1,$this->titulo_articulo);
        $stmt->bindParam(2,$this->plantilla_articulo);
        $stmt->bindParam(3,$this->id_articulo);
        //execute
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // este funcion edita el parrafo de un articulo
    public function editArticuloParrafo(){
        $query = "UPDATE tb_articulo_parrafo SET parrafo_articulo=? WHERE id_articulo_parrafo=?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->parrafo_articulo=htmlspecialchars(strip_tags($this->parrafo_articulo));
        $this->id_articulo_parrafo=htmlspecialchars(strip_tags($this->id_articulo_parrafo));
        //bind
        $stmt->bindParam(1,$this->parrafo_articulo);
        $stmt->bindParam(2,$this->id_articulo_parrafo);
        //execute
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // esta funcion edita las imagenes de un articulo
    public function editArticuloImagen(){
        $query = "UPDATE tb_articulo_imagen SET path=? WHERE id_articulo_imagen=?;";
        //prepare
        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->path=htmlspecialchars(strip_tags($this->path));
        $this->id_articulo_imagen=htmlspecialchars(strip_tags($this->id_articulo_imagen));
        //bind
        $stmt->bindParam(1,$this->path);
        $stmt->bindParam(2,$this->id_articulo_imagen);
        //execute
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
