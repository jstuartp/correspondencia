<?php
require_once './Connections/conexion.php'; 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAO_unidad
 *Archivo para el manejo de la tabla unidades
 * @author Stuart
 */
class DAO_unidad {
    
    //Obtiene todas las unidades de la tabla
    public function GetUnidad(){
        global $con;
        
        $consulta = "SELECT * FROM unidades";
        
        $Datos = mysqli_query($con,  $consulta) or die(mysqli_error($con));
        return $Datos;
    }
    
        //Obtiene todas las unidades de la tabla
    public function GetUnidadById($id){
        global $con;
        
        $consulta = sprintf("SELECT nombre FROM unidades WHERE id_unidad=%s", 
                GetSQLValueString($id, "int"));
        
        $Datos = mysqli_query($con,  $consulta) or die(mysqli_error($con));
        return  mysqli_fetch_assoc($Datos);
    }
    
    
    //devuelve todos los datos
    public function GetArrayData($data){
        return  mysqli_fetch_assoc($data);
        
    }

        //Devuelve el numero total de filas de una consula
    public function TotalRows($consulta){
        return mysqli_num_rows($consulta); 
        
    }
    
    
    
    
    //Inserta una nueva unidad en la tabla
    public function SetUnidad($nombre){
        global $con;
        
        $consulta = sprintf("INSERT INTO unidades(nombre) VALUES(%s)",GetSQLValueString($nombre, "text"));
        
        $Datos = mysqli_query($con,  $consulta) or die(mysqli_error($con));
        return $Datos;
    }
    
    
    //Modifica una unidad existente en la tabla
    public function UpdateUnidad($id,$nombre){
         global $con;
        
        $consulta = sprintf("UPDATE unidades SET nombre = %s WHERE id_unidad= %s)",GetSQLValueString($nombre, "text"),GetSQLValueString($id, "int"));
        
        $Datos = mysqli_query($con,  $consulta) or die(mysqli_error($con));
        return $Datos;
        
    }
    
    
    
}
