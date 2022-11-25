<?php 

    require_once "class/sucursal.php";
    require_once "class/responseHTTP.php";

    $sucursal = new Sucursal();
    $responseHTTP = new ResponseHTTP();

    //Voy a enviar los datos por el metodo post
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        //Enviamos los datos al manejador
        $response = $sucursal->getAllSucursal();

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