<?php
require_once __DIR__ . '/../models/Datos.php';
require_once __DIR__ . '/../view/json.php';

class DatosController {
    private $modelo;

    public function __construct($dbConn) {
        $this->modelo = new Datos($dbConn);
    }

    public function getAll() {
        $data = $this->modelo->obtenerTecnicos();
        renderJSON(["status" => "success", "data" => $data]);
    }

    public function getGastos() {
        $data = $this->modelo->obtenerGastos();
        foreach ($data as &$row) {
            if (isset($row['imagenAlimento'])) {
                $row['imagenAlimento'] = base64_encode($row['imagenAlimento']);
            }
            if (isset($row['imagenTicket'])) {
                $row['imagenTicket'] = base64_encode($row['imagenTicket']);
            }
        }
        renderJSON(["status" => "success", "data" => $data]);
    }

  public function deleteGasto() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        renderJSON(["status" => "error", "message" => "ID es obligatorio para eliminar un gasto"]);
        return;
    }
    $existe = $this->modelo->obtenerGastos(); 
    $existe = array_filter($existe, fn($gasto) => $gasto['id'] == $id);

    if (empty($existe)) {
        renderJSON(["status" => "error", "message" => "No se encontró el gasto con el ID proporcionado"]);
        return;
    }

    $this->modelo->deleteGasto($id);

    renderJSON(["status" => "success", "message" => "Gasto eliminado correctamente"]);
}


    public function insertarTecnico() {
        $nombreTecnico = $_POST['nombreTecnico'] ?? null;
        $codigoEmpleado = $_POST['codigoEmpleado'] ?? null;
        $delegacion = $_POST['delegacion'] ?? null;
        $importe = $_POST['importe'] ?? null;
        $fecha = $_POST['fecha'] ?? null;

        $imagenAlimento = $_FILES['imagenAlimento'] ?? null;
        $imagenTicket = $_FILES['imagenTicket'] ?? null;

        if (!$nombreTecnico || !$codigoEmpleado || !$delegacion || !$importe || !$fecha || !$imagenAlimento || !$imagenTicket) {
            renderJSON(["status" => "error", "message" => "Faltan datos obligatorios"]);
            return;
        }

        $contenidoAlimento = file_get_contents($imagenAlimento['tmp_name']);
        $contenidoTicket   = file_get_contents($imagenTicket['tmp_name']);

        $idInsertado = $this->modelo->introducirTecnicos(
            $nombreTecnico,
            $codigoEmpleado,
            $delegacion,
            $importe,
            $fecha,
            $contenidoAlimento,
            $contenidoTicket
        );

        renderJSON([
            "status" => "success",
            "id" => $idInsertado,
            "message" => "Técnico insertado correctamente"
        ]);
    }
}
