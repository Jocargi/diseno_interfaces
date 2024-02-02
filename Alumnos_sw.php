<?php

require_once 'Alumnos.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$action = isset($data['action']) ? $data['action'] : null;
$msg = isset($data['action']) ? $data['action'] : null;
$DNI = isset($data['DNI']) ? $data['DNI'] : null;
$Nombre = isset($data['NOMBRE']) ? $data['NOMBRE'] : null;
$Apellido_1 = isset($data['APELLIDO_1']) ? $data['APELLIDO_1'] : null;
$Apellido_2 = isset($data['APELLIDO_2']) ? $data['APELLIDO_2'] : null;
$Direccion = isset($data['DIRECCION']) ? $data['DIRECCION'] : null;
$Localidad = isset($data['LOCALIDAD']) ? $data['LOCALIDAD'] : null;
$Provincia = isset($data['PROVINCIA']) ? $data['PROVINCIA'] : null;
$FechaNacimiento = isset($data['FECHA_NACIMIENTO']) ? $data['FECHA_NACIMIENTO'] : null;
$limit = 10;
$pagina = isset($data['pagina']) ? $data['pagina'] : 1;



function getAlumnos($limit, $offset, $filtro = array()) {
    $sql = "SELECT * FROM alumno";
    $condiciones = array();

    if (!empty($filtro)) {
        $condiciones[] = "DNI LIKE :dni";
        $condiciones[] = "NOMBRE LIKE :nombre";
        // Añadir más condiciones según sea necesario
    }

    if (!empty( $condiciones)) {
        $sql .= " WHERE " . implode(" AND ",  $condiciones);
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    try {
        $pdo = DB::getInstance();
        $stmt = $pdo->prepare($sql);

        if (!empty($filtro)) {
            $stmt->bindValue(':dni', "%{$filtro['DNI']}%");
            $stmt->bindValue(':nombre', "%{$filtro['NOMBRE']}%");
            // Añadir más vinculaciones según sea necesario
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        $arr = array();
    }

    return $arr;
}
$success = true;
$data = array();
try{
    $db = DB::getInstance();
switch ($action) {
    case "get":
        // Obtener filtro de búsqueda
        $filtro = array(
            'DNI' => $DNI,
            'NOMBRE' => $Nombre,
            
        );

        $offset = ($pagina - 1) * $limit;
        $data = getAlumnos($limit, $offset, $filtro);
        break;

    
    case "Delete":
        $alumno = new Alumno($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento);
        $success = $alumno->delete();
        break;
    case "Buscar":
        $sql = "select * from alumno where dni=:dni";
        $stm = $db->prepare($sql);
        $stm->bindParam(':dni', $DNI);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        break;
         
        
    
    case "Update":
            $alumno = new Alumno($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento);
            $success = $alumno->update();
            break;
    
   
    case "Insert":
        $alumno = new Alumno($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento);
        $success = $alumno->insert();
        break;
    case "BuscarAlumno":
        $alumno = new Alumno($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento);
        $data = $alumno->buscar(); 
    break;
    case "TotalRegistros":
        try {
            $sql = "SELECT COUNT(*) FROM alumno";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            $success = false;
        }

        break;
                      
    default:
        $success=false;
}} catch (Exception $exception) {
    $msg = $exception->getMessage();
    $success=false;
    
}


// Lo que convierte todo a JSON
$json = [
    "success" => $success,
    "data" => $data,
    "msg" => $msg
];
echo json_encode($json);

?>