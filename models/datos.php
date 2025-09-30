<?php
class Datos {
    private $db;

    public function __construct($dbConn) {
        $this->db = $dbConn;
    }

    public function obtenerTecnicos() {
        $sql = $this->db->prepare("SELECT * FROM tecnicos");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function introducirTecnicos($nombreTecnico, $codigoEmpleado, $delegacion, $importe, $fecha, $imagenAlimento, $imagenTicket){
        $sql = $this->db->prepare("
            INSERT INTO `gastos_tecnicos` 
            (`nombreTecnico`, `codigoEmpleado`, `delegacion`, `importe`, `fecha`, `imagenAlimento`, `imagenTicket`)
            VALUES (:nombreTecnico, :codigoEmpleado, :delegacion, :importe, :fecha, :imagenAlimento, :imagenTicket)
        ");
        $sql->bindParam(':nombreTecnico', $nombreTecnico);
        $sql->bindParam(':codigoEmpleado', $codigoEmpleado);
        $sql->bindParam(':delegacion', $delegacion);
        $sql->bindParam(':importe', $importe);
        $sql->bindParam(':fecha', $fecha);
        $sql->bindParam(':imagenAlimento', $imagenAlimento);
        $sql->bindParam(':imagenTicket', $imagenTicket);
        $sql->execute();
        return $this->db->lastInsertId();
    }

    public function obtenerGastos() {
        $sql = $this->db->prepare("SELECT * FROM gastos_tecnicos");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteGasto($id) {
        $sql = $this->db->prepare("DELETE FROM gastos_tecnicos WHERE id = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }

    public function updateGasto($id, $nombreTecnico, $codigoEmpleado, $delegacion, $importe, $fecha, $imagenAlimento, $imagenTicket) {
    $sql = $this->db->prepare("
        UPDATE gastos_tecnicos 
        SET nombreTecnico = :nombreTecnico, 
            codigoEmpleado = :codigoEmpleado, 
            delegacion = :delegacion, 
            importe = :importe, 
            fecha = :fecha, 
            imagenAlimento = :imagenAlimento, 
            imagenTicket = :imagenTicket 
        WHERE id = :id
    ");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->bindParam(':nombreTecnico', $nombreTecnico);
    $sql->bindParam(':codigoEmpleado', $codigoEmpleado);
    $sql->bindParam(':delegacion', $delegacion);
    $sql->bindParam(':importe', $importe);
    $sql->bindParam(':fecha', $fecha);
    $sql->bindParam(':imagenAlimento', $imagenAlimento);
    $sql->bindParam(':imagenTicket', $imagenTicket);

    if (!$sql->execute()) {
        $error = $sql->errorInfo();
        throw new Exception("Error al actualizar gasto: " . $error[2]);
    }
}

}
