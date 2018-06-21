<?php
require_once('Connections/conexion.php'); 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAO_recibidos_old
 *
 * @author Stuart
 */
class DAO_recibidos_old {
    

    
    
    //Recibe un anio especifico y devuelve todos los recibidos del sistema viejo
    public function GetRecibidosOldByYear($anio){
        global $con;
        
        $query = sprintf("SELECT * FROM corre_recibida WHERE YEAR(fecha_reci) = %s ORDER BY fecha_reci DESC", GetSQLValueString($anio, "text")) ;
        $DatosOficios = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $DatosOficios;
        
    }
    
    //Devuelve los datos de un registro info_oficios especifico por el ID que recibe
    public function GetRecibidosOldById($id){
        global $con;
        
        $query_DatosOficios = "SELECT * FROM info_oficios WHERE (tipo_oficio = 1 OR tipo_oficio = 2)  AND oficio_id = ".$id;
       // echo $query_DatosOficios;
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));        
        return $DatosOficios;
        
    }
    
    
    
    //Obtiene numero de filas de cualquier registro
    public function GetNumRows($datos){
        
        return mysqli_num_rows($datos);
    }

    //obtiene el arreglo con los datos de la consulta
    public function GetArrayDatos($datos){
        
        return  mysqli_fetch_assoc($datos);
        
    }

    

    //devuelve todos los oficios DE SALIDA presentes en la tabla oficios
    public function GetRecibidosOld(){
        global $con;
     
        
        $query_DatosOficios = sprintf("SELECT * FROM corre_recibida" );
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
                       
        return $DatosOficios;
    }
    
    
    
}
