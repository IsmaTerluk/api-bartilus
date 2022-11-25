<?php

    require_once "class/register.php";
    require_once "class/responseHTTP.php";

    $register = new Register();
    $responseHTTP = new ResponseHTTP();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Recepcion de datos
        $postbody = file_get_contents("php://input"); 

        //Enviamos los datos al manejador
        $response = $register->postInsertUser($postbody);

        //Devolvemos respuesta
        header('Content-Type: application/json');
        if($response['status']== "error"){
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