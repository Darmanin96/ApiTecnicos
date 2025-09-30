<?php
require_once __DIR__ . '/config/conectar.php';
require_once __DIR__ . '/controllers/DatosControllers.php';

header('Content-Type: application/json');

$controller = new DatosController($dbConn);

$metodo = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['REQUEST_URI'];

$path = parse_url($url, PHP_URL_PATH);
$path = str_replace('/Api-Tecnicos/', '', $path);
$path = trim($path, '/');
$dividido = explode('/', $path);

switch ($dividido[0]) {
    case 'tecnicos':
        if ($metodo === 'GET') {
            $controller->getAll();
        } else {
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Método no permitido para este endpoint."]);
        }
        break;

    case 'gastos':
        if ($metodo === 'GET') {
            $controller->getGastos();
        } elseif ($metodo === 'POST') {
            $controller->insertarTecnico();
        } elseif ($metodo === 'DELETE') {
            $controller->deleteGasto();
        } else if($metodo === 'PUT'){
            $controller->updateGasto();
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
