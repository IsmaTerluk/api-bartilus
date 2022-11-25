<?php

    require_once "class/reserva.php";
    require_once "class/responseHTTP.php";

    $reserva = new Reserva();
    $responseHTTP = new ResponseHTTP();


    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Recepcion de datos
        $postbody = file_get_contents("php://input");

        //Enviamos los datos al manejador
        $response = $reserva->postRegisterReserva($postbody);

        //Devolvemos respuesta
        header('Content-Type: application/json');
        if($response['status']== "error"){
            $responseCode = $response['result']['codigo'];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }

        echo json_encode($response);
    }



    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

        //Recepcion de datos
        $postbody = file_get_contents("php://input"); 

        //Enviamos los datos al manejador
        $response = $reserva->deleteReserva($postbody);

        //Devolvemos respuesta
        header('Content-Type: application/json');
        if($response['status']== "error"){
            $responseCode = $response['result']['codigo'];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }

        echo json_encode($response);
    }


?>