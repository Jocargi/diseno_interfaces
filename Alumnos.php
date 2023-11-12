<?php
require_once 'Singleton.php';

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

    public function GetObjectAlumnos() {
        try {
            $db = DB::getInstance();

            // Construye la consulta SQL según tus necesidades y filtros
            $sql = "SELECT * FROM alumno";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    public  static function Delete($DNI) {
        try {
            $db = DB::getInstance();

            $sql = "DELETE FROM alumno WHERE DNI = :dni";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':dni', $DNI);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public  static function Update($DNI) {
        try {
            $db = DB::getInstance();

            $sql = "Update alumno set dni, Nombre, Apellido_1, Apellido_2, Direccion, Localidad, Provincia, Fecha_Nacimiento WHERE DNI = :dni";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':dni', $DNI);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>
