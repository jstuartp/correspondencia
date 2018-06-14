<?php
require './DAO_detalleOficioSalida.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleOficioSalida_Controller
 *Clase para controlar el acceso a la tabla de DetalleOficiosSalida
 * @author Stuart
 */
class detalleOficioSalida_Controller {
    
    
    
    //Envia los valores recibidos al DAO de la tabla DetallesOficiosSalida para que sean insertados
    public function SetDetallesOficiosSalida($id_oficio,$id_estado,$id_usuario,$observaciones,$fecha,$numOficio){
        $_daoDetalleOficioSalida = new DAO_detalleOficioSalida();
        //echo ($id_oficio." ".$id_estado." ".$id_usuario." ".$observaciones." ".$fecha) ;
        $_daoDetalleOficioSalida->SetDetallesOficioSalida($id_oficio, $id_estado, $id_usuario, $observaciones, $fecha,$numOficio);    
    }
    
    
    //Obtiene todos los datos de un id de oficio especifico
    public function GetDetallesOficioSalida($id){
        $_daoDetalleOficioSalida = new DAO_detalleOficioSalida();
        
        $datos=$_daoDetalleOficioSalida->GetDetalleOficioSalidaById($id);
        return $datos;
    }
    
    //Devuelve el arreglo de los datos de la consulta
    public function GetArrayData($data){
        $_daoDetalleOficioSalida = new DAO_detalleOficioSalida();
        return $_daoDetalleOficioSalida->GetArrayData($data);
    }

        //Devuelve el numero total de registros de una consulta
    public function GetTotalRows($datos){
         $_daoDetalleOficioSalida = new DAO_detalleOficioSalida();
         return $_daoDetalleOficioSalida->TotalRows($datos);
        
    }
    
}
