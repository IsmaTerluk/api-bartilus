<?php 

    require_once "database/connectionDB.php";

    class Horario extends ConnectionDB{

        public function getHorariosDisponibles($json){
            $responseHTTP = new ResponseHTTP();
            $datos = json_decode($json);
            if(isset($datos->{'barbero'}) && isset($datos->{'fecha'})){
                $barbero = $datos->{'barbero'};
                $fecha = $datos->{'fecha'};
                $horarios = $this->getDisponibilidad($barbero, $fecha);
                return $horarios;

            }else{
                return $responseHTTP->error400();
            }
        }

        
        //Retorna los horarios disponibles
        private function getDisponibilidad($barbero, $fecha){
            //Selecciona todos los horarios y le resta los ocupados
            $query = "SELECT * FROM horario except
            SELECT  id, hora FROM horario 
            INNER JOIN reserva ON horario.id=reserva.horario
            WHERE reserva.empleado = '$barbero'
            AND fecha = date('$fecha') 
            AND reserva.estado = 'pendiente'";
            return $this->getAllDatos($query);
        }


    }


?>