<?php require_once('Connections/conexion.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAO_oficio_usuario_log
 *
 * @author Stuart
 */
class DAO_oficio_usuario_log {
    
    
    //Devuelve todos los traslados efectuados a un oficio en particular
    public function GetTrasladosByOficioId($oficio_id){
        global $con;
        
        $query = sprintf("SELECT * FROM oficios_usuariolog WHERE cambio_traslado = 'traslado' and id_oficioin = %s", GetSQLValueString($oficio_id, "int"));
        
         $Datos = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $Datos;
    }
    
    
     //Devuelve todos los movimientos  efectuados a un oficio en particular
    public function GetCambiosByOficioId($oficio_id){
        global $con;
        
        $query = sprintf("SELECT * FROM oficios_usuariolog WHERE  cambio_traslado = 'cambio' and id_oficioin = %s", GetSQLValueString($oficio_id, "int"));
        
         $Datos = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $Datos;
    }
    
     //Devuelve todos los traslados hacia un usuario en particular
    public function GetTrasladosByUsuarioId($usuario_id){
        global $con;
        
        $query = sprintf("SELECT * FROM oficios_usuariolog WHERE id_oficioin = %s ORDER BY fecha_traslado DESC", GetSQLValueString($usuario_id, "int"));
        
         $Datos = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $Datos;
    }
    
    
    
        //Obtiene numero de filas de cualquier registro
    public function GetNumRows($datos){
        
        return mysqli_num_rows($datos);
    }

    //obtiene el arreglo con los datos de la consulta
    public function GetArrayDatos($datos){
        
        return  mysqli_fetch_assoc($datos);
        
    }
    
    
    
    
}
