<?php 

    require_once "database/connectionDB.php";

    class Servicio extends ConnectionDB{

        //Retorna todos los servicios
        public function getAllServicios(){
            $response = new ResponseHTTP();
            $query = "SELECT * FROM servicio";
            $datos = $this->getAllDatos($query);
            if($datos != null){
                return $datos;
            }else{
                return $response->error500();
            }
        }

        //Retorna un servicio en concreto, para futuras implementaciones
        public function getServicio($codigo){
            $response = new ResponseHTTP();
            $query = "SELECT * FROM servicio WHERE codigo = '$codigo'";
            $datos = $this->getDatos($query);
            if($datos != null){
                return $datos;
            }else{
                return $response->error500();
            }
        }
    }


?>