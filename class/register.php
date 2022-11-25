<?php 

    require_once "database/connectionDB.php";

    class Register extends ConnectionDB {


        public function postInsertUser($json){
            $response = new ResponseHTTP();
            $datos = json_decode($json);
             
            //Evalua que vengan todos los datos
            if(isset($datos->{'nombre'}) && isset($datos->{'apellido'}) && isset($datos->{'telefono'}) && isset($datos->{'email'}) && isset($datos->{'password'}) && isset($datos->{'idrol'})){
                //Mapeo los datos
                $nombre = $datos->{'nombre'};
                $apellido = $datos->{'apellido'};
                $telefono = $datos->{'telefono'};
                $email = $datos->{'email'};
                $password = $datos->{'password'};
                $encriptPass = parent::encriptar($password);
                $image = "user_image.jpg";
                $idrol = $datos->{'idrol'};
                if($this->insertPerson($email, $nombre, $apellido, $telefono)){
                    if($this->insertUser($email, $encriptPass, $idrol, $image)){
                        switch($idrol){
                            case 1 : if($this->insertCliente($email,0,0)){
                                        return $response->exito("Registrado correctamente");
                                    }else{
                                        return $response->error500();
                                    }
                                    break;
                        }
                    }else{
                        return $response->error500();
                    }
                }else{
                    return $response->errorUser("Email ya existente");
                }

            }else{
                //No se mandan todos los datos o tienen un error
                return $response->error400();
            }
        }


        private function insertPerson($email, $nombre, $apellido, $telefono){
            $query = "INSERT INTO persona (email,nombre,apellido,telefono) VALUES ('$email', '$nombre','$apellido', '$telefono')";
            return ($this->insert($query));
        }

        private function insertUser($email, $password, $idrol, $image){
            $query = "INSERT INTO usuario (email,password,idrol, user_image) VALUES ('$email', '$password','$idrol', '$image')";
            return ($this->insert($query));
        }

        private function insertCliente($email, $puntos, $saldo){
            $query = "INSERT INTO cliente (email,puntos,saldoafavor) VALUES ('$email', '$puntos','$saldo')";
            return ($this->insert($query));
        }

    }

?>