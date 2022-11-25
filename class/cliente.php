<?php 

    require_once "database/connectionDB.php";
    require_once "responseHTTP.php";

    #Cuando heredo de una clase, puedo usar todos sus metodos menos los privados
    class Cliente extends ConnectionDB{

        public function getCliente($email){
            $response = new ResponseHTTP();
            //Decodifica el json a un object con sus propiedades
            //$datos = json_decode($json); 

            //Pregunta si existen todos los campos necesarios
            if(!empty($email)){
                //$email = $datos->{'email'};
                //Verifica existencia de usuario
                $exist = $this->existUser($email);
                if(isset($exist['rol'])){
                    //Sabemos a que tabla consultar
                    $table = $exist['rol'];

                    //Obtenemos todos los datos del usuario
                    $user = $this->getDatosUser($table, $email);

                    //Agregamos el rol que cumple
                    $user['rol'] = $table;
                    
                    //Agregamos las reservas en caso de que sea cliente
                    if($table == "cliente"){
                        $reservas = $this->getReservas($email);

                        //Obtiene los email de los barberos
                        //Sería los barberos correspondiente a cada reserva
                        $emailBarberos = $this->getEmailBarbero($email);

                        foreach($reservas as $reserva){

                            //Se añaden los servicios solicitados
                            $servicios = $this->getServiciosReservados($reserva['numero']);
                            for( $i=0; $i<sizeof($reservas); $i++ ){
                                //Agregamos el barbero
                                $barbero = $this->getBarbero($emailBarberos[$i]['empleado']);
                                //Le asigno especialidad vacia;
                                $barbero['especialidad'] = array();
                                $reservas[$i]['barbero'] = $barbero;
                                //Agregamos los servicios a las reservas
                                $reservas[$i]['servicios'] = $servicios;
                            }
                            
                        }
                        
                        $user['reservas'] = $reservas;
                       
                    }
                    return $user;
                }else{
                    //No existe el usuario
                    return $response->errorUser("Los campos no coinciden");
                }
            }else{
                return $response->error400();
            } 
        }


        //Si existe retorna el rol del usuario para  saber a que tabla consultar despues
        private function existUser($email){
            $query = "SELECT rol FROM usuario NATURAL JOIN rol WHERE email='$email'";
            return $this->getDatos($query);
        }

        //Retorna los datos del usuario
        private function getDatosUser($table, $email){
            $query = "SELECT * FROM $table NATURAL JOIN persona WHERE email= '$email'";
            return $this->getDatos($query);
        }


        //Trae todas las reservas hasta el momento
        private function getReservas($email){
            $query = "SELECT reserva.numero, reserva.fecha, horario.hora as horario, reserva.puntosacumulados as puntos, reserva.preciototal as precio
                    FROM reserva INNER JOIN horario ON reserva.horario = horario.id
                    WHERE cliente = '$email' AND estado='pendiente'";
            return $this->getAllDatos($query);
        }

        //Obtiene el email del barbero para luego poder capturar sus datos
        private function getEmailBarbero($email){
            $query = "SELECT empleado FROM reserva 
            WHERE  cliente = '$email' AND estado='pendiente'";
            return $this->getAllDatos($query);
        }

        //Trae el barbero que realizo el servicio
        private function getBarbero($email){
            $query = "SELECT * FROM persona natural join empleado WHERE email= '$email' AND rol=1";
            return $this->getDatos($query);
        }


        //Trae todos los servicios solicitados en la reserva
        private function getServiciosReservados($reserva){
            $query = "SELECT servicio.* FROM servicio 
            INNER JOIN servicio_reservado ON servicio.codigo = servicio_reservado.servicio
            WHERE nro_reserva='$reserva'";
            return $this->getAllDatos($query);
        }
        

    }


?>