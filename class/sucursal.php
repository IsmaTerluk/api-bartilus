<?php 

    require_once "database/connectionDB.php";

    class Sucursal extends ConnectionDB{

        public function getAllSucursal(){
            $response = new ResponseHTTP();
            $query = "SELECT * FROM sucursal";
            $datos = $this->getAllDatos($query);
            if($datos != null){
                return $datos;
            }else{
                return $response->error500();
            }
        }


        //Retorna una unica sucursal, para futuras implementaciones
        public function getSucursal($codigo){
            $response = new ResponseHTTP();
            $query = "SELECT * FROM sucursal WHERE codigo = '$codigo'";
            $datos = $this->getDatos($query);
            if($datos != null){
                return $datos;
            }else{
                return $response->error500();
            }
        }
    }


?>