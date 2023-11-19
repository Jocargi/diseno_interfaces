<?php

require_once 'Alumnos.php';

$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data['action']) ? $data['action'] : null;
$DNI = isset($data['DNI']) ? $data['DNI'] : null;
$Nombre = isset($data['NOMBRE']) ? $data['NOMBRE'] : null;
$Apellido_1 = isset($data['APELLIDO_1']) ? $data['APELLIDO_1'] : null;
$Apellido_2 = isset($data['APELLIDO_2']) ? $data['APELLIDO_2'] : null;
$Direccion = isset($data['DIRECCION']) ? $data['DIRECCION'] : null;
$Localidad = isset($data['LOCALIDAD']) ? $data['LOCALIDAD'] : null;
$Provincia = isset($data['PROVINCIA']) ? $data['PROVINCIA'] : null;
$FechaNacimiento = isset($data['FECHA_NACIMIENTO']) ? $data['FECHA_NACIMIENTO'] : null;

$success = true;
$data = array();

switch ($action) {
    case "get":
        try {
            $db = DB::getInstance();
            $sql = "SELECT * FROM alumno LIMIT 10";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            $success = false;
        }
        break;
    case "Delete":
        $alumno = new Alumno($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento);
        $success = $alumno->delete();
        break;
    case "Update":
        // Implementa la lógica de actualización si es necesario
        break;
    case "Insert":
        $alumnoInsert = new Alumno($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento);
        $success = $alumnoInsert->insert();
        break;
}

// Lo que convierte todo a JSON
$json["success"] = $success;
$json["data"] = $data;

echo json_encode($json);

?>
