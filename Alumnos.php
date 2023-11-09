<?php 
class Alumno {
    public $DNI;
    public $Nombre;
    public $Apellido1;
    public $Apellido2;
    public $Direccion;
    public $Localidad;
    public $Provincia;
    public $FechaNacimiento;

    public function __construct($DNI, $Nombre, $Apellido1, $Apellido2, $Direccion, $Localidad, $Provincia, $FechaNacimiento) {
        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
        $this->Apellido1 = $Apellido1;
        $this->Apellido2 = $Apellido2;
        $this->Direccion = $Direccion;
        $this->Localidad = $Localidad;
        $this->Provincia = $Provincia;
        $this->FechaNacimiento = $FechaNacimiento;
    }

    // this hace referencia a la instancia actual 
    // property_exists. Representa el nombre de la propiedad que se desea verificar si existe en la instancia de la clase.
    public function __get($property) {
        if (property_exists($this, $property)) {
        return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
 }
return $this;
}

public static function getObjectAlumnos() {
    try {
        $db=DB::getInstance();
        
        // Construye la consulta SQL según tus necesidades y filtros
        $sql = "SELECT * FROM alumno" ;

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    } catch (Exception $e) {
        
        throw new Exception($e->getMessage(), 1);
    }
}


       
}

?>