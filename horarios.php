<?php

    require_once "class/horario.php";
    require_once "class/responseHTTP.php";

    $horario = new Horario();
    $responseHTTP = new ResponseHTTP();


    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        //Recepcion de datos
        $postbody = file_get_contents("php://input"); 

        //Enviamos los datos al manejador
        $response = $horario->getHorariosDisponibles($postbody);

        //Devolvemos respuesta
        header('Content-Type: application/json');
        if(isset($response['status'])){
            //En caso de error
            $responseCode = $response['result']['codigo'];
            http_response_code($responseCode);
        }else{
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