<?php

require_once 'Singleton.php';

class Alumno {
    public $DNI;
    public $Nombre;
    public $Apellido_1;
    public $Apellido_2;
    public $Direccion;
    public $Localidad;
    public $Provincia;
    public $FechaNacimiento;

    public function __construct($DNI, $Nombre, $Apellido_1, $Apellido_2, $Direccion, $Localidad, $Provincia, $FechaNacimiento) {

        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
        $this->Apellido_1 = $Apellido_1;
        $this->Apellido_2 = $Apellido_2;
        $this->Direccion = $Direccion;
        $this->Localidad = $Localidad;
        $this->Provincia = $Provincia;
        $this->FechaNacimiento = $FechaNacimiento;
       

    }


    public   function delete() {
        try {
            $db = DB::getInstance();
            $sql = "DELETE FROM alumno WHERE DNI = $this->DNI";
            $stmt = $db->prepare($sql);
           
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function update() {
        try {
            $db = DB::getInstance();
    
            $sql = "UPDATE alumno SET nombre = :nombre, apellido_1 = :apellido_1, apellido_2 = :apellido_2, direccion = :direccion, localidad = :localidad, provincia = :provincia, FECHA_NACIMIENTO = :fecha_nacimiento 
            WHERE dni = :dni";
    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $this->Nombre);
            $stmt->bindParam(':apellido_1', $this->Apellido_1);
            $stmt->bindParam(':apellido_2', $this->Apellido_2);
            $stmt->bindParam(':direccion', $this->Direccion);
            $stmt->bindParam(':localidad', $this->Localidad);
            $stmt->bindParam(':provincia', $this->Provincia);
            $stmt->bindParam(':fecha_nacimiento', $this->FechaNacimiento);
            $stmt->bindParam(':dni', $this->DNI);
            $success = $stmt->execute();
    
    
            return $success;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    
    public function insert() {
        try {
            $db = DB::getInstance();
            $sql = "INSERT INTO alumno (DNI, Nombre, Apellido_1, Apellido_2, Direccion, Localidad, Provincia, Fecha_Nacimiento)
            VALUES (:dni, :nombre, :Apellido_1, :Apellido_2, :direccion, :localidad, :provincia, :fechaNacimiento)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':dni', $this->DNI);
            $stmt->bindParam(':nombre', $this->Nombre);
            $stmt->bindParam(':Apellido_1', $this->Apellido_1);
            $stmt->bindParam(':Apellido_2', $this->Apellido_2);
            $stmt->bindParam(':direccion', $this->Direccion);
            $stmt->bindParam(':localidad', $this->Localidad);
            $stmt->bindParam(':provincia', $this->Provincia);
            $stmt->bindParam(':fechaNacimiento', $this->FechaNacimiento);
            
            return $stmt->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    
    }
    
    



?>
