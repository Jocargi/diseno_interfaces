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

    public function __construct($DNI, $Nombre) {
        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
       

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

    public function GetAlumnos() {
        try {
            $db = DB::getInstance();

           
            $sql = "SELECT * FROM alumno";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    public   function Delete($DNI) {
        try {
            $db = DB::getInstance();
            $sql = "DELETE FROM alumno WHERE DNI = $DNI";
            $stmt = $db->prepare($sql);
            echo $sql;
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public   function Update($DNI) {
        try {
            $db = DB::getInstance();

            $sql = "UPDATE alumno set dni, Nombre, Apellido_1, Apellido_2, Direccion, Localidad, Provincia, Fecha_Nacimiento WHERE DNI = :dni";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':dni', $DNI);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public  function insert() {
        $db = DB::getInstance();

            $sql = "INSERT INTO alumnos ( dni, Nombre, Apellido_1, Apellido_2, Direccion, Localidad, Provincia, Fecha_Nacimiento )
            VALUES (:dni, :Nombre, :Apellido_1, :Apellido_2, :Direccion, :Localidad, :Provincia, :Fecha_Nacimiento)";

            $stmt = $db->prepare($sql);

           

    }

    public static function Buscar(){

    }
}
?>
