<?php
require_once __DIR__ . '/config/conectar.php';
require_once __DIR__ . '/controllers/DatosControllers.php';

header('Content-Type: application/json');


$ip = $_SERVER['REMOTE_ADDR'];
$limite = 100;
$ventana = 60;
$archivo = sys_get_temp_dir() . "/rate_limit_" . md5($ip);

$ahora = time();
$datos = ['contador' => 1, 'inicio' => $ahora];

if (file_exists($archivo)) {
    $contenido = json_decode(file_get_contents($archivo), true);
    if ($contenido && ($ahora - $contenido['inicio'] <= $ventana)) {
        $contenido['contador']++;
        $datos = $contenido;
    }
}

if ($datos['contador'] > $limite) {
    http_response_code(429);
    echo json_encode([
        'status' => 'error',
        'message' => 'Demasiadas solicitudes. Intenta de nuevo en unos segundos.'
    ]);
    exit;
}

file_put_contents($archivo, json_encode($datos));



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
