<?php
require_once('Connections/conexion.php'); 

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Data Access Object para el manejo de la tabla InfoOficios
 * Se encarga de manejar el SQL para las diferentes consultas
 *
 * @author Stuart
 */
class DAO_infoOficios {
    

    
    /*Funcion para actualizar el archivo que se presenta en el listado de oficios de salida
    recibe: variables con el nombre y la extension del nuevo documento, la ruta que almacena en la base de datos, recibe el id del oficio especifico
     * retorna el resultado para verificar que se ejecuto el SQL     */
    public function ActualizarArchivoSalida($nombre_nuevo,$extension,$id){
    
        global $con; //global requerida para el include de conexion.php
        
        $InstrucionSQL = sprintf("UPDATE  info_oficios SET `imagen` = %s, `extension_archivos` = %s WHERE (oficio_id = %s)", 
               GetSQLValueString($nombre_nuevo, "text"), 
               GetSQLValueString($extension, "text"),
               GetSQLValueString($id, "int"));


        
        $Result1 = mysqli_query($con,  $InstrucionSQL) or die(mysqli_error($con));
        
        return $Result1;   
    }
    
    
    //Recibe un anio especifico y devuelve todos los oficios DE SALIDA correspondientes a ese anio
    public function GetInfoOficiosSalidaPorAnio($anio){
        global $con;
        
        $query_DatosOficios = "SELECT * FROM info_oficios WHERE tipo_oficio = 0 AND anno =".$anio." ORDER BY oficio_id DESC" ;
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));        
        return $DatosOficios;
        
    }
    
    //Devuelve los datos de un registro info_oficios especifico por el ID que recibe
    public function GetInfoOficiosById($id){
        global $con;
        
        $query_DatosOficios = "SELECT * FROM info_oficios WHERE (tipo_oficio = 1 OR tipo_oficio = 2)  AND oficio_id = ".$id;
       // echo $query_DatosOficios;
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));        
        return $DatosOficios;
        
    }
    
    
    
    
    //Recibe un anio especifico y devuelve todos los oficios DE ENTRADA correspondientes a ese anio
    public function GetInfoOficiosEntradaPorAnio($anio){
        global $con;
        
        $query_DatosOficios = "SELECT * FROM info_oficios WHERE (tipo_oficio = 1 OR tipo_oficio = 2)  AND anno =".$anio." ORDER BY oficio_id DESC" ;
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));        
        return $DatosOficios;
        
    }
    
    //Devuelve la informacion de los oficios en tramite de un usuario especifico
    public function GetInfoOficiosEnTramiteByUser($UserId){
         global $con;
        
        
        $query = "SELECT * FROM info_oficios JOIN oficios_usuario
                    ON info_oficios.oficio_id = oficios_usuario.id_oficioin 
                    WHERE (tipo_oficio = 1 OR tipo_oficio = 2) AND ((oficios_usuario.id_estado != 5) 
                    and (oficios_usuario.id_estado != 9)) AND oficios_usuario.usuario_id = ".$UserId;
        
        $DatosOficios = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $DatosOficios;
    }

        //Devuelve la informacion de los oficios recien asignados de un usuario especifico
    public function GetInfoOficiosAsignadosByUser($UserId){
         global $con;
        
        
        $query = "SELECT * FROM info_oficios JOIN oficios_usuario
                    ON info_oficios.oficio_id = oficios_usuario.id_oficioin 
                    WHERE (tipo_oficio = 1 OR tipo_oficio = 2) AND (oficios_usuario.id_estado = 9) 
                    AND oficios_usuario.usuario_id = ".$UserId;
     //   echo $query;
        $DatosOficios = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $DatosOficios;
    }
    
        //Devuelve la informacion de los oficios ya tramitados de un usuario especifico
    public function GetInfoOficiosTramitadosByUser($UserId){
         global $con;
        
        
        $query = "SELECT * FROM info_oficios JOIN oficios_usuario
                    ON info_oficios.oficio_id = oficios_usuario.id_oficioin 
                    WHERE (tipo_oficio = 1 OR tipo_oficio = 2) AND (oficios_usuario.id_estado = 5) 
                    AND oficios_usuario.usuario_id = ".$UserId;
       // echo $query;
        $DatosOficios = mysqli_query($con,  $query) or die(mysqli_error($con));        
        return $DatosOficios;
    }
    
    
    //Devuelve los datos de los oficios que las jefaturas aun no han asignado a un usuario especifico
    public function GetInfoOficiosSinAsignar(){
        
        global $con;
        
        $query = "SELECT * FROM info_oficios WHERE info_oficios.tipo_oficio !=0 and info_oficios.id_estado=1 and info_oficios.oficio_id 
                                NOT IN
                                      (SELECT oficios_usuario.id_oficioin
                                       FROM oficios_usuario)";
        
        $DatosOficios = mysqli_query($con,  $query) or die(mysqli_error($con));        
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
    public function GetInfoOficiosSalida(){
        global $con;
     
        
        $query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE tipo_oficio = 0 ORDER BY oficio_id DESC" );
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
                       
        return $DatosOficios;
    }
    
    
    
    
    //devuelve todos los oficios DE ENTRADA presentes en la tabla oficios
    public function GetInfoOficiosEntrada(){
        global $con;
     
        
        $query_DatosOficios = sprintf("SELECT * FROM info_oficios WHERE (tipo_oficio=1 OR tipo_oficio=2) ORDER BY info_oficios.oficio_id ASC" );
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
                       
        return $DatosOficios;
    }
    
    //Devuelve el ultimo id valido mas 1, para ingresar un nuevo id a la tabla de InfoOficios - Recive como parametro el anio
    public function GetInfoOficiosUltimoId2ByYear($year){
        global $con;
     
        
        $query_DatosOficios = sprintf("SELECT (IFNULL( MAX(oficio_id2)+1, 1) ) as id from info_oficios where anno= ".$year." ORDER BY oficio_id DESC limit 0,1" );
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
        $dato = mysqli_fetch_assoc($DatosOficios);               
        return $dato['id'];
    }
    
    public function GetInfoOficiosLastId(){
        global $con;
     
        
        $query_DatosOficios = sprintf("SELECT (MAX(oficio_id)) as id  from info_oficios WHERE tipo_oficio != 0 ORDER BY oficio_id DESC limit 0,1" );
        $DatosOficios = mysqli_query($con,  $query_DatosOficios) or die(mysqli_error($con));
        $dato =mysqli_fetch_assoc($DatosOficios);               
        return $dato['id'];
    }
    
    
    
    //Cambia el estado del oficio de salida en la base de datos
    public function CambiaEstadoOficioSalida($idOficio,$idEstado,$Observaciones){
        global $con;
        
        $insertSQL = sprintf("UPDATE info_Oficios SET id_estado= %s, observaciones= %s WHERE oficio_id= ".$idOficio ,
                                       
                     GetSQLValueString($idEstado, "int"),
                     GetSQLValueString($Observaciones, "text"));

        $DatosOficios = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));

//               
    }
    
    
    
}
