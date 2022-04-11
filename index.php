<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');

include_once 'includes/DbParams.php';
require_once 'includes/Request.php';



require 'libs/Slim/Slim.php'; 
\Slim\Slim::registerAutoloader(); 

$app = new \Slim\Slim();


$app->get('/usuario', function() use ($app) {

    $param["user"] = $app->request->get('user');
    $param["pass"] = $app->request->get('pass');
    $response = array();
    $conn = new Request();
    $objeto = $conn ->getuser($param);
   
    echoResponse(200, $objeto);
});



// $app->post('/cliente', 'authenticate', function() use ($app) {

//     verifyRequiredParams(array('nombre', 'apellido', 'cedula', 'sexo','fecha_de_ingreso'));

//     $response = array();
   
//     $param['nombre']  = $app->request->post('nombre');
//     $param['apellido'] = $app->request->post('apellido');
//     $param['cedula']  = $app->request->post('cedula');
//     $param['sexo']  = $app->request->post('sexo');
//     $param['actividad_laboral']  =  $app->request->post('actividad_laboral');
//     $param['salario']  =  $app->request->post('salario');
//     $param['dependientes'] = $app->request->post('dependientes');
//     $param['fecha_de_ingreso']  = date("Y-m-d");
//     $param['direccion']  = $app->request->post('direccion');
//     $param['celular'] =  $app->request->post('celular');
//     $param['telefono'] =  $app->request->post('telefono');
//     $param['correo_electronico']  = $app->request->post('correo_electronico');
//     $param['motivo_registro']  = $app->request->post('motivo_registro');
//     $param['estadocivil'] = $app->request->post('estadocivil');
    
   
//     $db = new DbHandler();
//     $cliente = $db ->getCliente($param['cedula']);
//         if(count($cliente) > 0){
          
//         }else{
//             $cliente = $db ->postCliente($param);
//         }

//     if (is_array($param) ) {
//         $response["error"] = false;
//         $response["message"] = "creado satisfactoriamente!";
//         $response["creado"] = $param;
//     } else {
//         $response["error"] = true;
//         $response["message"] = "Error al crear. Por favor intenta nuevamente.";
//     }
//     echoResponse(201, $response);
// });


$app->run();



function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Campos Requeridos ' . substr($error_fields, 0, -2);
        echoResponse(400, $response);
        
        $app->stop();
    }
}
 

/**
 * Mostrando la respuesta en formato json al cliente o navegador
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();

    $app->status($status_code);
 

    $app->contentType('application/json;charset=UTF-8');
 
    echo json_encode($response);
}

function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        //$db = new DbHandler(); //utilizar para manejar autenticacion contra base de datos
 
        // get the api key
        $token = $headers['Authorization'];
        

        if (!($token == API_KEY)) { 
            
           
            $response["error"] = true;
            $response["message"] = "Acceso denegado. Token inválido";
            echoResponse(401, $response);
            
            $app->stop(); 
            
        } else {
          
        }
    } else {
        
        $response["error"] = true;
        $response["message"] = "Falta token de autorización";
        echoResponse(400, $response);
        
        $app->stop();
    }
}

?>