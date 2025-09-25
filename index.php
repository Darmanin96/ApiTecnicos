<?php
require_once __DIR__ . '/config/conectar.php';
require_once __DIR__ . '/controllers/DatosControllers.php';

$controller = new DatosController($dbConn);
$metodo = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['REQUEST_URI'];

$path = str_replace('/Api-Tecnicos/', '', $url);
$path = trim($path, '/');

$dividido = explode('/', $path);

switch ($dividido[0]) {
    case 'tecnicos':
        if ($metodo === 'GET') {
            $controller->getAll();
        } else if($metodo === 'POST') {
            $controller->insertarTecnico(); 
        }else {
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Método no permitido para este endpoint."]);
        }
        break;

    case 'gastos':
        if ($metodo === 'GET') {
            $controller->getGastos();
        }else {
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Método no permitido para este endpoint."]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Ruta no encontrada."]);
        break;
}
?>