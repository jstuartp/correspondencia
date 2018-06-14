<?php
require_once('Connections/conexion.php'); 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAO_detalleOficioSalida
 * Clase para el manejo de la tabla Detalle_oficio_salida
 * @author Stuart
 */
class DAO_detalleOficioSalida {
    
    //Devuelve todos los detalles de un oficio especifico
    public function GetDetalleOficioSalidaById($id){
        global $con;
        
        $sql = sprintf("SELECT * FROM detalle_oficios_salida Where id_oficio = %s",
                GetSQLValueString($id, "int"));
        $DatosOficios = mysqli_query($con,  $sql) or die(mysqli_error($con));
        
        return $DatosOficios;
    }
    
    //Devuelve el arreglo de los datos de la consulta
    public function GetArrayData($data){
        return  mysqli_fetch_assoc($data);
        
    }

        //Devuelve el numero total de filas de una consula
    public function TotalRows($consulta){
        return mysqli_num_rows($consulta); 
        
    }

        //Guarda los detalles de un nuevo oficio
    public function SetDetallesOficioSalida($id_oficio,$id_estado,$id_usuario,$observaciones,$fecha,$numOficio){
          global $con;
        
       
          $sql = sprintf("INSERT INTO detalle_oficios_salida (id_oficio, id_estado,id_usuario,observaciones,fecha,numOficio) Values (%s,%s,%s,%s,%s,%s)",
                GetSQLValueString($id_oficio, "int"),
                GetSQLValueString($id_estado, "int"),
                GetSQLValueString($id_usuario, "int"),
                GetSQLValueString($observaciones, "text"),
                GetSQLValueString($fecha, "date"),
                GetSQLValueString($numOficio, "text"));
    //    echo $sql;
        
        $DatosOficios = mysqli_query($con,  $sql) or die(mysqli_error($con));
        
    }
    
    
    //Actualiza los detalles de un oficio especifico
    public function UpdateDetallesOficioSalida($idDetalles,$id_oficio,$id_estado,$id_usuario,$observaciones,$fecha){
        
        
    }
    
    
}
