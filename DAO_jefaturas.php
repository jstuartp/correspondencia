<?php
require_once './Connections/conexion.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAO_jefaturas
 *
 * @author Stuart
 */
class DAO_jefaturas {
    
    
    public function GetJefaturaById($id){
        global $con;
        
        $query = sprintf("SELECT * FROM jefaturas WHERE id_jefatura= %s", GetSQLValueString($id, 'int') );
        
        $Datos = mysqli_query($con,  $query) or die(mysqli_error($con));
        return  mysqli_fetch_assoc($Datos);
        
    }
    
    
}
