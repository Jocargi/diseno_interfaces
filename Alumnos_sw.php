<?php
require_once 'Singleton.php';
require_once 'Alumnos.php';

$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data['action']) ? $data['action'] : null;
$DNI = isset($data['DNI']) ? $data['DNI'] : null;
$Nombre = isset($data['Nombre']) ? $data['Nombre'] : null;

$success = true;
$data = array();

switch ($action) {
    case "get":
        try {
            $db = DB::getInstance();
            $sql = "select * from alumno LIMIT 10";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            $success = false;
        }
        break;
    case "Delete":
        $alumno = new Alumno($DNI, $Nombre);
        $success = $alumno->Delete($alumno->DNI);
        break;
    case "Update":
        
        break;
    case "Insert":
      
        break;
}

// Lo que convierte todo a JSON
$json["success"] = $success;
$json["data"] = $data;

echo json_encode($json);




?>