<?php
require 'DAO_infoOficios.php';

//recibe el identificador para saber que funcion disparar
$flag = $_GET['flag'];
$imagen = $_FILES['imagen']['tmp_name'];  //copia los valores del archivo para guardar los datos
$nombre_orig = $_FILES['imagen']['name'];
$id = $_POST['id'];

//verifica la bandera y activa la funcion que corresponde
if($flag == 1){
    $_infoOficiosControler = new infoOficios_Controller();   //nuevo objeto de la clase
    $_infoOficiosControler->InsertarArchivoSalida($imagen,$nombre_orig,$id);
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Archivo para controlar el comportamiento de la logica en la tabla info oficios
 *Conecta con el html y con el DAO info oficios para hacer las consultas
 * @author Stuart
 */
class infoOficios_Controller {
    
   
    /*Funcion para insertar los archivos que vengan como recibidos a los oficios de salida
        recive: $imagen con la ruta del archivo, $nombre_orig con la extencion del archivo, $id el id del oficio
     * no retorna nada     */
    public function InsertarArchivoSalida ($imagen,$nombre_orig,$id){
        
        $DAO_InfoOficios = new DAO_infoOficios();
        
        $archivos_disp_ar = array('pdf','doc','docx');
                $carpeta = 'imagenes/oficios_out/';
                $array_nombre = explode('.',$nombre_orig);
                $cuenta_arr_nombre = count($array_nombre);
                $extension = strtolower($array_nombre[--$cuenta_arr_nombre]);

                      //validamos la extension
                      if(!in_array($extension, $archivos_disp_ar)) {$error = "Este tipo de archivo no es permitido";}

                      if(empty($error)){

                        //creamos nuevo nombre para que tenga nombre unico
                        $nombre_nuevo = time().'_'.rand(0,10).'.'.$extension;
						//echo $nombre_nuevo;
                        //nombre nuevo con la carpeta
                        $nombre_nuevo_con_carpeta = $carpeta.$nombre_nuevo;
                        //por fin movemos el archivo a la carpeta de imagenes
                        $mover_archivos = move_uploaded_file($imagen , $nombre_nuevo_con_carpeta);
                        //de damos permisos 777
                        chmod($nombre_nuevo_con_carpeta,0777);// este hay que comentarlo a la hora de pasarlo a produccion

                        

        $DAO_InfoOficios->ActualizarArchivoSalida($nombre_nuevo,$extension,$id);
        header(sprintf("Location: %s", "listado_oficios_salida.php"));  //Regresa al listado
    }
    }
}
