<?php
require_once('Connections/conexion.php'); 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAO_Usuarios
 *Clase para manipular la tabla Usuarios de la base de datos
 * @author Stuart
 */
class DAO_Usuarios {
    
    function DAO_Usuarios(){
        
    }
    
    /*Devuelve un unico nombre de usuario del $id que se envia como parametro*/
    public function DevuelveNombre($id){
         
        global $con;
        $consulta = "SELECT usuario FROM Usuarios WHERE usuario_id = ".$id;
        $_consulta = mysqli_query($con,  $consulta) or die(mysqli_error($con));
        $retorno = mysqli_fetch_assoc($_consulta);
        
        return $retorno['usuario'];
        
        
    }
    
    
    
}
