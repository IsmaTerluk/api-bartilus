<?php 

    class ResponseHTTP {
        
        public $response = [
            'status'=> "ok",
            'result' => array()
        ];


        #peticion exitosa
        public function exito($string="Accion exitosa"){
            $this->response['status'] = "ok";
            $this->response['result'] = array(
                "codigo" => "200",
                "msj" => $string
            );

            return $this->response;
        }

    
        #Petición por un metodo no permitido
        public function error405(){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "codigo" => "405",
                "msj" => "Metodo no permitido"
            );

            return $this->response;
        }

        #Errores que suele cometer el usuario al cargar los datos
        public function errorUser($string = "Datos incorrectos"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "codigo" => "403",
                "msj" => $string
            );
            return $this->response;
        }

        #Peticion cuando los datos enviados son incompletos
        public function error400($mesage="Datos enviados incompletos o con formato incompleto"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "codigo" => "400",
                "msj" => $mesage
            );

            return $this->response;
        }

        #Falla el servidor
        public function error500($string = "Error interno del servidor"){
            $this->response['status'] = "error";
            $this->response['result'] = array(
                "codigo" => "500",
                "msj" => $string
            );
            return $this->response;
        }


    }

?>