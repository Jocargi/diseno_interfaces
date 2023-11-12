<?php
require_once 'Singleton.php';
require_once 'Alumnos.php';


header('Content-Type: application/json ,  charset=utf-8');

$data= json_decode(file_get_contents('php://input'), true);


// Recogida de parámetros
$action=isset($data['action']) ? $data['action'] :null;




// Inicialización de valores para el JSON

$success = true;
$data = array();
// Definición de acciónes en función de la solicitud (get, insert, delete ...)
switch ($action){
    case "get":
        try {
        $db=DB::getInstance();
      
        $sql = "select * from alumno LIMIT 10";
        $stmt = $db->prepare($sql);

        $stmt->execute(); 

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

      
        } catch (Exception $exception) {
        $msg = $exception->getMessage();

        $success=false;}


break;
case"delete":
    Alumno::Delete($data["DNI"]);

    
}
// Creación del array asociativo con la respuesta para convertir a JSON

$json["success"]= $success;
$json["data"]= $data;
    
echo json_encode($json);



?>