<?php 

    require_once "class/cliente.php";
    require_once "class/responseHTTP.php";

    $cliente = new Cliente();
    $responseHTTP = new ResponseHTTP();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        //Recepcion de datos
        //$postbody = file_get_contents("php://input"); 
        if(isset($_GET['email']))
            //Enviamos los datos al manejador
            $response = $cliente->getCliente($_GET['email']);

        //Devolvemos una respuesta
        //Hay que indicar que tipo de respuesta 
        header('Content-Type: application/json');
        if(isset($response['status'])){
                //Hubo un error
                $responseCode = $response['result']['codigo'];
                http_response_code($responseCode);
        }else{
            //Esta todo okkey
            http_response_code(200);
        }
        
        //Se puede utilizar echo porque al momento de convertilo en json se pasa string
        echo (json_encode($response));


    }else{
        header('Content-Type: application/json');
        $response = $responseHTTP->error405();
        http_response_code(405);
        echo (json_encode($response));
    }

?>