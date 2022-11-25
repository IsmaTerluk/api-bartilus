<?php 

    require_once "database/connectionDB.php";

    class Barbero extends ConnectionDB{

        public function getAllBarberos($sucursal){
            $response = new ResponseHTTP();
            //$datos = json_decode($json);
            if(!empty($sucursal)){
                //$sucursal = $datos->{'sucursal'};
                
                //Obtengo todos los barberos pertenecientes a dicha sucursal
                $query = "SELECT * FROM persona NATURAL JOIN empleado WHERE sucursal = '$sucursal' AND rol=1";
                $datos = $this->getAllDatos($query);

                for($i=0; $i<sizeof($datos); $i++){
                    //Se agrega las especialidades de cada Barbero
                    $especialidad = $this->getEspecialidad($datos[$i]['email']);
                    $datos[$i]['especialidad'] = $especialidad;
                }

                if($datos != null){
                    return $datos;
                }else{
                    return $response->errorUser("Codigo sucursal erroneo");
                }
            }else{
                return $response->error400("Seleccione una sucursal");
            }
        }

        public function getEspecialidad($email){
            $query = "SELECT servicio.* FROM especialidad_empleado INNER JOIN servicio 
            ON especialidad_empleado.servicio = servicio.codigo
            WHERE email='$email'";
            return $this->getAllDatos($query);
        }

        public function getBarbero($email){
            $response = new ResponseHTTP();
            $query = "SELECT * FROM empleado WHERE email = '$email' AND rol=1";
            $datos = $this->getDatos($query);
            if($datos != null){
                return $datos;
            }else{
                return $response->error500();
            }
        }
    }


?>