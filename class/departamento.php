<?php 

    require_once "database/connectionDB.php";

    class Departamento extends ConnectionDB{

        public function getAllDepartamento(){
            $response = new ResponseHTTP();
            $query = "SELECT * FROM departamento";
            $datos = $this->getAllDatos($query);
            if($datos != null){
                return $datos;
            }else{
                return $response->error500();
            }
        }

    }


?>