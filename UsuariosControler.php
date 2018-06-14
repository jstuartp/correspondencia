<?php

require_once('DAO_usuarios.php'); 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuariosControler
 *
 * @author Stuart
 */
class UsuariosControler {
    
    public function DevuelveUsuarioDeId($id){
        
        $_DAOUsuarios = new DAO_Usuarios();
        
        return $_DAOUsuarios->DevuelveNombre($id);
        
    }
    
}
