<?php 

    require_once "class/servicio.php";
    require_once "class/responseHTTP.php";

    $barbero = new Servicio();
    $responseHTTP = new ResponseHTTP();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        //Invocamos al manejador
        $response = $barbero->getAllServicios();

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

        echo json_encode($response);
    
    }else{
        header('Content-Type: application/json');
        $response = $responseHTTP->error405();
        http_response_code(405);
        echo (json_encode($response));
    }

?>