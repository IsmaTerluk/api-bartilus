<?php 

    class ConnectionDB {
        
        private $host;
        private $user;
        private $pass;
        private $dbname;
        private $port;
        private $connection;

        public function __construct(){
            //Retorna un objeto de tipo object por defecto
            $json = $this->readJSON(); 
            $this->host = $json->{'DB_HOST'};
            $this->user = $json->{'DB_USER'};
            $this->pass = $json->{'DB_PASSWORD'};
            $this->dbname = $json->{'DB_DATABASENAME'};
            $this->port = $json->{'DB_PORT'};

            //Estblecemos la coneccion
            try{
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
                $this->connection = new PDO ($dsn, $this->user, $this->pass);
                //echo "Conexion establecida";
                //return $this->connection;

            }catch(Exception $e){
                echo "Fallo la conexion => " . $e->getMessage();
            }
        }

        private function readJSON(){
            //Asigna el path donde nos encontramos
            $file = dirname(__FILE__); 
            $datajson = file_get_contents($file. "/config.json");
            //Decodifica el json en un objeto de tipo stdObject
            return json_decode($datajson);
        }

        #METODO - Obtiene los datos de todos los registros dependiendo la query
        public function getAllDatos($query){
            $sentencia = $this->connection->prepare($query);
            $sentencia->execute(); 
            $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        #METODO - Obtiene los datos de un registro
        public function getDatos($query){
            $sentencia = $this->connection->prepare($query);
            $sentencia->execute(); 
            $result = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        
            

        #FILASAFECTADAS - Este nos devuelve las filas afectadas -- osea 1 si fue exitosa la query
        public function insert($query){
            try{
                $sentencia = $this->connection->prepare($query);
                $sentencia->execute();
                if($sentencia->rowCount()==1)
                    return true;
                else
                    return false;
            }catch(Exception $e){
                //echo $e;
            }
        }

        #INSERT -- Nos devuleve el ultimo id de la fila insertado
        public function insertGetId($query){
            $sentencia = $this->connection->prepare($query);
            $sentencia->execute();
            $fila = $sentencia->rowCount();
            if($fila >=1){
                #Obtiene el ultimo id insertado
                return $this->connection->lastInsertId();
            }else{
                return 0;
            }
        }

        #Solo puede ser invocado por clases que hereden de ConecctionBD
        protected function encriptar($string){
            return md5($string);
        }


    }


?>